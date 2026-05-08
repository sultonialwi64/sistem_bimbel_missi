@extends('layouts.app')

@section('title', 'Perkembangan Belajar')
@section('page-title', 'Perkembangan Belajar')
@section('page-subtitle', 'Pilih anak untuk melihat detail hasil belajarnya')

@section('content')
<div class="space-y-6">
    @if($students->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($students as $student)
                <a href="{{ route('client.progress.show', $student) }}"
                   class="group card-premium block hover:scale-[1.02] transition-all duration-300">
                    <!-- Gradient Top Bar -->
                    <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                    <div class="p-6">
                        <div class="flex items-center gap-4 mb-5">
                            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}"
                                 class="h-16 w-16 rounded-2xl object-cover ring-2 ring-indigo-500/20 group-hover:ring-indigo-500/40 transition-all">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                    {{ $student->name }}
                                </h3>
                                <p class="text-sm text-gray-500">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider group-hover:text-indigo-700">
                                Lihat Hasil Belajar
                            </span>
                            <svg class="h-5 w-5 text-indigo-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="card-premium p-12">
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
                <p class="font-semibold text-gray-500">Belum ada anak yang terdaftar</p>
                <p class="text-sm text-gray-400">Hubungi admin untuk mendaftarkan anak Anda</p>
            </div>
        </div>
    @endif
</div>
@endsection
