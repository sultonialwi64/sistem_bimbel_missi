<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $tutor = Auth::user()->tutor;

        // Needed for FullCalendar
        $allSchedules = Schedule::with(['student', 'subject', 'attendance', 'sessionReport'])
            ->where('tutor_id', $tutor->id)
            ->get();

        // Needed for List View
        $schedules = Schedule::with(['student', 'subject', 'attendance', 'sessionReport'])
            ->where('tutor_id', $tutor->id)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('tutor.schedules.index', compact('schedules', 'allSchedules'));
    }

    public function create()
    {
        // Ambil semua murid yang aktif dan semua subject
        $students = Student::where('is_active', true)->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('tutor.schedules.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $tutorId = Auth::user()->tutor->id;

        // Validation 1: Cek jadwal tutor bentrok
        $tutorConflict = Schedule::where('tutor_id', $tutorId)
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->where('status', 'scheduled')
            ->exists();

        if ($tutorConflict) {
            return back()->withInput()->withErrors(['time_conflict' => 'Anda sudah memiliki jadwal mengajar di jam tersebut!']);
        }

        // Validation 2: Cek jadwal murid bentrok
        $studentConflict = Schedule::where('student_id', $validated['student_id'])
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->where('status', 'scheduled')
            ->exists();

        if ($studentConflict) {
            return back()->withInput()->withErrors(['time_conflict' => 'Murid ini sudah memiliki jadwal bimbel di jam tersebut (dengan tutor lain)!']);
        }

        Schedule::create([
            'tutor_id' => $tutorId,
            'student_id' => $validated['student_id'],
            'subject_id' => $validated['subject_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => 'scheduled',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('tutor.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(Schedule $schedule)
    {
        $tutor = Auth::user()->tutor;
        
        if (!$tutor || $schedule->tutor_id != $tutor->id) {
            abort(403, 'Unauthorized access: Jadwal ini bukan milik Anda.');
        }

        $schedule->load(['student.client', 'subject', 'attendance', 'sessionReport']);
        return view('tutor.schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) abort(403);
        if ($schedule->status !== 'scheduled') {
            return redirect()->route('tutor.schedules.index')->with('error', 'Hanya jadwal yang masih berstatus Scheduled yang dapat diedit.');
        }

        $students = Student::where('is_active', true)->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('tutor.schedules.edit', compact('schedule', 'students', 'subjects'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) abort(403);
        if ($schedule->status !== 'scheduled') {
            return redirect()->route('tutor.schedules.index')->with('error', 'Hanya jadwal yang masih berstatus Scheduled yang dapat diedit.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $tutorId = Auth::user()->tutor->id;

        // Validation 1: Cek jadwal tutor bentrok (exclude jadwal ini sendiri)
        $tutorConflict = Schedule::where('id', '!=', $schedule->id)
            ->where('tutor_id', $tutorId)
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->where('status', 'scheduled')
            ->exists();

        if ($tutorConflict) {
            return back()->withInput()->withErrors(['time_conflict' => 'Anda sudah memiliki jadwal mengajar lain di jam tersebut!']);
        }

        // Validation 2: Cek jadwal murid bentrok (exclude jadwal ini sendiri)
        $studentConflict = Schedule::where('id', '!=', $schedule->id)
            ->where('student_id', $validated['student_id'])
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->where('status', 'scheduled')
            ->exists();

        if ($studentConflict) {
            return back()->withInput()->withErrors(['time_conflict' => 'Murid ini sudah memiliki jadwal bimbel di jam tersebut!']);
        }

        $schedule->update([
            'student_id' => $validated['student_id'],
            'subject_id' => $validated['subject_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        return redirect()->route('tutor.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) {
            abort(403, 'Unauthorized access: Jadwal ini bukan milik Anda.');
        }

        if ($schedule->status != 'scheduled') {
            return redirect()->route('tutor.schedules.index')->with('error', 'Hanya jadwal yang masih berstatus Scheduled yang dapat dihapus.');
        }

        $schedule->delete();

        return redirect()->route('tutor.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
