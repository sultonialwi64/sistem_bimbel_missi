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

        $validSessionsThisMonth = Schedule::with('student.client')
            ->whereBetween('date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->where('status', 'completed')
            ->whereHas('attendance', function ($q) {
                $q->whereIn('status', ['hadir', 'pindah_lokasi']);
            })->get();

        // Calculate real-time Expected Gross Revenue and Discounts
        $expectedGrossRevenue = 0;
        $realtimeTotalDiscount = 0;
        $sessionsByStudent = $validSessionsThisMonth->groupBy('student_id');
        
        foreach ($sessionsByStudent as $studentId => $sessions) {
            $count = $sessions->count();
            $client = $sessions->first()->student->client;
            if ($client) {
                $baseAmount = $count * $client->session_price;
                $threshold = config('bimbel.discount.threshold', 8);
                $discountMultiplier = floor($count / $threshold);
                $discount = $discountMultiplier * $client->discount;
                
                $expectedGrossRevenue += ($baseAmount - $discount);
                $realtimeTotalDiscount += $discount;
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
        ];

        // Pendapatan bersih perusahaan bulan ini
        // = jumlah sesi terlaksana (kehadiran terverifikasi) × margin perusahaan per sesi
        $netIncome = $validSessionsThisMonth->sum(function ($schedule) {
            return $schedule->student->client->company_margin ?? 10000;
        });

        $stats['net_income'] = max(0, $netIncome - $realtimeTotalDiscount);
        $stats['net_income_sessions'] = $validSessionsThisMonth->count();
        $stats['net_income_rate'] = null; // Dinamis

        // Prepare chart data using ALL schedules (not just completed/absen ones) as requested by user
        $allSessionsThisMonth = Schedule::with('tutor.user')
            ->whereBetween('date', [$financialStart->format('Y-m-d'), $financialEnd->format('Y-m-d')])
            ->get();

        $dailySessions = [];
        $tutorDailySessions = [];
        
        $daysInMonth = \Carbon\Carbon::parse($financialMonth)->daysInMonth;
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $dateStr = \Carbon\Carbon::parse($financialMonth)->format('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
            $dailySessions[$dateStr] = 0;
        }

        foreach ($allSessionsThisMonth as $session) {
            $dateStr = \Carbon\Carbon::parse($session->date)->format('Y-m-d');
            $tutorName = $session->tutor->user->name ?? 'Unknown';

            if (isset($dailySessions[$dateStr])) {
                $dailySessions[$dateStr]++;
            }

            if (!isset($tutorDailySessions[$tutorName])) {
                $tutorDailySessions[$tutorName] = array_fill_keys(array_keys($dailySessions), 0);
            }
            if (isset($tutorDailySessions[$tutorName][$dateStr])) {
                $tutorDailySessions[$tutorName][$dateStr]++;
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
