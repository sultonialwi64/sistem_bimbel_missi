<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{Student, SessionReport};
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $students = $client->students()->where('is_active', true)->get();

        return view('client.progress.index', compact('students'));
    }

    public function show(Student $student)
    {
        // Authorize
        $client = Auth::user()->client;
        if (!$client || $student->client_id != $client->id) {
            abort(403, 'Unauthorized access: Data ini bukan milik Anda.');
        }

        // Get all session reports with subject info
        $allReports = SessionReport::where('student_id', $student->id)
            ->with(['schedule.subject', 'tutor.user'])
            ->latest()
            ->get();

        // Group by subject and calculate stats per subject
        $subjectStats = $allReports->groupBy(fn($r) => $r->schedule->subject->name ?? 'Lainnya')
            ->map(function ($reports, $subjectName) {
                $avg = $reports->avg('student_understanding');
                return [
                    'subject_name'   => $subjectName,
                    'avg_score'      => round($avg, 1),
                    'avg_pct'        => round($avg * 20),
                    'total_sessions' => $reports->count(),
                    'last_session'   => $reports->first()->created_at,
                    'reports'        => $reports,
                ];
            })
            ->sortByDesc('last_session');

        // Latest 10 session reports across all subjects
        $recentReports = $allReports->take(10);

        return view('client.progress.show', compact('student', 'subjectStats', 'recentReports'));
    }
}
