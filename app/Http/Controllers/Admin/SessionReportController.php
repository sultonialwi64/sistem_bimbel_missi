<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SessionReport;
use Illuminate\Http\Request;

class SessionReportController extends Controller
{
    public function index(Request $request)
    {
        $query = SessionReport::with(['tutor.user', 'student.client.user', 'schedule.subject']);

        if ($request->has('tutor_id') && $request->tutor_id != '') {
            $query->where('tutor_id', $request->tutor_id);
        }

        if ($request->has('student_id') && $request->student_id != '') {
            $query->where('student_id', $request->student_id);
        }

        $reports = $query->latest()->paginate(15);

        // Required for filters if we add them later
        $tutors = \App\Models\Tutor::with('user')->get();
        $students = \App\Models\Student::all();

        return view('admin.session_reports.index', compact('reports', 'tutors', 'students'));
    }

    public function show(SessionReport $sessionReport)
    {
        $sessionReport->load(['tutor.user', 'student.client.user', 'schedule.subject', 'schedule.attendance']);
        return view('admin.session_reports.show', compact('sessionReport'));
    }
}
