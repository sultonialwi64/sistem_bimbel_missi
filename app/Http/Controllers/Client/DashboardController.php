<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{Student, Schedule, Payment, SessionReport, StudentProgress};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $students = $client->students()->where('is_active', true)->get();

        $stats = [
            'total_children' => $students->count(),
            'upcoming_sessions' => Schedule::whereIn('student_id', $students->pluck('id'))
                ->where('date', '>=', today())
                ->where('status', 'scheduled')
                ->count(),
            'pending_payments' => Payment::whereIn('student_id', $client->students()->pluck('id'))
                ->whereIn('status', ['pending', 'overdue'])
                ->count(),
            'total_reports' => SessionReport::whereIn('student_id', $students->pluck('id'))->count(),
        ];

        $upcomingSchedules = Schedule::with(['tutor.user', 'subject'])
            ->whereIn('student_id', $students->pluck('id'))
            ->where('date', '>=', today())
            ->where('status', 'scheduled')
            ->orderBy('date')
            ->take(5)
            ->get();

        $recentReports = SessionReport::with(['tutor.user', 'student'])
            ->whereIn('student_id', $students->pluck('id'))
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::whereIn('student_id', $students->pluck('id'))
            ->latest()
            ->take(5)
            ->get();

        return view('client.dashboard', compact('stats', 'students', 'upcomingSchedules', 'recentReports', 'recentPayments'));
    }
}
