@extends('layouts.app')

@section('title', 'Tutor Dashboard')
@section('page-title', 'Dashboard Tentor')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name . '!')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <!-- Sesi Bulan Ini -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group col-span-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-[10px] font-semibold text-white/70 uppercase tracking-wide">Sesi Bulan Ini</p>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['sessions_this_month'] }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
                <span class="inline-flex px-2 py-0.5 bg-white/10 text-white rounded-full text-[9px] font-bold border border-white/20 uppercase tracking-wider">{{ now()->translatedFormat('F Y') }}</span>
            </div>
        </div>

        <!-- Rating -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group col-span-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-[10px] font-semibold text-white/70 uppercase tracking-wide">Rating Rata-rata</p>
                        <div class="flex items-center gap-1.5 mt-1">
                            <p class="text-3xl font-black text-white">{{ number_format($stats['rating_avg'], 1) }}</p>
                            <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.519-3.292z"/></svg>
                    </div>
                </div>
                <span class="inline-flex px-2 py-0.5 bg-white/10 text-white rounded-full text-[9px] font-bold border border-white/20 uppercase tracking-wider">
                    @if($stats['rating_avg'] >= 4.5)
                        Performa Luar Biasa
                    @elseif($stats['rating_avg'] >= 4.0)
                        Performa Bagus
                    @elseif($stats['rating_avg'] > 0)
                        Performa Cukup
                    @else
                        Belum Ada Ulasan
                    @endif
                </span>
            </div>
        </div>

        <!-- Pendapatan Bulan Ini -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group col-span-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-[10px] font-semibold text-white/70 uppercase tracking-wide">Pendapatan Bulan Ini</p>
                        <div class="flex items-baseline gap-1 mt-2">
                            <span class="text-2xl font-bold text-white">Rp</span>
                            <span class="text-4xl font-black text-white whitespace-nowrap">{{ number_format($stats['monthly_earnings'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Selesai All-time -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group col-span-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-[10px] font-semibold text-white/70 uppercase tracking-wide">Selesai</p>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['completed_sessions'] }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <span class="inline-flex px-2 py-0.5 bg-white/10 text-white rounded-full text-[9px] font-bold border border-white/20 uppercase tracking-wider">Berhasil Dilaksanakan</span>
            </div>
        </div>

        <!-- Laporan Belum Dibuat -->
        <div class="card-premium overflow-hidden border-none shadow-xl {{ $stats['reports_pending'] > 0 ? 'bg-amber-700' : 'bg-indigo-800' }} relative group col-span-1">
            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-[10px] font-semibold text-white/70 uppercase tracking-wide">Laporan Pending</p>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['reports_pending'] }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center border border-white/20">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                </div>
                <span class="inline-flex px-2 py-0.5 bg-white/20 text-white rounded-full text-[9px] font-bold border border-white/30 uppercase tracking-wider">{{ $stats['reports_pending'] > 0 ? 'Segera Buat Laporan!' : 'Semua Beres ✓' }}</span>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Today's Schedules -->
        <div class="card-premium overflow-hidden">
            <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Jadwal Hari Ini
                    </h3>
                </div>
            </div>
            <div class="p-6">
                @if($todaySchedules->count() > 0)
                    <div class="space-y-4">
                        @foreach($todaySchedules as $schedule)
                            <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-xl bg-indigo-800 flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-sm">{{ substr($schedule->student->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $schedule->student->name }}</p>
                                        <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider">{{ $schedule->subject->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-black text-gray-900">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                                    </p>
                                    <a href="{{ route('tutor.schedules.show', $schedule) }}" class="text-[10px] font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest mt-1 block">Detail →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="h-16 w-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="h-8 w-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-bold">Tidak ada jadwal hari ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Upcoming Schedules -->
        <div class="card-premium overflow-hidden">
            <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Jadwal Mendatang
                    </h3>
                    <a href="{{ route('tutor.schedules.index') }}" class="text-[10px] font-black text-blue-300 hover:text-white uppercase tracking-widest transition-colors">
                        Lihat Semua →
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($upcomingSchedules as $schedule)
                        <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all duration-300">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $schedule->student->name }}</p>
                                <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider">{{ $schedule->subject->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-gray-900">{{ $schedule->date->translatedFormat('d M') }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-gray-500 font-bold">Belum ada jadwal mendatang</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sessions History -->
    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Riwayat Sesi Terakhir
                </h3>
            </div>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recentSessions as $session)
                    @php $report = $session->sessionReport; @endphp
                    <div class="group flex items-center justify-between p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/50 transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-xl {{ $report ? 'bg-gray-200 text-gray-500' : 'bg-amber-100 text-amber-600' }} flex items-center justify-center font-bold text-xs transition-colors">
                                {{ substr($session->student->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $session->student->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1.5 mt-0.5">
                                    <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $session->date->translatedFormat('d M Y') }}
                                    <span class="text-gray-300">•</span>
                                    {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} WIB
                                </p>
                                @if($report)
                                    <p class="text-xs text-gray-500 font-medium italic line-clamp-1 mt-1">"{{ $report->material_covered }}"</p>
                                @else
                                    <a href="{{ route('tutor.reports.create', $session) }}" class="text-xs text-amber-600 font-bold hover:underline mt-1 block">Isi Laporan Sekarang →</a>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            @if($report)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                    @if($report->student_understanding >= 4) bg-green-100 text-green-700
                                    @elseif($report->student_understanding >= 3) bg-blue-100 text-blue-700
                                    @else bg-red-100 text-red-700
                                    @endif border border-current/20">
                                    Pemahaman: {{ $report->student_understanding }}/5
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-100 text-amber-700 border border-amber-200">
                                    ⚠ Belum Isi Laporan
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8 font-bold">Belum ada riwayat sesi</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
