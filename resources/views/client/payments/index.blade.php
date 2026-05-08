@extends('layouts.app')

@section('title', 'Pembayaran')
@section('page-title', 'Riwayat Pembayaran')
@section('page-subtitle', 'Kelola dan pantau pembayaran Anda')

@section('content')
<div class="space-y-8">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="group bg-white rounded-3xl shadow-xl border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-400/10 to-orange-600/10 rounded-bl-full"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Tagihan Pending</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">Rp {{ number_format($totalPending, 0, ',', '.') }}</p>
                    </div>
                    <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-amber-500 via-orange-600 to-red-700 flex items-center justify-center shadow-xl shadow-amber-500/30">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                    Menunggu pembayaran
                </span>
            </div>
        </div>

        <div class="group bg-white rounded-3xl shadow-xl border border-gray-100 p-6 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/10 to-indigo-600/10 rounded-bl-full"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Transaksi</p>
                        <p class="text-3xl font-black text-gray-900 mt-2">{{ $payments->total() }}</p>
                    </div>
                    <div class="h-16 w-16 rounded-2xl bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 flex items-center justify-center shadow-xl shadow-blue-500/30">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                    Seluruh waktu
                </span>
            </div>
        </div>
    </div>

    <!-- Payments List -->
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 via-green-700 to-emerald-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Riwayat Pembayaran
                </h3>
                <span class="text-green-100 text-sm font-semibold">{{ $payments->total() }} pembayaran</span>
            </div>
        </div>

        <div class="p-6">
            @if($payments->count() > 0)
                <div class="space-y-4">
                    @foreach($payments as $payment)
                        <div class="group bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-100 hover:border-green-300 hover:shadow-xl hover:shadow-green-500/10 transition-all duration-300 p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4 flex-1">
                                    <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg shadow-green-500/20 group-hover:shadow-xl group-hover:shadow-green-500/30 transition-all">
                                        @if($payment->status === 'paid')
                                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @elseif($payment->status === 'pending')
                                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @else
                                            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $payment->student->name }}</h4>
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                                @if($payment->status === 'paid') bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700
                                                @elseif($payment->status === 'pending') bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 text-amber-700
                                                @elseif($payment->status === 'overdue') bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700
                                                @else bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 text-gray-700
                                                @endif">
                                                {{ $payment->status === 'paid' ? 'Lunas' : ($payment->status === 'pending' ? 'Menunggu' : ($payment->status === 'overdue' ? 'Terlambat' : ucfirst($payment->status))) }}
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center gap-1">
                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                                </svg>
                                                {{ $payment->payment_method ?? 'Payment' }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                @php
                                                    $period = \Carbon\Carbon::parse($payment->due_date)->subDays(7);
                                                @endphp
                                                Periode: {{ $period->translatedFormat('F Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="text-right ml-4">
                                    <p class="text-2xl font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                    @if($payment->status === 'paid')
                                        <p class="text-xs text-green-600 font-semibold mt-1">
                                            Lunas {{ $payment->payment_date ? '('.$payment->payment_date->format('d M Y').')' : '' }}
                                        </p>
                                    @else
                                        <p class="text-xs text-amber-500 font-semibold mt-1">Belum dibayar</p>
                                    @endif
                                    @if($payment->isOverdue())
                                        <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold mt-1">
                                            Terlambat!
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            @if($payment->payment_proof)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <p class="text-xs text-gray-500 mb-2">Bukti Pembayaran:</p>
                                    <img src="{{ asset('storage/' . $payment->payment_proof) }}" alt="Payment Proof" class="h-24 rounded-lg object-cover border border-gray-200">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                
                @if($payments->hasPages())
                    <div class="mt-6">
                        {{ $payments->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="h-24 w-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-semibold text-lg">Belum ada pembayaran</p>
                    <p class="text-gray-400 text-sm mt-2">Catatan pembayaran akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
