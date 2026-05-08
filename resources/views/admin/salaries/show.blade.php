@extends('layouts.app')

@section('title', 'Detail Gaji - ' . $salary->tutor->user->name)
@section('page-title', 'Detail Gaji')
@section('page-subtitle', $salary->tutor->user->name . ' · ' . $salary->period_start->format('d M') . ' – ' . $salary->period_end->format('d M Y'))

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Back --}}
    <a href="{{ route('admin.salaries.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-green-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Salaries
    </a>

    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
            <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header Card --}}
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-800 px-8 py-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center gap-4">
                    <div class="h-14 w-14 rounded-2xl bg-white/20 flex items-center justify-center shadow-lg">
                        <span class="text-white text-lg font-black">{{ strtoupper(substr($salary->tutor->user->name, 0, 2)) }}</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white">{{ $salary->tutor->user->name }}</h2>
                        <p class="text-green-100 text-sm">{{ $salary->period_start->format('d M Y') }} – {{ $salary->period_end->format('d M Y') }}</p>
                    </div>
                </div>
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                    {{ $salary->status === 'paid'
                        ? 'bg-green-400/30 text-white border border-green-300/40'
                        : 'bg-yellow-400/30 text-yellow-100 border border-yellow-300/40' }}">
                    {{ $salary->status === 'paid' ? '✓ Dibayar' : '⏳ Pending' }}
                </span>
            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-3 divide-x divide-gray-100 border-t border-gray-100">
            <div class="px-6 py-4 text-center">
                <p class="text-2xl font-bold text-green-600">{{ $salary->total_sessions }}</p>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Total Sesi</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($salary->rate_per_session, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Rate/Sesi (Tutor)</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($salary->total_amount, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Total Diterima</p>
            </div>
        </div>
    </div>


    {{-- Kalkulasi Gaji --}}
    <div class="card-premium p-6">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Rincian Kalkulasi</h3>

        <div class="space-y-3">
            {{-- Pendapatan dari Client --}}
            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                <div>
                    <p class="text-sm font-semibold text-blue-700">Total Pendapatan dari Client</p>
                    <p class="text-xs text-gray-400">{{ $salary->total_sessions }} sesi × Rp {{ number_format($breakdown['client_price'], 0, ',', '.') }}</p>
                </div>
                <p class="text-sm font-bold text-blue-700">Rp {{ number_format($breakdown['total_client_paid'], 0, ',', '.') }}</p>
            </div>

            {{-- Gaji Tutor --}}
            <div class="flex justify-between items-center py-3 border-b border-gray-100">
                <div>
                    <p class="text-sm font-semibold text-gray-700">Gaji Tutor</p>
                    <p class="text-xs text-gray-400">{{ $salary->total_sessions }} sesi × Rp {{ number_format($salary->rate_per_session, 0, ',', '.') }}</p>
                </div>
                <p class="text-sm font-bold text-green-700">Rp {{ number_format($salary->total_amount, 0, ',', '.') }}</p>
            </div>

            {{-- Margin Perusahaan --}}
            <div class="flex justify-between items-center py-3">
                <div>
                    <p class="text-sm font-semibold text-amber-700">Margin Perusahaan</p>
                    <p class="text-xs text-gray-400">{{ $salary->total_sessions }} sesi × Rp {{ number_format($breakdown['company_rate'], 0, ',', '.') }}</p>
                </div>
                <p class="text-sm font-bold text-amber-700">Rp {{ number_format($breakdown['company_earned'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Action: Bayar --}}
    @if($salary->status === 'pending')
    <div class="card-premium p-6">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-4">Proses Pembayaran</h3>
        <form action="{{ route('admin.salaries.pay', $salary) }}" method="POST"
              class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            @csrf
            <div>
                <p class="text-sm text-gray-600">Pastikan Anda sudah mentransfer dana ke tutor secara manual sebelum menandai ini.</p>
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-green-500/30 transition-all flex-shrink-0">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Konfirmasi Sudah Ditransfer
            </button>
        </form>
    </div>
    @endif

    @if($salary->status === 'paid')
    <div class="card-premium p-6 border-l-4 border-green-500">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Informasi Pembayaran</h3>
        <div class="flex items-center gap-6">
            @if($salary->payment_proof)
                <img src="{{ asset('storage/' . $salary->payment_proof) }}" alt="Bukti Transfer"
                     class="h-20 w-20 object-cover rounded-xl border border-gray-200">
            @else
                <div class="h-20 w-20 bg-green-50 rounded-xl flex items-center justify-center border border-green-100">
                    <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            @endif
            <div>
                <p class="text-sm text-gray-600 mb-1">Status: <span class="badge badge-green">✓ Terbayar Manual</span></p>
                <p class="text-sm text-gray-600">Tanggal Bayar: <span class="font-semibold">{{ $salary->payment_date?->format('d M Y, H:i') }}</span></p>
                @if($salary->approvedBy)
                    <p class="text-sm text-gray-600">Admin Pemroses: <span class="font-semibold text-gray-900">{{ $salary->approvedBy->name }}</span></p>
                @endif
            </div>
        </div>
    </div>
    @endif

</div>
@endsection
