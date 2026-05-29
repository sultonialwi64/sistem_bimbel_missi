@extends('layouts.app')

@section('title', 'Salaries')
@section('page-title', 'Salary Management')
@section('page-subtitle', 'Manage tutor salaries and payments')

@section('content')
<div class="space-y-8">
    {{-- ===== HEADER + MONTH FILTER ===== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
        <div>
            <p class="text-gray-500 text-sm">Kelola gaji tutor dan bagi hasil perusahaan</p>
        </div>
        <form method="GET" action="{{ route('admin.salaries.index') }}" class="flex items-center gap-2 w-full sm:w-auto">
            <label for="month" class="text-sm font-semibold text-gray-700">Filter Bulan:</label>
            <input type="month" name="month" id="month" value="{{ $month }}" onchange="this.form.submit()"
                   class="rounded-xl border border-gray-200 px-4 py-2 text-sm text-gray-800 focus:border-green-500 focus:ring-2 focus:ring-green-500/20 outline-none transition-all">
        </form>
    </div>


    {{-- Info Card: Bagi Hasil Per Sesi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-blue-500/30">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Harga ke Client</p>
                <p class="text-xl font-black text-gray-900">Rp 45k - 50k<span class="text-sm text-gray-400 font-normal">/sesi</span></p>
            </div>
        </div>
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-green-500/30">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Bagian Tutor</p>
                <p class="text-xl font-black text-green-600">Rp 40.000<span class="text-sm text-gray-400 font-normal">/sesi</span></p>
            </div>
        </div>
        <div class="card-premium p-5 flex items-center gap-4">
            <div class="h-12 w-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/30">
                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest">Margin Perusahaan</p>
                <p class="text-xl font-black text-amber-600">Rp 5k - 10k<span class="text-sm text-gray-400 font-normal">/sesi</span></p>
                @if(isset($totalCompanyRevenue) && $totalCompanyRevenue > 0)
                    <p class="text-xs text-gray-400 mt-0.5">Total: Rp {{ number_format($totalCompanyRevenue, 0, ',', '.') }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    All Salaries
                </h3>
                <span class="text-green-100 text-sm font-semibold">{{ $tutorSalaries->count() }} tutors</span>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Tutor</th>
                        <th class="text-left py-4 px-6">Period</th>
                        <th class="text-left py-4 px-6">Sessions</th>
                        <th class="text-left py-4 px-6">Base Salary</th>
                        <th class="text-left py-4 px-6">Total Amount</th>
                        <th class="text-left py-4 px-6">Status</th>
                        <th class="text-right py-4 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tutorSalaries as $data)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-xs">{{ substr($data->tutor->user->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $data->tutor->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $data->tutor->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-900">{{ $data->period_start->format('d M') }} - {{ $data->period_end->format('d M Y') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-700 rounded-full text-xs font-bold">
                                    {{ $data->total_sessions }} sessions
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600">Rp {{ number_format($data->base_salary, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-lg font-black text-gray-900">Rp {{ number_format($data->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                    @if($data->status === 'paid') bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200
                                    @elseif($data->status === 'unpaid') bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border border-amber-200
                                    @else bg-gradient-to-r from-gray-50 to-gray-100 text-gray-700 border border-gray-200
                                    @endif">
                                    @if($data->status === 'paid')
                                        <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    @endif
                                    {{ ucfirst($data->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($data->status === 'unpaid')
                                    @if($data->total_sessions > 0)
                                        <form action="{{ route('admin.salaries.pay-dynamic') }}" method="POST" class="inline-block" onsubmit="return confirm('Tandai gaji ini sudah dibayar?')">
                                            @csrf
                                            <input type="hidden" name="tutor_id" value="{{ $data->tutor->id }}">
                                            <input type="hidden" name="month" value="{{ $month }}">
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold text-sm hover:shadow-lg hover:shadow-green-500/30 transition-all">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Bayar
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('admin.salaries.show', $data->salary_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-semibold text-sm hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">No active tutors found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($tutorSalaries as $data)
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-md flex-shrink-0">
                            <span class="text-white font-bold text-xs">{{ substr($data->tutor->user->name, 0, 2) }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <p class="font-bold text-gray-900 text-sm">{{ $data->tutor->user->name }}</p>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold flex-shrink-0
                                    @if($data->status === 'paid') bg-green-100 text-green-700
                                    @elseif($data->status === 'unpaid') bg-amber-100 text-amber-700
                                    @else bg-gray-100 text-gray-700
                                    @endif">
                                    {{ ucfirst($data->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500">{{ $data->period_start->format('d M') }} - {{ $data->period_end->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3 text-center">
                        <div class="bg-blue-50 rounded-xl p-2">
                            <p class="text-[10px] text-blue-400 font-bold uppercase">Sesi</p>
                            <p class="text-sm font-black text-blue-700">{{ $data->total_sessions }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-2">
                            <p class="text-[10px] text-gray-400 font-bold uppercase">Per Sesi</p>
                            <p class="text-xs font-bold text-gray-700">Rp {{ number_format($data->base_salary, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-2">
                            <p class="text-[10px] text-green-400 font-bold uppercase">Total</p>
                            <p class="text-sm font-black text-green-700">Rp {{ number_format($data->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @if($data->status === 'unpaid')
                        @if($data->total_sessions > 0)
                            <form action="{{ route('admin.salaries.pay-dynamic') }}" method="POST" onsubmit="return confirm('Tandai gaji ini sudah dibayar?')">
                                @csrf
                                <input type="hidden" name="tutor_id" value="{{ $data->tutor->id }}">
                                <input type="hidden" name="month" value="{{ $month }}">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold text-xs hover:shadow-lg transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Bayar
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('admin.salaries.show', $data->salary_id) }}" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Lihat Detail
                        </a>
                    @endif
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">No active tutors found</p>
                </div>
            @endforelse
        </div>


    </div>
</div>
@endsection
