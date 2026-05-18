@extends('layouts.app')

@section('title', 'Edit Subject')
@section('page-title', 'Edit Subject')
@section('page-subtitle', 'Update mata pelajaran: ' . $subject->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Back Button --}}
    <a href="{{ route('admin.subjects.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-amber-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Subjects
    </a>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
            <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="flex items-start gap-3 p-4 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl text-red-700 text-sm">
            <svg class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <ul class="space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="card-premium overflow-hidden">
        {{-- Card Header --}}
        <div class="bg-gradient-to-r from-amber-500 via-orange-600 to-red-700 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Edit Subject</h3>
                    <p class="text-amber-100 text-sm">{{ $subject->name }}</p>
                </div>
            </div>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('admin.subjects.update', $subject) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-6">

                {{-- Subject Name --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $subject->name) }}"
                        required
                        placeholder="Contoh: Matematika"
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:bg-white outline-none transition-all @error('name') border-red-400 bg-red-50 @enderror"
                    >
                    @error('name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Level --}}
                <div>
                    <label for="grade_level_id" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Level / Jenjang <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="grade_level_id"
                        name="grade_level_id"
                        required
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:bg-white outline-none transition-all @error('grade_level_id') border-red-400 bg-red-50 @enderror"
                    >
                        <option value="">-- Pilih Jenjang --</option>
                        @foreach($levels as $level)
                            <option value="{{ $level->id }}" {{ old('grade_level_id', $subject->grade_level_id) == $level->id ? 'selected' : '' }}>
                                {{ $level->name }}@if($level->description) ({{ $level->description }})@endif
                            </option>
                        @endforeach
                    </select>
                    @error('grade_level_id')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Deskripsi
                        <span class="text-gray-400 font-normal text-xs ml-1">(opsional)</span>
                    </label>
                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Deskripsi singkat mata pelajaran ini..."
                        class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:bg-white outline-none transition-all resize-none @error('description') border-red-400 bg-red-50 @enderror"
                    >{{ old('description', $subject->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status (is_active) --}}
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Status Aktif</p>
                        <p class="text-xs text-gray-500 mt-0.5">Mata pelajaran yang tidak aktif tidak akan muncul di pilihan jadwal.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4 flex-shrink-0">
                        <input
                            type="hidden"
                            name="is_active"
                            value="0"
                        >
                        <input
                            type="checkbox"
                            id="is_active"
                            name="is_active"
                            value="1"
                            {{ old('is_active', $subject->is_active) ? 'checked' : '' }}
                            class="sr-only peer"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                    </label>
                </div>

            </div>

            {{-- Form Footer --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3">
                <a href="{{ route('admin.subjects.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all">
                    Batal
                </a>
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-amber-500/30 transition-all">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
