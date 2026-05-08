<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SessionReport;
use Illuminate\Support\Facades\Auth;

class ChildController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;

        $students = $client->students()
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('client.children.index', compact('students'));
    }

    public function show(Student $student)
    {
        // Authorize - only parent can view their child
        $client = Auth::user()->client;
        if (!$client || $student->client_id != $client->id) {
            abort(403, 'Unauthorized access: Data ini bukan milik Anda.');
        }

        $student->load(['client', 'schedules.subject', 'schedules.tutor.user', 'payments']);

        // Recent session reports (replaces quality assessments)
        $recentReports = SessionReport::where('student_id', $student->id)
            ->with(['schedule.subject', 'tutor.user'])
            ->latest()
            ->take(10)
            ->get();

        // Upcoming sessions
        $upcomingSessions = $student->schedules()
            ->with(['tutor.user', 'subject'])
            ->where('status', 'scheduled')
            ->where('date', '>=', today())
            ->orderBy('date')
            ->take(5)
            ->get();

        return view('client.children.show', compact('student', 'recentReports', 'upcomingSessions'));
    }
}
