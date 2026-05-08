@extends('layouts.app')

@section('title', 'My Students')
@section('page-title', 'My Students')
@section('page-subtitle', 'Students you are currently teaching')

@section('content')
<div class="space-y-6">
    <div class="card-premium">
        <div class="table-container">
            <table class="table-premium">
                <thead class="bg-indigo-900">
                    <tr>
                        <th class="text-white font-bold opacity-90">Student</th>
                        <th class="text-white font-bold opacity-90">Grade</th>
                        <th class="text-white font-bold opacity-90">Parent</th>
                        <th class="text-white font-bold opacity-90">School</th>
                        <th class="text-white font-bold opacity-90">Total Sessions</th>
                        <th class="text-white font-bold opacity-90">Last Session</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img class="h-11 w-11 rounded-xl object-cover ring-2 ring-green-500/20" src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=10b981&color=fff' }}" alt="">
                                    <span class="font-bold text-gray-900">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td><span class="badge badge-indigo">{{ $student->grade_level ?? '-' }}</span></td>
                            <td>
                                <p class="text-sm font-semibold text-gray-900">{{ $student->client->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $student->client->user->phone ?? '-' }}</p>
                            </td>
                            <td><span class="text-sm text-gray-700">{{ $student->school_name ?? '-' }}</span></td>
                            <td><span class="badge badge-blue">{{ $student->schedules()->where('tutor_id', auth()->user()->tutor->id)->count() }} sessions</span></td>
                            <td>
                                @php
                                    $lastSchedule = $student->schedules()->where('tutor_id', auth()->user()->tutor->id)->latest('date')->first();
                                @endphp
                                <span class="text-sm text-gray-600">{{ $lastSchedule ? $lastSchedule->date->format('d M Y') : '-' }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6"><div class="empty-state"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg><p class="font-semibold">No students yet</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $students->links() }}</div>
</div>
@endsection
