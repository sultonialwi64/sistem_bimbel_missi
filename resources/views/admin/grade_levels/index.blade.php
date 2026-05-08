@extends('layouts.app')

@section('title', 'Manajemen Jenjang')
@section('page-title', 'Master Jenjang')
@section('page-subtitle', 'Kelola daftar jenjang pendidikan (PAUD, SD, SMP, SMA, dll)')

@section('content')
<div class="space-y-6">
    {{-- Header Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="h-12 w-12 rounded-2xl bg-indigo-800 flex items-center justify-center shadow-lg shadow-indigo-500/20">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Daftar Jenjang</h2>
                <p class="text-sm text-gray-500 font-medium">Total {{ $gradeLevels->total() }} jenjang terdaftar</p>
            </div>
        </div>

        <a href="{{ route('admin.grade-levels.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-800 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40 hover:-translate-y-0.5 transition-all duration-300 group">
            <svg class="h-5 w-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Jenjang Baru
        </a>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="p-4 bg-green-50 border border-green-100 rounded-2xl flex items-center gap-3 text-green-700 font-medium animate-fade-in">
            <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 text-red-700 font-medium">
            <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Table Card --}}
    <div class="card-premium overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-indigo-50/50 border-b border-indigo-100">
                        <th class="py-4 px-6 text-xs font-bold text-indigo-700 uppercase tracking-widest">Nama Jenjang</th>
                        <th class="py-4 px-6 text-xs font-bold text-indigo-700 uppercase tracking-widest">Deskripsi</th>
                        <th class="py-4 px-6 text-xs font-bold text-indigo-700 uppercase tracking-widest text-center">Mata Pelajaran</th>
                        <th class="py-4 px-6 text-xs font-bold text-indigo-700 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($gradeLevels as $level)
                        <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($level->name, 0, 2) }}
                                    </div>
                                    <span class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $level->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600">{{ $level->description ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $level->subjects_count }} Mapel
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    <a href="{{ route('admin.grade-levels.edit', $level) }}" 
                                       class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-indigo-600 hover:border-indigo-200 rounded-xl transition-all shadow-sm">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.grade-levels.destroy', $level) }}" method="POST" class="inline" onsubmit="return confirm('Hapus jenjang ini? Data mata pelajaran terkait mungkin akan terdampak.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white border border-gray-200 text-gray-400 hover:text-red-600 hover:border-red-200 rounded-xl transition-all shadow-sm">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-gray-500">Belum ada jenjang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($gradeLevels->hasPages())
            <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
                {{ $gradeLevels->links() }}
            </div>
        @endif
    </div>

    {{-- Link ke Subjects --}}
    <div class="flex justify-center">
        <a href="{{ route('admin.subjects.index') }}" class="text-sm font-semibold text-gray-500 hover:text-indigo-600 flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            Kelola Mata Pelajaran
        </a>
    </div>
</div>
@endsection
