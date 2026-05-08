@extends('layouts.app')

@section('title', 'Detail Laporan Sesi')
@section('page-title', 'Detail Laporan Sesi')
@section('page-subtitle', 'Detail lengkap aktivitas belajar dan feedback')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.session-reports.index') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition-colors">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Laporan
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Session Info --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="card-premium p-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-2xl font-black text-slate-800">{{ $sessionReport->schedule->subject->name }}</h2>
                        <p class="text-slate-500 font-medium">Laporan Sesi #{{ $sessionReport->id }}</p>
                    </div>
                    <div class="text-right text-sm">
                        <p class="font-bold text-slate-700">{{ $sessionReport->schedule->date->translatedFormat('l, d F Y') }}</p>
                        <p class="text-slate-400 font-semibold">{{ $sessionReport->schedule->start_time->format('H:i') }} - {{ $sessionReport->schedule->end_time->format('H:i') }}</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 text-[10px]">Materi yang Dipelajari</h3>
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 text-slate-700 leading-relaxed">
                            {{ $sessionReport->material_covered }}
                        </div>
                    </div>

                    @if($sessionReport->notes_for_parent)
                    <div>
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 text-[10px]">Catatan untuk Orang Tua</h3>
                        <div class="p-4 bg-indigo-50/50 rounded-2xl border border-indigo-100 text-slate-700 leading-relaxed italic">
                            "{{ $sessionReport->notes_for_parent }}"
                        </div>
                    </div>
                    @endif

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 text-[10px]">Pemahaman Murid</h3>
                            <div class="flex items-center gap-3">
                                <div class="text-3xl font-black text-indigo-600">{{ $sessionReport->student_understanding }}<span class="text-lg text-slate-300">/5</span></div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-indigo-500" style="width: {{ ($sessionReport->student_understanding / 5) * 100 }}%"></div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-3 text-[10px]">Rating Performa</h3>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-6 w-6 {{ $i <= $sessionReport->tutor_rating_by_student ? 'text-yellow-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Attendance Photo --}}
            @if($sessionReport->schedule->attendance && $sessionReport->schedule->attendance->photo_path)
            <div class="card-premium p-8">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 text-[10px]">Bukti Foto Absensi</h3>
                <div class="aspect-video rounded-3xl overflow-hidden border-4 border-white shadow-xl">
                    <img src="{{ Storage::url($sessionReport->schedule->attendance->photo_path) }}" alt="Bukti Absensi" class="w-full h-full object-cover">
                </div>
                <div class="mt-4 flex items-center gap-4 text-[10px] font-bold text-slate-400">
                    <div class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Tersimpan: {{ $sessionReport->schedule->attendance->created_at->format('H:i:s d/m/Y') }}
                    </div>
                    @if($sessionReport->schedule->attendance->address)
                    <div class="flex items-center gap-1.5 flex-1">
                        <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $sessionReport->schedule->attendance->address }}
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Right Column: Parties Info & Parent Feedback --}}
        <div class="space-y-6">
            {{-- Parties --}}
            <div class="card-premium p-6">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 text-[10px]">Pihak Terlibat</h3>
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Tentor</p>
                            <p class="text-sm font-bold text-slate-700">{{ $sessionReport->tutor->user->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 border-t pt-4 border-slate-50">
                        <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Murid</p>
                            <p class="text-sm font-bold text-slate-700">{{ $sessionReport->student->name }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 border-t pt-4 border-slate-50">
                        <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Orang Tua</p>
                            <p class="text-sm font-bold text-slate-700">{{ $sessionReport->student->client->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Parent Feedback --}}
            <div class="card-premium p-6 {{ $sessionReport->parent_rating ? 'bg-gradient-to-br from-yellow-50 to-orange-50 border-yellow-200' : 'bg-slate-50' }}">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 text-[10px]">Feedback Orang Tua</h3>
                @if($sessionReport->parent_rating)
                    <div class="flex items-center gap-1 mb-4">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-8 w-8 {{ $i <= $sessionReport->parent_rating ? 'text-yellow-400' : 'text-slate-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    @if($sessionReport->parent_feedback)
                        <div class="text-slate-700 italic leading-relaxed text-sm bg-white/50 p-4 rounded-2xl border border-white/50">
                            "{{ $sessionReport->parent_feedback }}"
                        </div>
                    @else
                        <p class="text-slate-400 text-sm italic">Hanya memberikan bintang tanpa ulasan teks.</p>
                    @endif
                @else
                    <div class="flex flex-col items-center py-4 text-center">
                        <svg class="h-10 w-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Belum ada feedback</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
