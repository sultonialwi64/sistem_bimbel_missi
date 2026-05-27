<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{User, Tutor, Client, Student, Schedule, Attendance, Payment, Salary};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        // Hitung estimasi profit bulan ini
        // Pemasukan: semua tagihan yang ter-generate bulan ini (termasuk yang belum dibayar)
        $projectedRevenue = Payment::whereMonth('created_at', now()->month)->sum('amount');
        
        // Pengeluaran: total sesi valid bulan ini dikali rate tutor
        $tutorRate = config('bimbel.salary.session_rate_tutor', 40000);
        $validSessionsThisMonth = Schedule::whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'completed')
            ->whereHas('attendance', function($q) {
                $q->whereIn('status', ['hadir', 'pindah_lokasi']);
            })->count();
        
        $projectedExpenses = $validSessionsThisMonth * $tutorRate;
        $stats['estimated_profit'] = $projectedRevenue - $projectedExpenses;
        $stats['projected_revenue'] = $projectedRevenue;
        $stats['projected_expenses'] = $projectedExpenses;

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
