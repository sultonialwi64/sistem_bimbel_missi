<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;

        if (! $tutor) {
            Auth::logout();

            return redirect()->route('login')->with('error', 'Akun Anda tidak memiliki profil tutor yang valid. Silakan hubungi admin.');
        }

        $tutorRatePerSession = config('bimbel.salary.session_rate_tutor', 40000);

        // Hitung sesi terlaksana bulan ini berdasarkan kehadiran tentor (konsisten dengan logic penggajian)
        $sessionsThisMonth = Schedule::where('tutor_id', $tutor->id)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
            ->count();

        $monthlyEarnings = $sessionsThisMonth * $tutorRatePerSession;

        $stats = [
            'total_sessions' => $tutor->total_sessions,
            'rating_avg' => $tutor->rating_avg,
            'pending_salary' => Salary::where('tutor_id', $tutor->id)
                ->whereIn('status', ['pending', 'unpaid'])
                ->get()
                ->sum(function ($salary) use ($tutor) {
                    $freshSessions = Schedule::where('tutor_id', $tutor->id)
                        ->whereBetween('date', [$salary->period_start->format('Y-m-d'), $salary->period_end->format('Y-m-d')])
                        ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
                        ->count();

                    return ($freshSessions * $salary->rate_per_session) + $salary->bonus - $salary->deduction;
                }),
            'completed_sessions' => Schedule::where('tutor_id', $tutor->id)
                ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
                ->count(),
            'sessions_this_month' => $sessionsThisMonth,
            'monthly_earnings' => $monthlyEarnings,
            'reports_pending' => Schedule::where('tutor_id', $tutor->id)
                ->where('status', 'completed')
                ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
                ->whereDoesntHave('sessionReport')
                ->count(),
        ];

        $todaySchedules = Schedule::with(['student', 'subject'])
            ->where('tutor_id', $tutor->id)
            ->whereDate('date', today())
            ->get();

        $upcomingSchedules = Schedule::with(['student', 'subject'])
            ->where('tutor_id', $tutor->id)
            ->where('date', '>', today())
            ->where('status', 'scheduled')
            ->orderBy('date')
            ->take(5)
            ->get();

        $recentSessions = Schedule::with(['student', 'subject', 'sessionReport'])
            ->where('tutor_id', $tutor->id)
            ->where('status', 'completed')
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->take(5)
            ->get();

        return view('tutor.dashboard', compact('stats', 'todaySchedules', 'upcomingSchedules', 'recentSessions'));
    }
}
