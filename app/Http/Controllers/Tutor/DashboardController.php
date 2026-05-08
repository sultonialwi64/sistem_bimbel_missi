<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\{Schedule, Attendance, SessionReport, Salary};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;

        $stats = [
            'total_sessions'     => $tutor->total_sessions,
            'rating_avg'         => $tutor->rating_avg,
            'pending_salary'     => Salary::where('tutor_id', $tutor->id)
                ->where('status', 'pending')
                ->sum('total_amount'),
            'completed_sessions' => Schedule::where('tutor_id', $tutor->id)
                ->where('status', 'completed')
                ->count(),
            'sessions_this_month' => $sessionsThisMonth = Schedule::where('tutor_id', $tutor->id)
                ->where('status', 'completed')
                ->whereYear('date', now()->year)
                ->whereMonth('date', now()->month)
                ->count(),
            'monthly_earnings'   => $sessionsThisMonth * (Salary::where('tutor_id', $tutor->id)->latest()->value('rate_per_session') ?? 0),
            'reports_pending'    => Schedule::where('tutor_id', $tutor->id)
                ->where('status', 'completed')
                ->whereHas('attendance', fn($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
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
