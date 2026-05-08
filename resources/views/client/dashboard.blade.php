@extends('layouts.app')

@section('title', 'Dashboard Wali Murid')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name . '!')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Anak Aktif -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-white !important uppercase tracking-wide">Anak Aktif</p>
                        <p class="text-4xl font-black text-white mt-2 !important">{{ $stats['total_children'] }}</p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-7 w-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold border border-white/20">
                        Sedang mengikuti bimbel
                    </span>
                </div>
            </div>
        </div>

        <!-- Tagihan Pending -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-white !important uppercase tracking-wide">Tagihan Pending</p>
                        <p class="text-4xl font-black text-white mt-2 !important">{{ $stats['pending_payments'] }}</p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-7 w-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 {{ $stats['pending_payments'] > 0 ? 'bg-red-500/20 text-red-200 border-red-500/30' : 'bg-white/10 text-white border-white/20' }} rounded-full text-xs font-bold border">
                        {{ $stats['pending_payments'] > 0 ? 'Segera lunasi' : 'Semua lunas' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Total Reports -->
        <div class="card-premium overflow-hidden border-none shadow-xl bg-indigo-800 relative group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full transition-transform group-hover:scale-110"></div>
            <div class="p-6 relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-white !important uppercase tracking-wide">Laporan Sesi</p>
                        <p class="text-4xl font-black text-white mt-2 !important">{{ $stats['total_reports'] }}</p>
                    </div>
                    <div class="h-14 w-14 rounded-2xl bg-indigo-700/50 flex items-center justify-center border border-indigo-600/50">
                        <svg class="h-7 w-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-white/10 text-white rounded-full text-xs font-bold border border-white/20">
                        Perkembangan belajar
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Children Grid -->
    @if($students->count() > 0)
        <div class="card-premium overflow-hidden">
            <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Data Anak
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($students as $student)
                        <a href="{{ route('client.children.show', $student) }}" class="group block bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-indigo-300 hover:bg-indigo-50/30 hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 p-6">
                            <div class="flex items-center gap-4 mb-4">
                                <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}" 
                                     class="h-16 w-16 rounded-2xl object-cover shadow-sm group-hover:shadow-md transition-shadow">
                                <div class="flex-1">
                                    <h4 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $student->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <span class="text-xs font-semibold text-indigo-600 group-hover:text-indigo-700">Lihat perkembangan &rarr;</span>
                                @php
                                    $upcomingCount = $student->schedules()->where('date', '>=', today())->where('status', 'scheduled')->count();
                                @endphp
                                <span class="inline-flex items-center px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">
                                    {{ $upcomingCount }} sesi menanti
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Upcoming Schedules -->
        <div class="card-premium overflow-hidden flex flex-col">
            <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Jadwal Mendatang
                    </h3>
                    <a href="{{ route('client.schedules.index') }}" class="text-indigo-200 hover:text-white text-sm font-semibold flex items-center gap-1 transition-colors">
                        Lihat Semua
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-3">
                    @forelse($upcomingSchedules as $schedule)
                        <div class="group flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-300">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $schedule->student->name }}</p>
                                <p class="text-sm text-gray-500 font-medium">{{ $schedule->subject->name }} bersama <span class="text-indigo-600">{{ $schedule->tutor->user->name }}</span></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-900">{{ $schedule->date->format('d M') }}</p>
                                <p class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md inline-block mt-1">{{ $schedule->start_time }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 font-medium">Belum ada jadwal terdekat</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Session Reports -->
        <div class="card-premium overflow-hidden flex flex-col">
            <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Laporan Sesi Terbaru
                    </h3>
                    <a href="{{ route('client.reports.index') }}" class="text-indigo-200 hover:text-white text-sm font-semibold flex items-center gap-1 transition-colors">
                        Lihat Semua
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6 flex-1">
                <div class="space-y-3">
                    @forelse($recentReports as $report)
                        <a href="{{ route('client.reports.show', $report) }}" class="group flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-300">
                            <div>
                                <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $report->student->name }}</p>
                                <p class="text-sm text-gray-500 line-clamp-1 font-medium">{{ $report->material_covered }}</p>
                                <p class="text-xs text-gray-400 mt-1">Tutor: {{ $report->tutor->user->name }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                    @if($report->student_understanding >= 4) bg-green-100 text-green-700 border border-green-200
                                    @elseif($report->student_understanding >= 3) bg-blue-100 text-blue-700 border border-blue-200
                                    @else bg-red-100 text-red-700 border border-red-200
                                    @endif">
                                    Nilai: {{ $report->student_understanding }}/5
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-gray-500 font-medium">Belum ada laporan sesi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-5 border-b border-indigo-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Riwayat Pembayaran Terakhir
                </h3>
                <a href="{{ route('client.payments.index') }}" class="text-indigo-200 hover:text-white text-sm font-semibold flex items-center gap-1 transition-colors">
                    Lihat Semua
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($recentPayments as $payment)
                    <div class="group flex items-center justify-between p-4 bg-gray-50/50 rounded-2xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all duration-300">
                        <div>
                            <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $payment->student->name }}</p>
                            <p class="text-sm text-gray-500 font-medium">{{ $payment->payment_method ?? 'Metode belum diset' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-bold text-indigo-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold mt-1 border
                                @if($payment->status === 'paid') bg-green-50 text-green-700 border-green-200
                                @elseif($payment->status === 'pending') bg-red-50 text-red-700 border-red-200
                                @else bg-gray-50 text-gray-700 border-gray-200
                                @endif">
                                {{ $payment->status === 'paid' ? 'Lunas' : ($payment->status === 'pending' ? 'Belum Lunas' : ucfirst($payment->status)) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-6">
                        <p class="text-gray-500 font-medium">Belum ada riwayat pembayaran</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
