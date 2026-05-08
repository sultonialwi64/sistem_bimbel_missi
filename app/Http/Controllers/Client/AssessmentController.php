<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\QualityAssessment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tutor_id' => ['required', 'exists:tutors,id'],
            'student_id' => ['required', 'exists:students,id'],
            'schedule_id' => ['required', 'exists:schedules,id'],
            'criteria_scores' => ['required', 'array'],
            'criteria_scores.*' => ['required', 'integer', 'min:1', 'max:5'],
            'overall_score' => ['required', 'integer', 'min:1', 'max:5'],
            'feedback_text' => ['nullable', 'string', 'max:1000'],
        ]);

        // Authorize - check if student belongs to client
        $student = $validated['student_id'];
        if (Auth::user()->client->students()->where('id', $student)->count() === 0) {
            abort(403);
        }

        // Check if already assessed this schedule
        $existing = QualityAssessment::where('schedule_id', $validated['schedule_id'])
            ->where('assessed_by', 'client')
            ->first();
        
        if ($existing) {
            return redirect()->back()
                ->with('info', 'Anda sudah memberikan penilaian untuk sesi ini.');
        }

        $isPositive = $validated['overall_score'] >= 4;
        $requiresFollowup = $validated['overall_score'] < 3;

        QualityAssessment::create([
            'tutor_id' => $validated['tutor_id'],
            'student_id' => $validated['student_id'],
            'schedule_id' => $validated['schedule_id'],
            'criteria_scores' => $validated['criteria_scores'],
            'overall_score' => $validated['overall_score'],
            'feedback_text' => $validated['feedback_text'] ?? null,
            'assessed_by' => 'client',
            'assessor_id' => Auth::id(),
            'is_positive' => $isPositive,
            'requires_followup' => $requiresFollowup,
        ]);

        // Update tutor rating
        $this->updateTutorRating($validated['tutor_id']);

        return redirect()->back()
            ->with('success', 'Terima kasih atas penilaian Anda!');
    }

    /**
     * Update tutor's average rating
     */
    private function updateTutorRating(int $tutorId)
    {
        $avgScore = QualityAssessment::where('tutor_id', $tutorId)
            ->avg('overall_score');
        
        $tutor = \App\Models\Tutor::find($tutorId);
        if ($tutor) {
            $tutor->update(['rating_avg' => $avgScore ?? 0]);
        }
    }
}
