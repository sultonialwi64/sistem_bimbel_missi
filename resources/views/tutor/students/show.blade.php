@extends('layouts.app')
@section('title', 'Student Detail')
@section('page-title', $student->name)
@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <a href="{{ route('tutor.students.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Students</a>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=128' }}" class="h-32 w-32 rounded-full mx-auto">
                <h2 class="mt-4 text-xl font-bold">{{ $student->name }}</h2>
                <p class="text-gray-500">{{ $student->grade_level }} - {{ $student->school_name }}</p>
                <div class="mt-4 flex justify-center gap-2">
                    <a href="{{ route('tutor.students.edit', $student) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm">Edit</a>
                </div>
            </div>
        </div>
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold mb-4">Information</h3>
                <div class="space-y-3">
                    <div><label class="text-sm text-gray-500">Birth Date</label><p class="font-medium">{{ $student->birth_date?->format('d M Y') ?? '-' }}</p></div>
                    <div><label class="text-sm text-gray-500">Parent</label><p class="font-medium">{{ $student->client->user->name }}</p></div>
                    <div><label class="text-sm text-gray-500">Contact</label><p class="font-medium">{{ $student->client->user->phone ?? '-' }}</p></div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="font-semibold mb-4">Schedules</h3>
                <div class="space-y-2">
                    @forelse($student->schedules()->latest()->take(5)->get() as $schedule)
                        <div class="flex justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium">{{ $schedule->subject->name }}</p>
                                <p class="text-sm text-gray-500">{{ $schedule->tutor->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm">{{ $schedule->date->format('d M Y') }}</p>
                                <span class="text-xs px-2 py-1 rounded {{ $schedule->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">{{ $schedule->status }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No schedules yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
