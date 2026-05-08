@extends('layouts.app')
@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')
@section('page-subtitle', 'Business insights and performance metrics')

@section('content')
<div class="space-y-8">
    <!-- Date Filter -->
    <div class="filter-bar">
        <form class="flex gap-3 flex-wrap items-end">
            <div>
                <label class="form-label text-gray-600 text-xs">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate ?? request('start_date', date('Y-m-01')) }}" class="input-premium text-sm py-2.5">
            </div>
            <div>
                <label class="form-label text-gray-600 text-xs">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate ?? request('end_date', date('Y-m-t')) }}" class="input-premium text-sm py-2.5">
            </div>
            <button type="submit" class="btn-primary text-sm px-6 py-2.5">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Generate Report
            </button>
        </form>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-green-400/10 to-emerald-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Total Revenue</p>
                        <p class="stat-value-sm">Rp {{ number_format($revenue ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-green-500 to-emerald-600 shadow-green-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-red-400/10 to-rose-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Total Expenses</p>
                        <p class="stat-value-sm">Rp {{ number_format($expenses ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-red-500 to-rose-600 shadow-red-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-blue-400/10 to-indigo-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Completed Sessions</p>
                        <p class="stat-value">{{ $totalSessions ?? 0 }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-blue-500 to-indigo-600 shadow-blue-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-purple-400/10 to-violet-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">New Students</p>
                        <p class="stat-value">{{ $newStudents ?? 0 }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-purple-500 to-violet-600 shadow-purple-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Tutors -->
    <div class="card-premium">
        <div class="section-header-amber">
            <h3 class="section-header-title">
                <svg class="h-5 w-5 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Top Performing Tutors
            </h3>
        </div>
        <div class="p-6">
            <div class="space-y-3">
                @forelse($topTutors ?? [] as $index => $tutor)
                    <div class="list-item-premium hover:border-amber-200 hover:shadow-amber-500/10">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="avatar-gradient bg-gradient-to-br from-amber-400 to-orange-600 shadow-amber-500/20">
                                    <span>{{ substr($tutor->name, 0, 2) }}</span>
                                </div>
                                @if($index < 3)
                                    <div class="absolute -top-1 -right-1 h-5 w-5 bg-gradient-to-br from-yellow-400 to-amber-600 rounded-full flex items-center justify-center border-2 border-white">
                                        <span class="text-white text-[10px] font-bold">{{ $index + 1 }}</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $tutor->name }}</p>
                                <p class="text-sm text-gray-500">{{ $tutor->total_sessions }} sessions</p>
                            </div>
                        </div>
                        <div class="text-right flex items-center gap-2">
                            <svg class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-lg font-black text-gray-900">{{ number_format($tutor->avg_understanding, 1) }}</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        <p class="font-semibold">No data available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
