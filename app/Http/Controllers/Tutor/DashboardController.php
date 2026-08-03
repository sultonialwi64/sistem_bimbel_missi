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

                    return ($freshSessions * config('bimbel.salary.session_rate_tutor', 40000)) + $salary->bonus - $salary->deduction;
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

        // Fetch students taught this month for the Monthly Completion widget
        $schedulesThisMonth = Schedule::where('tutor_id', $tutor->id)
            ->whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->whereHas('attendance', fn ($q) => $q->whereIn('status', ['hadir', 'pindah_lokasi']))
            ->with(['student.client.user'])
            ->get();
            
        $studentIds = $schedulesThisMonth->pluck('student_id')->unique();
        
        $completions = \App\Models\TutorMonthlyCompletion::where('tutor_id', $tutor->id)
            ->whereIn('student_id', $studentIds)
            ->where('period_start', now()->startOfMonth()->format('Y-m-d'))
            ->get()
            ->keyBy('student_id');

        $studentsThisMonth = $schedulesThisMonth->groupBy('student_id')
            ->map(function ($schedules) use ($completions) {
                $student = $schedules->first()->student;
                $student->sessions_count = $schedules->count();
                
                $completion = $completions->get($student->id);
                $student->is_monthly_completed = $completion ? $completion->is_completed : false;
                
                return $student;
            })
            ->values();

        return view('tutor.dashboard', compact('stats', 'todaySchedules', 'upcomingSchedules', 'recentSessions', 'studentsThisMonth'));
    }

    public function markMonthlyCompleted(\Illuminate\Http\Request $request, \App\Models\Student $student)
    {
        $tutor = Auth::user()->tutor;
        
        if (!$tutor) {
            abort(403);
        }

        \App\Models\TutorMonthlyCompletion::updateOrCreate(
            [
                'tutor_id' => $tutor->id,
                'student_id' => $student->id,
                'period_start' => now()->startOfMonth()->format('Y-m-d'),
            ],
            [
                'is_completed' => true,
                'completed_at' => now(),
            ]
        );

        return back()->with('success', 'Laporan bulan ini untuk murid ' . $student->name . ' berhasil ditandai selesai.');
    }
}
