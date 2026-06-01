@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '! Here\'s what\'s happening today.')

@section('content')
<div class="space-y-8">
    <div class="flex justify-end">
        <form action="{{ route('admin.dashboard') }}" method="GET" class="flex w-full flex-col gap-2 rounded-2xl border border-indigo-700 bg-indigo-800 p-3 shadow-lg sm:w-auto sm:flex-row sm:items-center">
            <span class="text-xs font-bold uppercase tracking-widest text-indigo-100 sm:mr-1">
                Filter Pendapatan
            </span>
            <input type="month" name="financial_month" value="{{ $financialMonth }}" class="rounded-xl border border-indigo-600 bg-indigo-900 px-3 py-2 text-sm font-bold text-white shadow-sm focus:border-blue-300 focus:ring-2 focus:ring-blue-300">
            <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-bold text-white shadow-sm transition-all hover:bg-blue-500">
                Terapkan
            </button>
            @if($financialMonth !== now()->format('Y-m'))
                <a href="{{ route('admin.dashboard') }}" class="rounded-xl border border-indigo-600 px-4 py-2 text-center text-sm font-bold text-indigo-100 transition-all hover:bg-indigo-700">
                    Bulan Ini
                </a>
            @endif
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-5 gap-6">

        {{-- Card Template: [Label + Icon] / [Value] / [Sub-badge] --}}

        <!-- 1. Total Tutors -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-widest text-white/70">Total Tutors</p>
                <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-indigo-500/20 border border-indigo-400/30 flex items-center justify-center group-hover:bg-indigo-600 transition-colors">
                    <svg class="h-5 w-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-white leading-none mb-4">{{ $stats['total_tutors'] }}</p>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/></svg>
                {{ $stats['active_tutors'] }} Active
            </span>
        </div>

        <!-- 2. Total Students -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-widest text-white/70">Total Students</p>
                <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-blue-500/20 border border-blue-400/30 flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                    <svg class="h-5 w-5 text-blue-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-white leading-none mb-4">{{ $stats['total_students'] }}</p>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                {{ $stats['total_clients'] }} Clients
            </span>
        </div>

        <!-- 3. Today's Sessions -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <p class="text-xs font-bold uppercase tracking-widest text-white/70">Today's Sessions</p>
                <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-indigo-500/20 border border-indigo-400/30 flex items-center justify-center group-hover:bg-indigo-600 transition-colors">
                    <svg class="h-5 w-5 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-4xl font-black text-white leading-none mb-4">{{ $stats['today_schedules'] }}</p>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                {{ $stats['total_schedules'] }} Total
            </span>
        </div>

        <!-- 4. Monthly Revenue -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-white/70">Monthly Revenue</p>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-wider text-indigo-200">{{ \Carbon\Carbon::parse($financialMonth)->translatedFormat('M Y') }}</p>
                </div>
                <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-blue-500/20 border border-blue-400/30 flex items-center justify-center group-hover:bg-blue-600 transition-colors">
                    <svg class="h-5 w-5 text-blue-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-black text-white leading-none mb-4 whitespace-nowrap">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold whitespace-nowrap">
                <svg class="h-3 w-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
                Pending: Rp {{ number_format($stats['pending_payments'], 0, ',', '.') }}
            </span>
        </div>

        <!-- 5. Net Income (Pendapatan Bersih) -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-white/70">Pendapatan Bersih</p>
                    <p class="mt-1 text-[10px] font-bold uppercase tracking-wider text-indigo-200">{{ \Carbon\Carbon::parse($financialMonth)->translatedFormat('M Y') }}</p>
                </div>
                <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-green-500/20 border border-green-400/30 flex items-center justify-center group-hover:bg-green-600 transition-colors">
                    <svg class="h-5 w-5 text-green-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-black text-white leading-none mb-4 whitespace-nowrap">Rp {{ number_format($stats['net_income'], 0, ',', '.') }}</p>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                <svg class="h-3 w-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $stats['net_income_sessions'] }} sesi terlaksana
            </span>
        </div>

    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Schedules -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="bg-indigo-800 border-b border-indigo-900 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Recent Schedules
                    </h3>
                    <a href="{{ route('admin.schedules.index') }}" class="text-white hover:text-indigo-200 text-sm font-semibold flex items-center gap-1 transition-colors">
                        View All
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @forelse($recentSchedules as $schedule)
                        <div class="group p-4 bg-white rounded-xl border border-slate-100 hover:border-indigo-200 hover:shadow-sm transition-all duration-300">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-9 w-9 flex-shrink-0 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm">
                                        <span class="text-indigo-700 font-bold text-xs">{{ substr($schedule->student->name, 0, 2) }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors text-sm truncate">{{ $schedule->student->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $schedule->subject->name }} • {{ Str::limit($schedule->tutor->user->name, 15) }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold flex-shrink-0
                                    @if($schedule->status === 'completed') bg-green-100 text-green-700
                                    @elseif($schedule->status === 'scheduled') bg-blue-100 text-blue-700
                                    @elseif($schedule->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-amber-100 text-amber-700
                                    @endif">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 ml-12">{{ $schedule->date->translatedFormat('d M Y') }} • {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No schedules yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Tutors -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="bg-indigo-800 border-b border-indigo-900 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Top Tutors
                    </h3>
                    <a href="{{ route('admin.tutors.index') }}" class="text-white hover:text-indigo-200 text-sm font-semibold flex items-center gap-1 transition-colors">
                        View All
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($topTutors as $index => $tutor)
                        <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-white rounded-xl border border-slate-100 hover:border-indigo-200 hover:shadow-sm transition-all duration-300 gap-3 sm:gap-0">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm">
                                        <span class="text-indigo-700 font-bold text-sm">{{ substr($tutor->user->name, 0, 2) }}</span>
                                    </div>
                                    @if($index < 3)
                                        <div class="absolute -top-2 -right-2 h-5 w-5 bg-indigo-600 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                            <span class="text-white text-[10px] font-bold">{{ $index + 1 }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors truncate">{{ $tutor->user->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ implode(', ', $tutor->specialization ?? []) }}</p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right ml-14 sm:ml-0 mt-2 sm:mt-0 flex flex-row sm:flex-col justify-between sm:justify-end items-center sm:items-end w-full sm:w-auto">
                                <div class="flex items-center gap-1">
                                    <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    <span class="text-lg font-black text-gray-900">{{ number_format($tutor->rating_avg, 1) }}</span>
                                </div>
                                <p class="text-xs text-gray-500">{{ $tutor->total_sessions }} sessions</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Payments -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-300">
        <div class="bg-indigo-800 border-b border-indigo-900 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zm11 0a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Recent Payments
                </h3>
                <a href="{{ route('admin.payments.index') }}" class="text-white hover:text-indigo-200 text-sm font-semibold flex items-center gap-1 transition-colors">
                    View All
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
        {{-- Desktop Table (hidden on mobile) --}}
        <div class="hidden sm:block p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Client</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Student</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Amount</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-gray-500 uppercase tracking-wide">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                            <tr class="group hover:bg-slate-50 transition-all duration-300">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm flex-shrink-0">
                                            <span class="text-indigo-700 font-bold text-xs">{{ substr($payment->client->user->name, 0, 2) }}</span>
                                        </div>
                                        <span class="font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ $payment->client->user->name }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">{{ $payment->student->name }}</td>
                                <td class="py-4 px-4">
                                    <span class="text-base font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                        @if($payment->status === 'paid') bg-green-100 text-green-700
                                        @elseif($payment->status === 'pending') bg-amber-100 text-amber-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-sm text-gray-600">{{ $payment->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">No payments yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Mobile Card List (hidden on desktop) --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($recentPayments as $payment)
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-9 w-9 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm flex-shrink-0">
                                <span class="text-indigo-700 font-bold text-xs">{{ substr($payment->client->user->name, 0, 2) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 truncate text-sm">{{ $payment->client->user->name }}</p>
                                <p class="text-xs text-gray-500 truncate">untuk: {{ $payment->student->name }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold flex-shrink-0 ml-2
                            @if($payment->status === 'paid') bg-green-100 text-green-700
                            @elseif($payment->status === 'pending') bg-amber-100 text-amber-700
                            @else bg-red-100 text-red-700
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                        <p class="text-base font-black text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-400">{{ $payment->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8 text-sm">No payments yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
