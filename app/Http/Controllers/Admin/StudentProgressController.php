<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\SessionReport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentProgressController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(['client.user', 'latestProgress.tutor.user', 'latestProgress.subject'])
            ->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('client.user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $students = $query->paginate(15);

        return view('admin.student-progress.index', compact('students'));
    }

    public function show(Student $student)
    {
        $student->load(['client.user']);
        
        // Progress Summary (Monthly/Periodic)
        $progresses = StudentProgress::where('student_id', $student->id)
            ->with(['subject', 'tutor.user'])
            ->latest('assessment_date')
            ->get();

        // Session Reports (Per Session)
        $sessionReports = SessionReport::where('student_id', $student->id)
            ->with(['schedule.subject', 'tutor.user'])
            ->latest()
            ->paginate(10);

        return view('admin.student-progress.show', compact('student', 'progresses', 'sessionReports'));
    }

    public function exportPdf(Request $request, Student $student)
    {
        $data = $this->buildReportData($request, $student);

        $pdf = Pdf::loadView('admin.student-progress.pdf', $data);

        $safeName = preg_replace('/[\/\\\:*?"<>|]/', '', $student->name); // strip invalid filename chars
        $safeName = preg_replace('/\s+/', '_', trim($safeName));           // spaces → underscore
        $fileName = 'Laporan_Progres_' . $safeName . '_' . $data['month'] . '.pdf';

        if ($request->boolean('preview')) {
            return $pdf->stream($fileName);
        }

        return $pdf->download($fileName);
    }

    public function publicReport(Request $request, Student $student)
    {
        return view('public.student-progress.show', $this->buildReportData($request, $student));
    }

    private function buildReportData(Request $request, Student $student): array
    {
        $student->load(['client.user']);

        $month = $request->input('month', now()->format('Y-m'));
        $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
        $endDate = \Carbon\Carbon::parse($month)->endOfMonth();

        // Match billing: one report row per attended schedule, report data is optional.
        $schedules = Schedule::where('student_id', $student->id)
            ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->whereHas('attendance', function ($query) {
                $query->whereIn('status', ['hadir', 'pindah_lokasi']);
            })
            ->with(['subject', 'tutor.user', 'attendance', 'sessionReport'])
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();

        // Calculate Average Score from this month's sessions.
        $averageScore = $schedules->pluck('sessionReport')->filter()->avg('student_understanding') * 20;

        // Get the latest progress assessment for that month.
        $progress = StudentProgress::where('student_id', $student->id)
            ->whereBetween('assessment_date', [$startDate, $endDate])
            ->with(['subject', 'tutor.user'])
            ->latest('assessment_date')
            ->first();

        // If no progress for that month, fallback to the latest one available before end date.
        if (! $progress) {
            $progress = StudentProgress::where('student_id', $student->id)
                ->where('assessment_date', '<=', $endDate)
                ->with(['subject', 'tutor.user'])
                ->latest('assessment_date')
                ->first();
        }

        return compact('student', 'schedules', 'averageScore', 'progress', 'month', 'startDate', 'endDate');
    }
}
