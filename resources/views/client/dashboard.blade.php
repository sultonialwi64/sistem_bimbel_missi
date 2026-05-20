@extends('layouts.app')

@section('title', 'Dashboard Wali Murid')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name . '!')

@section('content')
<div class="space-y-6">
    <!-- Stats Grid: 1 col mobile, 3 col desktop -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Anak Aktif -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group">
            <div class="absolute top-0 right-0 w-28 h-28 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Anak Aktif</p>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['total_children'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-6 w-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/10 text-white/90 rounded-full text-[10px] font-bold border border-white/20">
                    Sedang mengikuti bimbel
                </span>
            </div>
        </div>

        <!-- Tagihan Pending -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group">
            <div class="absolute top-0 right-0 w-28 h-28 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Tagihan Pending</p>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['pending_payments'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-6 w-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 {{ $stats['pending_payments'] > 0 ? 'bg-red-500/20 text-red-200 border-red-500/30' : 'bg-white/10 text-white/90 border-white/20' }} rounded-full text-[10px] font-bold border">
                    {{ $stats['pending_payments'] > 0 ? 'Segera lunasi' : 'Semua lunas' }}
                </span>
            </div>
        </div>

        <!-- Total Reports -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group">
            <div class="absolute top-0 right-0 w-28 h-28 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-5 relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <p class="text-xs font-bold text-white/70 uppercase tracking-wider">Laporan Sesi</p>
                        <p class="text-3xl font-black text-white mt-1">{{ $stats['total_reports'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-2xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-6 w-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/10 text-white/90 rounded-full text-[10px] font-bold border border-white/20">
                    Perkembangan belajar
                </span>
            </div>
        </div>
    </div>

    <!-- Children Grid -->
    @if($students->count() > 0)
        <div class="card-premium overflow-hidden">
            <div class="bg-indigo-800 px-5 py-4 border-b border-indigo-700">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Data Anak
                </h3>
            </div>
            <div class="p-4 sm:p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($students as $student)
                        <a href="{{ route('client.children.show', $student) }}" class="group flex items-center gap-4 bg-slate-50/70 rounded-2xl border border-slate-100 hover:border-indigo-300 hover:bg-indigo-50/30 hover:shadow-lg hover:shadow-indigo-500/10 transition-all duration-300 p-4">
                            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}"
                                 class="h-14 w-14 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-shadow flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $student->name }}</h4>
                                <p class="text-xs text-gray-500 truncate">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    @php
                                        $upcomingCount = $student->schedules()->where('date', '>=', today())->where('status', 'scheduled')->count();
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-bold">
                                        {{ $upcomingCount }} sesi menanti
                                    </span>
                                </div>
                            </div>
                            <svg class="h-4 w-4 text-indigo-400 group-hover:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Upcoming Schedules + Recent Reports: stacked on mobile -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Schedules -->
        <div class="card-premium overflow-hidden flex flex-col">
            <div class="bg-indigo-800 px-5 py-4 border-b border-indigo-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Jadwal Mendatang
                    </h3>
                    <a href="{{ route('client.schedules.index') }}" class="text-indigo-200 hover:text-white text-xs font-semibold flex items-center gap-1 transition-colors">
                        Semua
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-4 flex-1">
                <div class="space-y-2.5">
                    @forelse($upcomingSchedules as $schedule)
                        <div class="group flex items-center justify-between p-3.5 bg-gray-50/60 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-200 gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors text-sm truncate">{{ $schedule->student->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $schedule->subject->name }} • <span class="text-indigo-600">{{ $schedule->tutor->user->name }}</span></p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-xs font-bold text-gray-800">{{ $schedule->date->format('d M') }}</p>
                                <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md inline-block mt-0.5">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="h-10 w-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-500 font-medium text-sm">Belum ada jadwal terdekat</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Session Reports -->
        <div class="card-premium overflow-hidden flex flex-col">
            <div class="bg-indigo-800 px-5 py-4 border-b border-indigo-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Laporan Sesi Terbaru
                    </h3>
                    <a href="{{ route('client.reports.index') }}" class="text-indigo-200 hover:text-white text-xs font-semibold flex items-center gap-1 transition-colors">
                        Semua
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-4 flex-1">
                <div class="space-y-2.5">
                    @forelse($recentReports as $report)
                        <a href="{{ route('client.reports.show', $report) }}" class="group flex items-center justify-between p-3.5 bg-gray-50/60 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-200 gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors text-sm truncate">{{ $report->student->name }}</p>
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $report->material_covered }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold flex-shrink-0
                                @if($report->student_understanding >= 4) bg-green-100 text-green-700
                                @elseif($report->student_understanding >= 3) bg-blue-100 text-blue-700
                                @else bg-red-100 text-red-700
                                @endif">
                                {{ $report->student_understanding }}/5
                            </span>
                        </a>
                    @empty
                        <div class="text-center py-8">
                            <svg class="h-10 w-10 text-slate-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-500 font-medium text-sm">Belum ada laporan sesi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-5 py-4 border-b border-indigo-700">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Riwayat Pembayaran Terakhir
                </h3>
                <a href="{{ route('client.payments.index') }}" class="text-indigo-200 hover:text-white text-xs font-semibold flex items-center gap-1 transition-colors">
                    Semua
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($recentPayments as $payment)
                <div class="flex items-center justify-between px-4 sm:px-6 py-4 hover:bg-slate-50/50 transition-colors gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="font-bold text-gray-900 text-sm truncate">{{ $payment->student->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $payment->payment_method ?? 'Metode belum diset' }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <p class="font-bold text-indigo-700 text-sm">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold mt-0.5
                            @if($payment->status === 'paid') bg-green-100 text-green-700
                            @elseif($payment->status === 'pending') bg-amber-100 text-amber-700
                            @else bg-gray-100 text-gray-600
                            @endif">
                            {{ $payment->status === 'paid' ? 'Lunas' : ($payment->status === 'pending' ? 'Belum Lunas' : ucfirst($payment->status)) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center">
                    <p class="text-gray-500 font-medium text-sm">Belum ada riwayat pembayaran</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
