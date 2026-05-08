@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, ' . auth()->user()->name . '! Here\'s what\'s happening today.')

@section('content')
<div class="space-y-8">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Tutors Card -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide" style="color: rgba(255, 255, 255, 0.9) !important;">Total Tutors</p>
                        <p class="text-4xl font-black text-white mt-2">{{ $stats['total_tutors'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-indigo-500/20 flex items-center justify-center border border-indigo-400/30 group-hover:bg-indigo-600 transition-colors duration-300">
                        <svg class="h-6 w-6 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"/></svg>
                        {{ $stats['active_tutors'] }} Active
                    </span>
                </div>
            </div>
        </div>

        <!-- Students Card -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide" style="color: rgba(255, 255, 255, 0.9) !important;">Total Students</p>
                        <p class="text-4xl font-black text-white mt-2">{{ $stats['total_students'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-blue-500/20 flex items-center justify-center border border-blue-400/30 group-hover:bg-blue-600 transition-colors duration-300">
                        <svg class="h-6 w-6 text-blue-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">
                        {{ $stats['total_clients'] }} Clients
                    </span>
                </div>
            </div>
        </div>

        <!-- Sessions Card -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide" style="color: rgba(255, 255, 255, 0.9) !important;">Today's Sessions</p>
                        <p class="text-4xl font-black text-white mt-2">{{ $stats['today_schedules'] }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-indigo-500/20 flex items-center justify-center border border-indigo-400/30 group-hover:bg-indigo-600 transition-colors duration-300">
                        <svg class="h-6 w-6 text-indigo-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-bold">
                        {{ $stats['total_schedules'] }} Total
                    </span>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="group bg-indigo-800 rounded-2xl shadow-lg border border-indigo-700 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-wide" style="color: rgba(255, 255, 255, 0.9) !important;">Monthly Revenue</p>
                        <p class="text-2xl font-black text-white mt-2">Rp {{ number_format($stats['monthly_revenue'], 0, ',', '.') }}</p>
                    </div>
                    <div class="h-12 w-12 rounded-xl bg-blue-500/20 flex items-center justify-center border border-blue-400/30 group-hover:bg-blue-600 transition-colors duration-300">
                        <svg class="h-6 w-6 text-blue-300 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"/></svg>
                        Pending: Rp {{ number_format($stats['pending_payments'], 0, ',', '.') }}
                    </span>
                </div>
            </div>
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
                        <div class="group flex items-center justify-between p-4 bg-white rounded-xl border border-slate-100 hover:border-indigo-200 hover:shadow-sm transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm">
                                    <span class="text-indigo-700 font-bold text-sm">{{ substr($schedule->student->name, 0, 2) }}</span>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $schedule->student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $schedule->subject->name }} • {{ $schedule->tutor->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-bold text-gray-700">{{ $schedule->date->format('d M') }}</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                    @if($schedule->status === 'completed') bg-green-100 text-green-700
                                    @elseif($schedule->status === 'scheduled') bg-blue-100 text-blue-700
                                    @elseif($schedule->status === 'cancelled') bg-red-100 text-red-700
                                    @else bg-amber-100 text-amber-700
                                    @endif">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </div>
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
                        <div class="group flex items-center justify-between p-4 bg-white rounded-xl border border-slate-100 hover:border-indigo-200 hover:shadow-sm transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="h-10 w-10 rounded-lg bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm">
                                        <span class="text-indigo-700 font-bold text-sm">{{ substr($tutor->user->name, 0, 2) }}</span>
                                    </div>
                                    @if($index < 3)
                                        <div class="absolute -top-2 -right-2 h-5 w-5 bg-indigo-600 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                            <span class="text-white text-[10px] font-bold">{{ $index + 1 }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 group-hover:text-amber-600 transition-colors">{{ $tutor->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ implode(', ', $tutor->specialization ?? []) }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center gap-1 justify-end">
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
        <div class="p-6">
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
                                        <div class="h-8 w-8 rounded-full bg-indigo-50 border border-indigo-100 flex items-center justify-center shadow-sm">
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
    </div>
</div>
@endsection
