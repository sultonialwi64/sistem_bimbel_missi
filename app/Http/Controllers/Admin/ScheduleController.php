<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Schedule, Student, Tutor, Subject};
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['tutor.user', 'student.client', 'subject', 'createdBy'])
            ->latest()
            ->paginate(15);
            
        // Get all schedules for the calendar view
        $allSchedules = Schedule::with(['tutor.user', 'student', 'subject'])->get();
        
        $tutors = Tutor::where('status', 'active')->get();
        $students = Student::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        
        return view('admin.schedules.index', compact('schedules', 'allSchedules', 'tutors', 'students', 'subjects'));
    }

    public function create()
    {
        $tutors = Tutor::where('status', 'active')->get();
        $students = Student::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        
        return view('admin.schedules.create', compact('tutors', 'students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'tutor_id' => ['required', 'exists:tutors,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'scheduled';

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(['tutor.user', 'student.client', 'subject', 'attendance', 'sessionReport']);
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $tutors = Tutor::where('status', 'active')->get();
        $students = Student::where('is_active', true)->get();
        $subjects = Subject::where('is_active', true)->get();
        
        return view('admin.schedules.edit', compact('schedule', 'tutors', 'students', 'subjects'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'tutor_id' => ['required', 'exists:tutors,id'],
            'subject_id' => ['required', 'exists:subjects,id'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'status' => ['required', 'in:scheduled,completed,cancelled,rescheduled'],
            'notes' => ['nullable', 'string'],
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
}
