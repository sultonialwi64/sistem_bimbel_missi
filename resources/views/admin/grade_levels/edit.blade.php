@extends('layouts.app')

@section('title', 'Edit Jenjang')
@section('page-title', 'Edit Jenjang')
@section('page-subtitle', 'Perbarui data jenjang pendidikan: ' . $gradeLevel->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <a href="{{ route('admin.grade-levels.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar
    </a>

    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5">
            <h3 class="text-lg font-bold text-white">Edit Jenjang</h3>
        </div>

        <form action="{{ route('admin.grade-levels.update', $gradeLevel) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Jenjang <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" value="{{ old('name', $gradeLevel->name) }}" required placeholder="Contoh: PAUD, SD, SMP, SMA, Kuliah, dll" 
                       class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all @error('name') border-red-400 bg-red-50 @enderror">
                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi <span class="text-gray-400 font-normal text-xs ml-1">(opsional)</span></label>
                <textarea id="description" name="description" rows="3" placeholder="Deskripsi singkat jenjang ini..." 
                          class="block w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all resize-none @error('description') border-red-400 bg-red-50 @enderror">{{ old('description', $gradeLevel->description) }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-50">
                <a href="{{ route('admin.grade-levels.index') }}" class="px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-700 text-white rounded-xl font-bold text-sm shadow-lg hover:shadow-indigo-500/30 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
