<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\{SessionReport, Schedule, StudentProgress};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $tutor = Auth::user()->tutor;
        
        $reports = SessionReport::where('tutor_id', $tutor->id)
            ->with(['student', 'schedule'])
            ->latest()
            ->paginate(10);
        
        return view('tutor.reports.index', compact('reports'));
    }

    public function create(Schedule $schedule)
    {
        // Authorize
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) {
            abort(403, 'Unauthorized access: Jadwal ini bukan milik Anda.');
        }

        // Check if already has report
        $existingReport = SessionReport::where('schedule_id', $schedule->id)->first();
        if ($existingReport) {
            return redirect()->route('tutor.reports.show', $existingReport)
                ->with('info', 'Laporan sudah dibuat untuk jadwal ini.');
        }

        $schedule->load(['student', 'subject']);
        return view('tutor.reports.create', compact('schedule'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,id'],
            'material_covered' => ['required', 'string'],
            'student_understanding' => ['required', 'integer', 'min:1', 'max:5'],
            'notes_for_parent' => ['nullable', 'string'],
            'tutor_rating_by_student' => ['nullable', 'integer', 'min:1', 'max:5'],
        ]);

        $schedule = Schedule::findOrFail($validated['schedule_id']);

        // Authorize
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) {
            abort(403, 'Unauthorized access: Jadwal ini bukan milik Anda.');
        }

        $existingReport = SessionReport::where('schedule_id', $schedule->id)->first();
        if ($existingReport) {
            return redirect()->route('tutor.reports.show', $existingReport)
                ->with('info', 'Laporan sudah dibuat untuk jadwal ini.');
        }

        $report = SessionReport::create([
            'schedule_id' => $validated['schedule_id'],
            'tutor_id' => $schedule->tutor_id,
            'student_id' => $schedule->student_id,
            'material_covered' => $validated['material_covered'],
            'student_understanding' => $validated['student_understanding'],
            'notes_for_parent' => $validated['notes_for_parent'] ?? null,
            'tutor_rating_by_student' => $validated['tutor_rating_by_student'] ?? null,
        ]);

        return redirect()->route('tutor.reports.index')
            ->with('success', 'Laporan sesi berhasil dibuat!');
    }

    public function show(SessionReport $report)
    {
        $report->load(['tutor.user', 'student', 'schedule.subject']);
        return view('tutor.reports.show', compact('report'));
    }

}
