@extends('layouts.app')
@section('title', 'Edit Student')
@section('page-title', 'Edit Student')
@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.students.update', $student) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $student->name) }}" required class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Birth Date</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date', $student->birth_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Parent</label>
                        <select name="client_id" required class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $student->client_id == $client->id ? 'selected' : '' }}>{{ $client->user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">School Name</label>
                        <input type="text" name="school_name" value="{{ old('school_name', $student->school_name) }}" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Grade Level</label>
                        <select name="grade_level" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="SD" {{ $student->grade_level == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ $student->grade_level == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ $student->grade_level == 'SMA' ? 'selected' : '' }}>SMA</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Photo</label>
                    @if($student->photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $student->photo) }}" class="h-20 rounded">
                        </div>
                    @endif
                    <input type="file" name="photo" accept="image/*" class="mt-1 block w-full rounded-md border-gray-300">
                </div>
                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('admin.students.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
