<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Payment;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Tutor;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tutors' => Tutor::count(),
            'active_tutors' => Tutor::where('status', 'active')->count(),
            'total_clients' => Client::count(),
            'total_students' => Student::where('is_active', true)->count(),
            'total_schedules' => Schedule::count(),
            'today_schedules' => Schedule::whereDate('date', today())->count(),
            'pending_payments' => Payment::where('status', 'pending')->sum('amount'),
            'monthly_revenue' => Payment::where('status', 'paid')
                ->whereMonth('payment_date', now()->month)
                ->sum('amount'),
        ];

        // Pendapatan bersih perusahaan bulan ini
        // = jumlah sesi terlaksana (kehadiran terverifikasi) × margin perusahaan per sesi (berdasarkan tipe klien)
        $validSessionsThisMonth = Schedule::with('student.client')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'completed')
            ->whereHas('attendance', function ($q) {
                $q->whereIn('status', ['hadir', 'pindah_lokasi']);
            })->get();

        $netIncome = $validSessionsThisMonth->sum(function ($schedule) {
            return $schedule->student->client->company_margin ?? 10000;
        });

        $stats['net_income'] = $netIncome;
        $stats['net_income_sessions'] = $validSessionsThisMonth->count();
        $stats['net_income_rate'] = null; // Dinamis

        $recentSchedules = Schedule::with(['tutor.user', 'student', 'subject'])
            ->latest()
            ->take(10)
            ->get();

        $recentPayments = Payment::with(['client.user', 'student'])
            ->latest()
            ->take(10)
            ->get();

        $topTutors = Tutor::with('user')
            ->where('status', 'active')
            ->orderBy('rating_avg', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentSchedules', 'recentPayments', 'topTutors'));
    }
}
