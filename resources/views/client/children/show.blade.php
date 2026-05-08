@extends('layouts.app')

@section('title', $student->name)
@section('page-title', $student->name)
@section('page-subtitle', 'Detail profil dan aktivitas anak')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Back Button -->
    <a href="{{ route('client.children.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 transition-colors font-semibold text-sm">
        <svg class="h-4 w-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar Anak
    </a>

    <!-- Profile Card -->
    <div class="card-premium overflow-hidden">
        <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        <div class="p-6">
            <div class="flex items-center gap-6">
                <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}" 
                     class="h-24 w-24 rounded-2xl object-cover ring-4 ring-indigo-50 shadow-sm">
                <div class="flex-1">
                    <h2 class="text-2xl font-black text-gray-900">{{ $student->name }}</h2>
                    <p class="text-sm font-medium text-gray-500 mt-1">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                    <p class="text-xs text-gray-400 mt-1">Tanggal Lahir: <span class="font-semibold text-gray-600">{{ $student->birth_date?->format('d M Y') ?? '-' }}</span></p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $student->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                        {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Upcoming Schedules -->
        <div>
            <h3 class="text-base font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Jadwal Mendatang
            </h3>
            <div class="card-premium overflow-hidden">
                <div class="divide-y divide-gray-50">
                    @forelse($upcomingSessions as $schedule)
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50/50 transition-colors">
                            <div>
                                <p class="font-bold text-gray-900">{{ $schedule->subject->name ?? '-' }}</p>
                                <p class="text-xs font-medium text-gray-500 mt-0.5">Tutor: <span class="text-gray-700">{{ $schedule->tutor->user->name ?? '-' }}</span></p>
                            </div>
                            <div class="text-right bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100">
                                <p class="text-sm font-bold text-indigo-700">{{ $schedule->date->format('d M Y') }}</p>
                                <p class="text-xs font-semibold text-indigo-500 mt-0.5">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="font-semibold text-gray-500">Tidak ada jadwal</p>
                            <p class="text-xs text-gray-400 mt-1">Belum ada jadwal belajar dalam waktu dekat</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Session Reports -->
        <div>
            <div class="flex justify-between items-center mb-3">
                <h3 class="text-base font-bold text-gray-700 flex items-center gap-2">
                    <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Sesi Terakhir
                </h3>
                <a href="{{ route('client.progress.show', $student) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">
                    Lihat Lengkap &rarr;
                </a>
            </div>
            <div class="card-premium overflow-hidden">
                <div class="divide-y divide-gray-50">
                    @forelse($recentReports as $report)
                        @php
                            $u = $report->student_understanding;
                            $uColor = $u >= 4 ? 'text-green-600' : ($u >= 3 ? 'text-blue-600' : 'text-red-500');
                            $uLabel = match(true) { $u >= 5 => 'Sangat Paham', $u >= 4 => 'Paham', $u >= 3 => 'Cukup', default => 'Kurang Paham' };
                        @endphp
                        <div class="flex items-center justify-between p-4 hover:bg-gray-50/50 transition-colors">
                            <div>
                                <p class="font-bold text-gray-900">{{ $report->schedule->subject->name ?? '-' }}</p>
                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mt-1">{{ $report->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <div class="flex items-baseline justify-end gap-0.5">
                                    <span class="text-xl font-black {{ $uColor }}">{{ $u }}</span>
                                    <span class="text-xs font-bold text-gray-300">/5</span>
                                </div>
                                <span class="text-[10px] font-bold uppercase {{ $uColor }}">{{ $uLabel }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <p class="font-semibold text-gray-500">Belum ada laporan</p>
                            <p class="text-xs text-gray-400 mt-1">Laporan belajar akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Payment History -->
    <div>
        <h3 class="text-base font-bold text-gray-700 mb-3 flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Riwayat Tagihan / Pembayaran
        </h3>
        <div class="card-premium overflow-hidden">
            <div class="divide-y divide-gray-50">
                @forelse($student->payments()->latest()->take(5)->get() as $payment)
                    <div class="flex items-center justify-between p-4 hover:bg-gray-50/50 transition-colors">
                        <div>
                            <p class="font-bold text-gray-900">{{ $payment->payment_method ?? 'Tagihan Pembelajaran' }}</p>
                            <p class="text-xs font-medium text-gray-500 mt-0.5">Jatuh Tempo: {{ $payment->due_date->format('d M Y') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-black text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @if($payment->status === 'paid') bg-green-100 text-green-700
                                @elseif($payment->status === 'pending') bg-red-100 text-red-700
                                @elseif($payment->status === 'overdue') bg-orange-100 text-orange-700
                                @else bg-gray-100 text-gray-600 @endif">
                                {{ $payment->status === 'paid' ? 'Lunas' : ($payment->status === 'pending' ? 'Belum Bayar' : 'Terlambat') }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <p class="font-semibold text-gray-500">Belum ada riwayat pembayaran</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
