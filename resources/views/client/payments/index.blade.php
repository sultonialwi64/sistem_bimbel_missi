@extends('layouts.app')

@section('title', 'Pembayaran')
@section('page-title', 'Riwayat Pembayaran')
@section('page-subtitle', 'Kelola dan pantau pembayaran Anda')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards: 2 col on mobile, 2 on desktop -->
    <div class="grid grid-cols-2 gap-4">
        <div class="group bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-400/10 to-orange-600/10 rounded-bl-full"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Tagihan Pending</p>
                        <p class="text-xl sm:text-3xl font-black text-gray-900 mt-1 leading-tight">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                    </div>
                    <div class="h-11 w-11 sm:h-14 sm:w-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-500 via-orange-600 to-red-700 flex items-center justify-center shadow-lg shadow-amber-500/30 flex-shrink-0 ml-2">
                        <svg class="h-5 w-5 sm:h-7 sm:w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full text-[10px] font-bold">
                    Menunggu pembayaran
                </span>
            </div>
        </div>

        <div class="group bg-white rounded-2xl shadow-md border border-gray-100 p-4 sm:p-6 hover:shadow-xl transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-400/10 to-indigo-600/10 rounded-bl-full"></div>
            <div class="relative z-10">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                        <p class="text-xl sm:text-3xl font-black text-gray-900 mt-1 leading-tight">{{ $payments->total() }}</p>
                    </div>
                    <div class="h-11 w-11 sm:h-14 sm:w-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center shadow-lg shadow-blue-500/30 flex-shrink-0 ml-2">
                        <svg class="h-5 w-5 sm:h-7 sm:w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold">
                    Seluruh waktu
                </span>
            </div>
        </div>
    </div>

    <!-- Payments List -->
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-green-700 to-emerald-800 px-5 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Riwayat Pembayaran
                </h3>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30">
                    {{ $payments->total() }} pembayaran
                </span>
            </div>
        </div>

        @if($payments->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($payments as $payment)
                    <div class="group p-4 sm:p-5 hover:bg-slate-50/50 transition-colors">
                        <!-- Top row: icon + name/period + amount -->
                        <div class="flex items-start gap-3">
                            <!-- Icon -->
                            <div class="h-11 w-11 rounded-xl flex-shrink-0 flex items-center justify-center shadow-md
                                @if($payment->status === 'paid') bg-gradient-to-br from-green-500 to-emerald-600 shadow-green-500/20
                                @elseif($payment->status === 'pending') bg-gradient-to-br from-amber-500 to-orange-600 shadow-amber-500/20
                                @else bg-gradient-to-br from-red-500 to-pink-600 shadow-red-500/20 @endif">
                                @if($payment->status === 'paid')
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @elseif($payment->status === 'pending')
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-gray-900 text-sm group-hover:text-green-600 transition-colors truncate">{{ $payment->student->name }}</h4>
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-0.5">
                                            <span class="text-xs text-gray-500">{{ $payment->payment_method ?? 'Transfer' }}</span>
                                            @php
                                                $period = \Carbon\Carbon::parse($payment->due_date)->subDays(7);
                                            @endphp
                                            <span class="text-xs text-gray-400">{{ $period->translatedFormat('F Y') }}</span>
                                        </div>
                                    </div>
                                    <!-- Amount + status -->
                                    <div class="text-right flex-shrink-0">
                                        <p class="font-black text-gray-900 text-sm sm:text-base">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold mt-0.5
                                            @if($payment->status === 'paid') bg-green-100 text-green-700
                                            @elseif($payment->status === 'pending') bg-amber-100 text-amber-700
                                            @elseif($payment->status === 'overdue') bg-red-100 text-red-700
                                            @else bg-gray-100 text-gray-600 @endif">
                                            {{ $payment->status === 'paid' ? 'Lunas' : ($payment->status === 'pending' ? 'Menunggu' : ($payment->status === 'overdue' ? 'Terlambat' : ucfirst($payment->status))) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Payment date info -->
                                @if($payment->status === 'paid' && $payment->payment_date)
                                    <p class="text-[10px] text-green-600 font-semibold mt-1.5">
                                        ✓ Lunas pada {{ $payment->payment_date->format('d M Y') }}
                                    </p>
                                @elseif($payment->isOverdue())
                                    <span class="inline-flex items-center px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-[10px] font-bold mt-1.5">
                                        ⚠ Terlambat!
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if($payment->payment_proof)
                            <div class="mt-3 pt-3 border-t border-gray-100 ml-14">
                                <p class="text-[10px] text-gray-500 mb-1.5">Bukti Pembayaran:</p>
                                <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Bukti Pembayaran" class="h-20 rounded-xl object-cover border border-gray-200 shadow-sm">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($payments->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-slate-50">
                    {{ $payments->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold">Belum ada pembayaran</p>
                <p class="text-gray-400 text-sm mt-1">Catatan pembayaran akan muncul di sini</p>
            </div>
        @endif
    </div>
</div>
@endsection
