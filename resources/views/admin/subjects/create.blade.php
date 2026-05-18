@extends('layouts.app')
@section('title', 'Add Subject')
@section('page-title', 'Add New Subject')
@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.subjects.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subject Name</label>
                    <input type="text" name="name" required class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Level / Jenjang</label>
                    <select name="grade_level_id" required class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('grade_level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}@if($level->description) ({{ $level->description }})@endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.subjects.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Create</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
