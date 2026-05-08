<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\SessionReport;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $client = Auth::user()->client;
        $studentIds = $client->students()->pluck('id');
        
        $reports = SessionReport::whereIn('student_id', $studentIds)
            ->with(['tutor.user', 'student', 'schedule.subject'])
            ->latest()
            ->paginate(15);
        
        return view('client.reports.index', compact('reports'));
    }

    public function show(SessionReport $report)
    {
        // Authorize - only parent of the student can view
        $client = Auth::user()->client;
        if (!$client || $report->student->client_id != $client->id) {
            abort(403, 'Unauthorized access: Laporan ini bukan milik Anda.');
        }
        
        $report->load(['tutor.user', 'student', 'schedule.subject']);
        return view('client.reports.show', compact('report'));
    }

    public function submitFeedback(\Illuminate\Http\Request $request, SessionReport $report)
    {
        $client = Auth::user()->client;
        if (!$client || $report->student->client_id != $client->id) {
            abort(403, 'Unauthorized access: Laporan ini bukan milik Anda.');
        }

        $validated = $request->validate([
            'parent_rating' => 'required|integer|min:1|max:5',
            'parent_feedback' => 'nullable|string|max:1000',
        ]);

        $report->update([
            'parent_rating' => $validated['parent_rating'],
            'parent_feedback' => $validated['parent_feedback'] ?? null,
        ]);

        // Update Tutor average rating
        $tutor = $report->tutor;
        $avg = \App\Models\SessionReport::where('tutor_id', $tutor->id)
            ->whereNotNull('parent_rating')
            ->avg('parent_rating');
        
        $tutor->update([
            'rating_avg' => $avg ?? 0
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}
