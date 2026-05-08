@extends('layouts.app')
@section('title', 'Schedule Detail')
@section('page-title', 'Schedule Detail')
@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.schedules.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">← Back to Schedules</a>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="text-sm text-gray-500">Student</label>
                <p class="text-lg font-semibold">{{ $schedule->student->name }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->student->client->user->name }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Tutor</label>
                <p class="text-lg font-semibold">{{ $schedule->tutor->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->tutor->user->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Subject</label>
                <p class="text-lg font-semibold">{{ $schedule->subject->name }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->subject->level }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Date & Time</label>
                <p class="text-lg font-bold text-indigo-700">{{ $schedule->date->translatedFormat('l, d M Y') }}</p>
                <p class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-lg inline-block mt-1">
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                </p>
            </div>
            <div class="col-span-2">
                <label class="text-sm text-gray-500">Status</label>
                <div class="mt-1">
                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        @if($schedule->status === 'completed') bg-green-100 text-green-800
                        @elseif($schedule->status === 'scheduled') bg-blue-100 text-blue-800
                        @elseif($schedule->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($schedule->status) }}
                    </span>
                </div>
            </div>
            @if($schedule->notes)
                <div class="col-span-2">
                    <label class="text-sm text-gray-500">Notes</label>
                    <p class="mt-1 italic text-gray-600">"{{ $schedule->notes }}"</p>
                </div>
            @endif
        </div>
        
        <div class="mt-8 flex justify-end gap-3 border-t pt-6">
            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Edit Schedule</a>
            <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini permanen?');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-50 text-red-700 border border-red-200 rounded-xl font-bold hover:bg-red-100 transition-all">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
