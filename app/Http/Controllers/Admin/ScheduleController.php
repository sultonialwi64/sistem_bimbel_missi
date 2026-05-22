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

        $repeatWeeks = intval($request->input('repeat_weeks', 0));
        
        $baseDate = \Carbon\Carbon::parse($validated['date']);
        $datesToCreate = [];
        
        for ($i = 0; $i <= $repeatWeeks; $i++) {
            $datesToCreate[] = $baseDate->copy()->addWeeks($i)->format('Y-m-d');
        }

        $conflicts = [];

        foreach ($datesToCreate as $date) {
            // Cek jadwal tutor bentrok
            $tutorConflict = Schedule::where('tutor_id', $validated['tutor_id'])
                ->where('date', $date)
                ->where(function($query) use ($validated) {
                    $query->where(function($q) use ($validated) {
                        $q->where('start_time', '<', $validated['end_time'])
                          ->where('end_time', '>', $validated['start_time']);
                    });
                })
                ->where('status', 'scheduled')
                ->exists();

            if ($tutorConflict) {
                $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
                $conflicts[] = "Tutor sudah memiliki jadwal mengajar pada tanggal {$formattedDate} di jam tersebut.";
            }

            // Cek jadwal murid bentrok
            $studentConflict = Schedule::where('student_id', $validated['student_id'])
                ->where('date', $date)
                ->where(function($query) use ($validated) {
                    $query->where(function($q) use ($validated) {
                        $q->where('start_time', '<', $validated['end_time'])
                          ->where('end_time', '>', $validated['start_time']);
                    });
                })
                ->where('status', 'scheduled')
                ->exists();

            if ($studentConflict) {
                $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
                $conflicts[] = "Murid sudah memiliki jadwal bimbel pada tanggal {$formattedDate} di jam tersebut.";
            }
        }

        if (!empty($conflicts)) {
            array_unshift($conflicts, 'Gagal membuat jadwal karena terdapat bentrok waktu.');
            return back()->withInput()->withErrors(['time_conflict' => $conflicts]);
        }

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'scheduled';

        \Illuminate\Support\Facades\DB::transaction(function () use ($datesToCreate, $validated) {
            foreach ($datesToCreate as $date) {
                $scheduleData = $validated;
                $scheduleData['date'] = $date;
                Schedule::create($scheduleData);
            }
        });

        $message = $repeatWeeks > 0 
            ? 'Jadwal berulang berhasil ditambahkan (' . count($datesToCreate) . ' sesi)!' 
            : 'Jadwal berhasil ditambahkan!';

        return redirect()->route('admin.schedules.index')
            ->with('success', $message);
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
