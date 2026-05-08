@extends('layouts.app')
@section('title', 'Edit Schedule')
@section('page-title', 'Edit Schedule')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Student</label>
                        <select name="student_id" required class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ $schedule->student_id == $student->id ? 'selected' : '' }}>{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tutor</label>
                        <select name="tutor_id" required class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($tutors as $tutor)
                                <option value="{{ $tutor->id }}" {{ $schedule->tutor_id == $tutor->id ? 'selected' : '' }}>{{ $tutor->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subject</label>
                    <select name="subject_id" required class="mt-1 block w-full rounded-md border-gray-300">
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ $schedule->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="date" required value="{{ $schedule->date->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Start Time</label>
                        <input type="time" name="start_time" required value="{{ $schedule->start_time }}" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">End Time</label>
                        <input type="time" name="end_time" required value="{{ $schedule->end_time }}" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" required class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="scheduled" {{ $schedule->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                        <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $schedule->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="rescheduled" {{ $schedule->status == 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                    <textarea name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ $schedule->notes }}</textarea>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.schedules.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Update Schedule</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
