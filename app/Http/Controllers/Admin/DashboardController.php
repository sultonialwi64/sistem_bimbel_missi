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

        $currentStats = $this->getMonthlyStats($financialStart, $financialEnd);
        $prevStats = $this->getMonthlyStats($financialStart->copy()->subMonth()->startOfMonth(), $financialStart->copy()->subMonth()->endOfMonth());

        $growth = [
            'revenue' => $prevStats['revenue'] > 0 ? round((($currentStats['revenue'] - $prevStats['revenue']) / $prevStats['revenue']) * 100, 1) : ($currentStats['revenue'] > 0 ? 100 : 0),
            'sessions' => $prevStats['total_schedules'] > 0 ? round((($currentStats['total_schedules'] - $prevStats['total_schedules']) / $prevStats['total_schedules']) * 100, 1) : ($currentStats['total_schedules'] > 0 ? 100 : 0),
            'net_income' => $prevStats['net_income'] > 0 ? round((($currentStats['net_income'] - $prevStats['net_income']) / $prevStats['net_income']) * 100, 1) : ($currentStats['net_income'] > 0 ? 100 : 0),
        ];

        $stats = [
            'total_tutors' => Tutor::count(),
            'active_tutors' => Tutor::where('status', 'active')->count(),
            'total_clients' => Client::count(),
            'total_students' => Student::where('is_active', true)->count(),
            'total_schedules' => Schedule::count(),
            'today_schedules' => Schedule::whereDate('date', today())->count(),
            'this_month_schedules' => $currentStats['total_schedules'],
            'average_daily_schedules' => round($currentStats['total_schedules'] / $financialDate->daysInMonth, 1),
            'pending_payments' => max(0, $currentStats['expected_gross'] - $currentStats['revenue']),
            'monthly_revenue' => $currentStats['revenue'],
            'net_income' => $currentStats['net_income'],
            'net_income_sessions' => $currentStats['valid_sessions'],
            'net_income_rate' => null, // Dinamis
            'growth' => $growth,
        ];

        // Top Subjects (Donut Chart)
        $topSubjectsDb = Schedule::whereBetween('schedules.date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->where('schedules.status', 'completed')
            ->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->join('grade_levels', 'subjects.grade_level_id', '=', 'grade_levels.id')
            ->selectRaw('CONCAT(subjects.name, " - ", grade_levels.name) as name, count(*) as count')
            ->groupBy('subjects.id', 'subjects.name', 'grade_levels.name')
            ->orderByDesc('count')
            ->take(5)
            ->get();
            
        $topSubjects = [
            'labels' => $topSubjectsDb->pluck('name'),
            'series' => $topSubjectsDb->pluck('count')
        ];

        // Top 5 Tutors (Leaderboard) - Berdasarkan sesi yang sudah diabsen (seperti di Salary)
        $topTutors = Schedule::whereBetween('schedules.date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->whereHas('attendance', function ($query) {
                $query->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->join('tutors', 'schedules.tutor_id', '=', 'tutors.id')
            ->join('users', 'tutors.user_id', '=', 'users.id')
            ->selectRaw('tutors.id as tutor_id, users.name as tutor_name, count(*) as count')
            ->groupBy('tutors.id', 'users.name')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);
        $topTutors->map(function ($tutor) use ($financialStart, $tutorRatePerSession) {
            $salary = \App\Models\Salary::where('tutor_id', $tutor->tutor_id)
                ->where('period_start', $financialStart->format('Y-m-d'))
                ->first();
                
            $baseSalary = $tutor->count * $tutorRatePerSession;
            
            if ($salary) {
                $tutor->income = $baseSalary + $salary->bonus - $salary->deduction;
            } else {
                $tutor->income = $baseSalary;
            }
            return $tutor;
        });

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
            $carbon = \Carbon\Carbon::parse($date)->locale('id');
            return [
                $carbon->format('d M'),
                $carbon->translatedFormat('l')
            ];
        }, array_keys($dailySessions));

        $fullDates = array_map(function($date) {
            $carbon = \Carbon\Carbon::parse($date)->locale('id');
            return $carbon->translatedFormat('l, d F Y');
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
            'full_dates' => $fullDates,
            'daily_sessions' => array_values($dailySessions),
            'tutor_series' => $chart2Series
        ];

        $recentPayments = Payment::with(['client.user', 'student'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentPayments', 'chartData', 'financialMonth', 'topSubjects', 'topTutors'));
    }

    private function getMonthlyStats(Carbon $start, Carbon $end)
    {
        $invoiceDueStart = $start->copy()->addDays(7);
        $invoiceDueEnd = $end->copy()->addDays(7);

        $validStudentCounts = Schedule::whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])
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
                    
                    $margin = $client->company_margin ?? 10000;
                    $netIncome += ($count * $margin);
                }
            }
        }

        $monthlyRevenue = Payment::where('status', 'paid')
            ->whereBetween('due_date', [$invoiceDueStart->format('Y-m-d'), $invoiceDueEnd->format('Y-m-d')])
            ->sum('amount');

        $totalSchedules = Schedule::whereBetween('date', [$start->format('Y-m-d'), $end->format('Y-m-d')])->count();

        return [
            'revenue' => $monthlyRevenue,
            'expected_gross' => $expectedGrossRevenue,
            'net_income' => max(0, $netIncome - $realtimeTotalDiscount),
            'valid_sessions' => $validSessionsCount,
            'total_schedules' => $totalSchedules,
        ];
    }
}
