<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Services\NotificationService;
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
        $students = Student::where('is_active', true)
            ->whereHas('client', fn ($query) => $query->where('is_active', true))
            ->orderBy('name')
            ->get();
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
        $repeatWeeks = intval($request->input('repeat_weeks', 0));
        
        $baseDate = \Carbon\Carbon::parse($validated['date']);
        $datesToCreate = [];
        
        for ($i = 0; $i <= $repeatWeeks; $i++) {
            $datesToCreate[] = $baseDate->copy()->addWeeks($i)->format('Y-m-d');
        }

        $conflicts = [];

        foreach ($datesToCreate as $date) {
            // Validation 1: Cek jadwal tutor bentrok
            $tutorConflict = Schedule::with('student')->where('tutor_id', $tutorId)
                ->where('date', $date)
                ->where(function($query) use ($validated) {
                    $query->where(function($q) use ($validated) {
                        $q->where('start_time', '<', $validated['end_time'])
                          ->where('end_time', '>', $validated['start_time']);
                    });
                })
                ->whereIn('status', ['scheduled', 'completed'])
                ->first();

            if ($tutorConflict) {
                $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
                $conflictTime = \Carbon\Carbon::parse($tutorConflict->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($tutorConflict->end_time)->format('H:i');
                $studentName = $tutorConflict->student ? $tutorConflict->student->name : 'Siswa Lain';
                $conflicts[] = "Tabrakan jadwal: Anda sudah memiliki sesi pada {$formattedDate} jam {$conflictTime} (Siswa: {$studentName}).";
            }

            // Validation 2: Cek jadwal murid bentrok
            $studentConflict = Schedule::with('tutor.user')->where('student_id', $validated['student_id'])
                ->where('date', $date)
                ->where(function($query) use ($validated) {
                    $query->where(function($q) use ($validated) {
                        $q->where('start_time', '<', $validated['end_time'])
                          ->where('end_time', '>', $validated['start_time']);
                    });
                })
                ->whereIn('status', ['scheduled', 'completed'])
                ->first();

            if ($studentConflict) {
                $formattedDate = \Carbon\Carbon::parse($date)->translatedFormat('d F Y');
                $conflictTime = \Carbon\Carbon::parse($studentConflict->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($studentConflict->end_time)->format('H:i');
                $tutorName = $studentConflict->tutor && $studentConflict->tutor->user ? $studentConflict->tutor->user->name : 'Tutor Lain';
                $conflicts[] = "Tabrakan jadwal: Murid ini sudah memiliki sesi dengan {$tutorName} pada {$formattedDate} jam {$conflictTime}.";
            }
        }

        if (!empty($conflicts)) {
            array_unshift($conflicts, 'Gagal membuat jadwal berulang karena terdapat bentrok waktu.');
            return back()->withInput()->withErrors(['time_conflict' => $conflicts]);
        }

        $createdSchedules = collect();

        \Illuminate\Support\Facades\DB::transaction(function () use ($datesToCreate, $validated, $tutorId, &$createdSchedules) {
            foreach ($datesToCreate as $date) {
                $createdSchedules->push(Schedule::create([
                    'tutor_id' => $tutorId,
                    'student_id' => $validated['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'date' => $date,
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'status' => 'scheduled',
                    'created_by' => Auth::id(),
                ]));
            }
        });

        if ($createdSchedules->isNotEmpty()) {
            app(NotificationService::class)->notifyAdminsNewSchedule($createdSchedules->first(), $createdSchedules->count());
        }

        $message = $repeatWeeks > 0 
            ? 'Jadwal berulang berhasil ditambahkan (' . count($datesToCreate) . ' sesi).' 
            : 'Jadwal berhasil ditambahkan.';

        return redirect()->route('tutor.schedules.index')->with('success', $message);
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

        $students = Student::where(function ($query) use ($schedule) {
            $query->where(function ($activeQuery) {
                $activeQuery->where('is_active', true)
                    ->whereHas('client', fn ($clientQuery) => $clientQuery->where('is_active', true));
            })->orWhere('id', $schedule->student_id);
        })->orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();

        return view('tutor.schedules.edit', compact('schedule', 'students', 'subjects'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) abort(403);

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $tutorId = Auth::user()->tutor->id;

        // Validation 1: Cek jadwal tutor bentrok (exclude jadwal ini sendiri)
        $tutorConflict = Schedule::with('student')->where('id', '!=', $schedule->id)
            ->where('tutor_id', $tutorId)
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->whereIn('status', ['scheduled', 'completed'])
            ->first();

        if ($tutorConflict) {
            $conflictTime = \Carbon\Carbon::parse($tutorConflict->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($tutorConflict->end_time)->format('H:i');
            $studentName = $tutorConflict->student ? $tutorConflict->student->name : 'Siswa Lain';
            return back()->withInput()->withErrors(['time_conflict' => "Tabrakan jadwal: Anda sudah memiliki sesi pada jam {$conflictTime} (Siswa: {$studentName})."]);
        }

        // Validation 2: Cek jadwal murid bentrok (exclude jadwal ini sendiri)
        $studentConflict = Schedule::with('tutor.user')->where('id', '!=', $schedule->id)
            ->where('student_id', $validated['student_id'])
            ->where('date', $validated['date'])
            ->where(function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->whereIn('status', ['scheduled', 'completed'])
            ->first();

        if ($studentConflict) {
            $conflictTime = \Carbon\Carbon::parse($studentConflict->start_time)->format('H:i') . ' - ' . \Carbon\Carbon::parse($studentConflict->end_time)->format('H:i');
            $tutorName = $studentConflict->tutor && $studentConflict->tutor->user ? $studentConflict->tutor->user->name : 'Tutor Lain';
            return back()->withInput()->withErrors(['time_conflict' => "Tabrakan jadwal: Murid ini sudah memiliki sesi dengan {$tutorName} pada jam {$conflictTime}."]);
        }

        $schedule->update([
            'student_id' => $validated['student_id'],
            'subject_id' => $validated['subject_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);

        // Sinkronisasi data ke laporan sesi jika muridnya diubah
        if ($schedule->sessionReport && $schedule->student_id !== $schedule->sessionReport->student_id) {
            $schedule->sessionReport->update(['student_id' => $schedule->student_id]);
        }

        return redirect()->route('tutor.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Schedule $schedule)
    {
        $tutor = Auth::user()->tutor;
        if (!$tutor || $schedule->tutor_id != $tutor->id) {
            abort(403, 'Unauthorized access: Jadwal ini bukan milik Anda.');
        }

        $schedule->delete();

        return redirect()->route('tutor.schedules.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function missingRecords(Request $request)
    {
        $month = $request->query('month');
        $tutorId = Auth::user()->tutor->id;
        
        $queryAttendances = Schedule::with(['student'])
            ->where('tutor_id', $tutorId)
            ->where('status', 'scheduled')
            ->whereDoesntHave('attendance');

        $queryReports = Schedule::with(['student'])
            ->where('tutor_id', $tutorId)
            ->where('status', 'completed')
            ->whereDoesntHave('sessionReport');

        if ($month) {
            $startDate = \Carbon\Carbon::parse($month)->startOfMonth();
            $endDate = \Carbon\Carbon::parse($month)->endOfMonth();
            $queryAttendances->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            $queryReports->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
        }

        $missingAttendances = $queryAttendances
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'date_formatted' => $s->date->format('d M Y'),
                    'time_formatted' => $s->start_time->format('H:i') . ' - ' . $s->end_time->format('H:i'),
                    'tutor_name' => '-', // Tutor views their own schedule, not needed
                    'student_name' => $s->student->name ?? '-',
                    'url' => route('tutor.schedules.show', $s->id)
                ];
            });

        $missingReports = $queryReports
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get()
            ->map(function ($s) {
                return [
                    'id' => $s->id,
                    'date_formatted' => $s->date->format('d M Y'),
                    'time_formatted' => $s->start_time->format('H:i') . ' - ' . $s->end_time->format('H:i'),
                    'tutor_name' => '-',
                    'student_name' => $s->student->name ?? '-',
                    'url' => route('tutor.schedules.show', $s->id)
                ];
            });

        return response()->json([
            'missingAttendances' => $missingAttendances,
            'missingReports' => $missingReports
        ]);
    }
}
