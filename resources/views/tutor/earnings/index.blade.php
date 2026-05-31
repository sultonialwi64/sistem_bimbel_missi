@extends('layouts.app')

@section('title', 'My Earnings')
@section('page-title', 'My Earnings')
@section('page-subtitle', 'Track your salary and payment history')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid: 1 col on mobile, 3 on desktop -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-green-400/10 to-emerald-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Total Diterima</p>
                        <p class="stat-value-sm">Rp {{ number_format($totalEarned, 0, ',', '.') }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-green-500 to-emerald-600 shadow-lg shadow-green-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <span class="badge badge-green">Sudah dibayar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-amber-400/10 to-orange-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Menunggu Bayar</p>
                        <p class="stat-value-sm">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-amber-500 to-orange-600 shadow-lg shadow-amber-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <span class="badge badge-amber">Menunggu pembayaran</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-blue-400/10 to-indigo-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Total Catatan</p>
                        <p class="stat-value">{{ $salariesFromDb->count() + ($currentMonthVirtual ? 1 : 0) }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl flex items-center justify-center bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <span class="badge badge-indigo">Periode gaji</span>
            </div>
        </div>
    </div>

    <!-- Salary History -->
    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Riwayat Gaji
            </h3>
            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30">
                {{ $salariesFromDb->count() + ($currentMonthVirtual ? 1 : 0) }} periode
            </span>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Periode</th>
                        <th class="text-left py-4 px-6">Sesi</th>
                        <th class="text-left py-4 px-6">Gaji Pokok</th>
                        <th class="text-left py-4 px-6">Total</th>
                        <th class="text-left py-4 px-6">Status</th>
                        <th class="text-left py-4 px-6">Tgl Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    {{-- Virtual row: bulan berjalan belum dibayar --}}
                    @if($currentMonthVirtual)
                        <tr class="hover:bg-amber-50/40 transition-colors bg-amber-50/20">
                            <td class="py-4 px-6">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $currentMonthVirtual->period_start->format('d M') }} - {{ $currentMonthVirtual->period_end->format('d M Y') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge badge-indigo">{{ $currentMonthVirtual->total_sessions }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-700">Rp {{ number_format($currentMonthVirtual->base_salary, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-base font-black text-gray-900">Rp {{ number_format($currentMonthVirtual->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge badge-amber">Unpaid</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-400">Menunggu admin</span>
                            </td>
                        </tr>
                    @endif

                    {{-- Record gaji dari database --}}
                    @forelse($salariesFromDb as $salary)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $salary->period_start->format('d M') }} - {{ $salary->period_end->format('d M Y') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge badge-indigo">{{ $salary->total_sessions }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-700">Rp {{ number_format($salary->base_salary, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-base font-black text-gray-900">Rp {{ number_format($salary->total_amount, 0, ',', '.') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge
                                    @if($salary->status === 'paid') badge-green
                                    @elseif(in_array($salary->status, ['pending','unpaid'])) badge-amber
                                    @else badge-gray @endif">
                                    {{ $salary->status === 'unpaid' || $salary->status === 'pending' ? 'Unpaid' : ucfirst($salary->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-600">
                                    {{ $salary->payment_date ? $salary->payment_date->format('d M Y') : '-' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        @if(!$currentMonthVirtual)
                        <tr>
                            <td colspan="6">
                                <div class="empty-state py-12">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold">Belum ada catatan gaji</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="sm:hidden divide-y divide-slate-100">
            {{-- Virtual row bulan berjalan --}}
            @if($currentMonthVirtual)
                <div class="p-4 space-y-3 bg-amber-50/30">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Periode</div>
                            <p class="font-bold text-slate-800 text-sm">
                                {{ $currentMonthVirtual->period_start->format('d M') }} – {{ $currentMonthVirtual->period_end->format('d M Y') }}
                            </p>
                        </div>
                        <span class="badge badge-amber flex-shrink-0">Unpaid</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-indigo-50 rounded-xl p-2.5 text-center">
                            <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider">Sesi</div>
                            <div class="text-lg font-black text-indigo-700 mt-0.5">{{ $currentMonthVirtual->total_sessions }}</div>
                        </div>
                        <div class="bg-green-50 rounded-xl p-2.5 text-center border border-green-100">
                            <div class="text-[10px] font-bold text-green-500 uppercase tracking-wider">Total</div>
                            <div class="text-xs font-black text-green-700 mt-1 leading-tight">Rp {{ number_format($currentMonthVirtual->total_amount, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs bg-slate-50 rounded-xl px-3 py-2 border border-slate-100">
                        <div>
                            <span class="text-slate-400 font-semibold">Gaji Pokok: </span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($currentMonthVirtual->base_salary, 0, ',', '.') }}</span>
                        </div>
                        <span class="text-slate-400 italic text-[10px]">Menunggu admin</span>
                    </div>
                </div>
            @endif

            {{-- Record dari DB --}}
            @forelse($salariesFromDb as $salary)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Periode</div>
                            <p class="font-bold text-slate-800 text-sm">
                                {{ $salary->period_start->format('d M') }} – {{ $salary->period_end->format('d M Y') }}
                            </p>
                        </div>
                        <span class="badge flex-shrink-0
                            @if($salary->status === 'paid') badge-green
                            @elseif(in_array($salary->status, ['pending','unpaid'])) badge-amber
                            @else badge-gray @endif">
                            {{ $salary->status === 'unpaid' || $salary->status === 'pending' ? 'Unpaid' : ucfirst($salary->status) }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="bg-indigo-50 rounded-xl p-2.5 text-center">
                            <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider">Sesi</div>
                            <div class="text-lg font-black text-indigo-700 mt-0.5">{{ $salary->total_sessions }}</div>
                        </div>
                        <div class="bg-green-50 rounded-xl p-2.5 text-center border border-green-100">
                            <div class="text-[10px] font-bold text-green-500 uppercase tracking-wider">Total</div>
                            <div class="text-xs font-black text-green-700 mt-1 leading-tight">Rp {{ number_format($salary->total_amount, 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs bg-slate-50 rounded-xl px-3 py-2 border border-slate-100">
                        <div>
                            <span class="text-slate-400 font-semibold">Gaji Pokok: </span>
                            <span class="font-bold text-slate-700">Rp {{ number_format($salary->base_salary, 0, ',', '.') }}</span>
                        </div>
                        @if($salary->payment_date)
                        <div class="text-right">
                            <span class="text-slate-400 font-semibold">Dibayar: </span>
                            <span class="font-bold text-green-600">{{ $salary->payment_date->format('d M Y') }}</span>
                        </div>
                        @else
                        <span class="text-slate-400 italic text-[10px]">Belum dibayar</span>
                        @endif
                    </div>
                </div>
            @empty
                @if(!$currentMonthVirtual)
                <div class="py-12 text-center text-slate-500">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold italic text-sm">Belum ada catatan gaji</p>
                    </div>
                </div>
                @endif
            @endforelse
        </div>
    </div>
</div>
@endsection
