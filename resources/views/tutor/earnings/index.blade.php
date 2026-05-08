@extends('layouts.app')

@section('title', 'My Earnings')
@section('page-title', 'My Earnings')
@section('page-subtitle', 'Track your salary and payment history')

@section('content')
<div class="space-y-8">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-green-400/10 to-emerald-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Total Earned</p>
                        <p class="stat-value-sm">Rp {{ number_format($totalEarned, 0, ',', '.') }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-green-500 to-emerald-600 shadow-green-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <span class="badge badge-green">All time paid</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-amber-400/10 to-orange-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Pending Amount</p>
                        <p class="stat-value-sm">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-amber-500 to-orange-600 shadow-amber-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <span class="badge badge-amber">Awaiting payment</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-decoration-tr bg-gradient-to-br from-blue-400/10 to-indigo-600/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="stat-label">Total Records</p>
                        <p class="stat-value">{{ $salaries->total() }}</p>
                    </div>
                    <div class="stat-icon-box bg-gradient-to-br from-blue-500 to-indigo-600 shadow-blue-500/30">
                        <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <span class="badge badge-blue">Salary periods</span>
            </div>
        </div>
    </div>

    <!-- Salary History -->
    <div class="card-premium">
        <div class="section-header-indigo">
            <h3 class="section-header-title">
                <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Salary History
            </h3>
        </div>
        <div class="table-container">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Sessions</th>
                        <th>Rate</th>
                        <th>Base</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Paid On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salaries as $salary)
                        <tr>
                            <td><span class="text-sm font-semibold text-gray-900">{{ $salary->period_start->format('d M') }} - {{ $salary->period_end->format('d M Y') }}</span></td>
                            <td><span class="badge badge-blue">{{ $salary->total_sessions }}</span></td>
                            <td><span class="text-sm text-gray-700">Rp {{ number_format($salary->rate_per_session, 0, ',', '.') }}</span></td>
                            <td><span class="text-sm text-gray-700">Rp {{ number_format($salary->base_salary, 0, ',', '.') }}</span></td>
                            <td><span class="text-base font-black text-gray-900">Rp {{ number_format($salary->total_amount, 0, ',', '.') }}</span></td>
                            <td>
                                <span class="badge
                                    @if($salary->status === 'paid') badge-green
                                    @elseif($salary->status === 'pending') badge-amber
                                    @else badge-gray @endif">
                                    {{ ucfirst($salary->status) }}
                                </span>
                            </td>
                            <td><span class="text-sm text-gray-600">{{ $salary->payment_date ? $salary->payment_date->format('d M Y') : '-' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="8"><div class="empty-state"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg><p class="font-semibold">No salary records yet</p></div></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $salaries->links() }}</div>
</div>
@endsection
