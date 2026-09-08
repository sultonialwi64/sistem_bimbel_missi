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
    <div class="grid grid-cols-1 gap-8 mb-8">
        <!-- Daily Sessions Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="bg-indigo-800 border-b border-indigo-900 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                        </svg>
                        Sesi per Hari (Bulan Ini)
                    </h3>
                </div>
            </div>
            <div class="p-6">
                <div id="chart-daily-sessions" class="w-full h-80"></div>
            </div>
        </div>

        <!-- Tutors Performance Chart -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all duration-300">
            <div class="bg-indigo-800 border-b border-indigo-900 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Performa Harian per Tentor
                    </h3>
                </div>
            </div>
            <div class="p-6">
                <div id="chart-tutor-performance" class="w-full h-80"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartData = @json($chartData);
    
    // Daily Sessions Chart
    const dailyOptions = {
        series: [{
            name: 'Total Sesi',
            data: chartData.daily_sessions
        }],
        chart: {
            height: 320,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        colors: ['#4f46e5'],
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.05,
                stops: [0, 90, 100]
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 2 },
        xaxis: {
            categories: chartData.categories,
            labels: { style: { colors: '#64748b' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            decimalsInFloat: 0,
            labels: { 
                style: { colors: '#64748b' },
                formatter: function(val) { return Math.round(val); }
            }
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };

    new ApexCharts(document.querySelector("#chart-daily-sessions"), dailyOptions).render();

    // Tutor Performance Chart
    const tutorOptions = {
        series: chartData.tutor_series,
        chart: {
            height: 320,
            type: 'bar',
            stacked: true,
            toolbar: { show: false },
            fontFamily: 'inherit'
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '50%',
                borderRadius: 4
            },
        },
        dataLabels: { enabled: false },
        xaxis: {
            categories: chartData.categories,
            labels: { style: { colors: '#64748b' } },
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        yaxis: {
            decimalsInFloat: 0,
            labels: { 
                style: { colors: '#64748b' },
                formatter: function(val) { return Math.round(val); }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left'
        },
        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 }
    };

    new ApexCharts(document.querySelector("#chart-tutor-performance"), tutorOptions).render();
});
</script>
@endpush
