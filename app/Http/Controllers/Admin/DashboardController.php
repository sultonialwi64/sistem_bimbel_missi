<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $financialMonth = $request->input('financial_month', now()->format('Y-m'));
        $financialDate = Carbon::parse($financialMonth);
        $financialStart = $financialDate->copy()->startOfMonth();
        $financialEnd = $financialDate->copy()->endOfMonth();
        $invoiceDueStart = $financialStart->copy()->addDays(7);
        $invoiceDueEnd = $financialEnd->copy()->addDays(7);

        // 1. Hitung omset, diskon, dan net income dengan Aggregate Query
        $validStudentCounts = Schedule::whereBetween('date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->where('status', 'completed')
            ->whereHas('attendance', function ($q) {
                $q->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->selectRaw('student_id, count(*) as count')
            ->groupBy('student_id')
            ->get();

        $validSessionsCount = 0;
        $expectedGrossRevenue = 0;
        $realtimeTotalDiscount = 0;
        $netIncome = 0;

        if ($validStudentCounts->isNotEmpty()) {
            $studentIds = $validStudentCounts->pluck('student_id');
            // Hanya load Student dan Client yang ada sesinya saja
            $students = Student::with('client')->whereIn('id', $studentIds)->get()->keyBy('id');

            foreach ($validStudentCounts as $item) {
                $count = $item->count;
                $validSessionsCount += $count;
                $student = $students->get($item->student_id);
                
                if ($student && $student->client) {
                    $client = $student->client;
                    $baseAmount = $count * $client->session_price;
                    $threshold = config('bimbel.discount.threshold', 8);
                    $discountMultiplier = floor($count / $threshold);
                    $discount = $discountMultiplier * $client->discount;
                    
                    $expectedGrossRevenue += ($baseAmount - $discount);
                    $realtimeTotalDiscount += $discount;
                    
                    // Net income
                    $margin = $client->company_margin ?? 10000;
                    $netIncome += ($count * $margin);
                }
            }
        }

        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereBetween('due_date', [$invoiceDueStart->format('Y-m-d'), $invoiceDueEnd->format('Y-m-d')])
            ->sum('amount');
            
        $pendingPayments = max(0, $expectedGrossRevenue - $monthlyRevenue);

        $stats = [
            'total_tutors' => Tutor::count(),
            'active_tutors' => Tutor::where('status', 'active')->count(),
            'total_clients' => Client::count(),
            'total_students' => Student::where('is_active', true)->count(),
            'total_schedules' => Schedule::count(),
            'today_schedules' => Schedule::whereDate('date', today())->count(),
            'pending_payments' => $pendingPayments,
            'monthly_revenue' => $monthlyRevenue,
            'net_income' => max(0, $netIncome - $realtimeTotalDiscount),
            'net_income_sessions' => $validSessionsCount,
            'net_income_rate' => null, // Dinamis
        ];

        // 2. Prepare chart data using DB Aggregates (ALL schedules)
        $dailySessionsDb = Schedule::whereBetween('date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->selectRaw('date, count(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $tutorDailySessionsDb = Schedule::join('tutors', 'schedules.tutor_id', '=', 'tutors.id')
            ->join('users', 'tutors.user_id', '=', 'users.id')
            ->selectRaw('users.name as tutor_name, date, count(*) as count')
            ->whereBetween('schedules.date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->groupBy('users.name', 'date')
            ->get();

        $dailySessions = [];
        $tutorDailySessions = [];
        
        $daysInMonth = \Carbon\Carbon::parse($financialMonth)->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dateStr = \Carbon\Carbon::parse($financialMonth)->format('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $dailySessions[$dateStr] = $dailySessionsDb[$dateStr] ?? 0;
        }

        foreach ($tutorDailySessionsDb as $row) {
            $dateStr = \Carbon\Carbon::parse($row->date)->format('Y-m-d');
            $tutorName = $row->tutor_name;

            if (!isset($tutorDailySessions[$tutorName])) {
                $tutorDailySessions[$tutorName] = array_fill_keys(array_keys($dailySessions), 0);
            }
            if (isset($tutorDailySessions[$tutorName][$dateStr])) {
                $tutorDailySessions[$tutorName][$dateStr] = $row->count;
            }
        }

        $categories = array_map(function($date) {
            return \Carbon\Carbon::parse($date)->format('d M');
        }, array_keys($dailySessions));

        $chart2Series = [];
        foreach ($tutorDailySessions as $tutor => $data) {
            $chart2Series[] = [
                'name' => $tutor,
                'data' => array_values($data)
            ];
        }

        $chartData = [
            'categories' => $categories,
            'daily_sessions' => array_values($dailySessions),
            'tutor_series' => $chart2Series
        ];

        $recentPayments = Payment::with(['client.user', 'student'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPayments', 'chartData', 'financialMonth'));
    }
}
