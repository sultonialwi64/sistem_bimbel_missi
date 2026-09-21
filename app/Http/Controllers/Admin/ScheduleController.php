<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Schedule, Student, Tutor, Subject};
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ScheduleLog;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['tutor.user', 'student.client', 'subject', 'createdBy'])
            ->latest()
            ->paginate(15);
            
        // Get all schedules for the calendar view
        $allSchedules = Schedule::with(['tutor.user', 'student', 'subject', 'sessionReport'])->get();
        
        $tutors = Tutor::where('status', 'active')->get();
        $students = Student::where('is_active', true)
            ->whereHas('client', fn ($query) => $query->where('is_active', true))
            ->get();
        $subjects = Subject::where('is_active', true)->get();
        
        return view('admin.schedules.index', compact('schedules', 'allSchedules', 'tutors', 'students', 'subjects'));
    }

    public function create()
    {
        $tutors = Tutor::where('status', 'active')->get();
        $students = Student::where('is_active', true)
            ->whereHas('client', fn ($query) => $query->where('is_active', true))
            ->get();
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
            $tutorConflict = Schedule::with('student')->where('tutor_id', $validated['tutor_id'])
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
                $conflicts[] = "Tabrakan jadwal: Tutor sudah memiliki sesi pada {$formattedDate} jam {$conflictTime} (Siswa: {$studentName}).";
            }

            // Cek jadwal murid bentrok
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
                $conflicts[] = "Tabrakan jadwal: Murid ini sudah memiliki sesi dengan Tutor {$tutorName} pada {$formattedDate} jam {$conflictTime}.";
            }
        }

        if (!empty($conflicts)) {
            array_unshift($conflicts, 'Gagal membuat jadwal karena terdapat bentrok waktu.');
            return back()->withInput()->withErrors(['time_conflict' => $conflicts]);
        }

        $validated['created_by'] = auth()->id();
        $validated['status'] = 'scheduled';

        $createdSchedules = collect();

        \Illuminate\Support\Facades\DB::transaction(function () use ($datesToCreate, $validated, &$createdSchedules) {
            foreach ($datesToCreate as $date) {
                $scheduleData = $validated;
                $scheduleData['date'] = $date;
                $createdSchedules->push(Schedule::create($scheduleData));
            }
        });

        if ($createdSchedules->isNotEmpty()) {
            app(NotificationService::class)->notifyAdminsNewSchedule($createdSchedules->first(), $createdSchedules->count());
        }

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

    public function logs()
    {
        $logs = ScheduleLog::with('user')->latest()->take(50)->get();

        $html = '';
        if ($logs->isEmpty()) {
            $html = '<div class="text-center py-10 text-gray-500"><i class="fa-solid fa-clock-rotate-left text-4xl mb-3 text-gray-300"></i><p>Belum ada riwayat aktivitas jadwal.</p></div>';
        } else {
            foreach ($logs as $log) {
                $icon = match($log->action) {
                    'created' => '<div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center shrink-0"><i class="fa-solid fa-plus text-blue-600 text-xs"></i></div>',
                    'updated' => '<div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center shrink-0"><i class="fa-solid fa-pen text-orange-600 text-xs"></i></div>',
                    'deleted' => '<div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center shrink-0"><i class="fa-solid fa-trash text-red-600 text-xs"></i></div>',
                    default => '<div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0"><i class="fa-solid fa-clock-rotate-left text-gray-600 text-xs"></i></div>'
                };
                
                $time = \Carbon\Carbon::parse($log->created_at)->diffForHumans();
                $date = \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i');
                
                $html .= '<div class="flex gap-4 p-4 hover:bg-gray-50 border-b border-gray-100 transition-colors">';
                $html .= $icon;
                $html .= '<div>';
                $html .= '<p class="text-sm font-medium text-gray-800">' . htmlspecialchars($log->description) . '</p>';
                $html .= '<div class="flex items-center gap-2 mt-1">';
                $html .= '<span class="text-xs text-gray-500" title="'.$date.'">' . $time . '</span>';
                if ($log->user) {
                    $html .= '<span class="text-xs font-medium px-2 py-0.5 bg-gray-100 rounded-full text-gray-600">' . htmlspecialchars($log->user->name) . '</span>';
                } else {
                    $html .= '<span class="text-xs font-medium px-2 py-0.5 bg-gray-100 rounded-full text-gray-600">Sistem</span>';
                }
                $html .= '</div>';
                $html .= '</div></div>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function edit(Schedule $schedule)
    {
        $tutors = Tutor::where('status', 'active')->get();
        $students = Student::where(function ($query) use ($schedule) {
            $query->where(function ($activeQuery) {
                $activeQuery->where('is_active', true)
                    ->whereHas('client', fn ($clientQuery) => $clientQuery->where('is_active', true));
            })->orWhere('id', $schedule->student_id);
        })->get();
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
        // Validation 1: Cek jadwal tutor bentrok (exclude jadwal ini sendiri)
        $tutorConflict = Schedule::with('student')->where('id', '!=', $schedule->id)
            ->where('tutor_id', $validated['tutor_id'])
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
            return back()->withInput()->withErrors(['time_conflict' => "Tabrakan jadwal: Tutor sudah memiliki sesi pada jam {$conflictTime} (Siswa: {$studentName})."]);
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
        $schedule->update($validated);

        // Sinkronisasi data ke laporan sesi dan absensi jika tutor atau muridnya diubah
        if ($schedule->sessionReport) {
            $schedule->sessionReport->update([
                'student_id' => $schedule->student_id,
                'tutor_id' => $schedule->tutor_id,
            ]);
        }
        
        if ($schedule->attendance) {
            $schedule->attendance->update([
                'tutor_id' => $schedule->tutor_id,
            ]);
        }

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }

    public function missingRecords(Request $request)
    {
        $month = $request->query('month');
        
        $queryAttendances = Schedule::with(['tutor.user', 'student'])
            ->where('status', 'scheduled')
            ->whereDoesntHave('attendance');

        $queryReports = Schedule::with(['tutor.user', 'student'])
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
                    'tutor_name' => $s->tutor->user->name ?? '-',
                    'student_name' => $s->student->name ?? '-',
                    'url' => route('admin.schedules.show', $s->id)
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
                    'tutor_name' => $s->tutor->user->name ?? '-',
                    'student_name' => $s->student->name ?? '-',
                    'url' => route('admin.schedules.show', $s->id)
                ];
            });

        return response()->json([
            'missingAttendances' => $missingAttendances,
            'missingReports' => $missingReports
        ]);
    }
}
