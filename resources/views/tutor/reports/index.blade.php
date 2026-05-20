@extends('layouts.app')
@section('title', 'Session Reports')
@section('page-title', 'Session Reports')
@section('page-subtitle', 'View all your session reports')

@section('content')
<div class="space-y-6">
    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4 flex items-center justify-between">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Daftar Laporan Sesi
            </h3>
            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30">
                {{ $reports->total() }} laporan
            </span>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead class="bg-indigo-900">
                    <tr>
                        <th class="text-white font-bold opacity-90 text-left py-4 px-6">Tanggal</th>
                        <th class="text-white font-bold opacity-90 text-left py-4 px-6">Murid</th>
                        <th class="text-white font-bold opacity-90 text-left py-4 px-6">Mata Pelajaran</th>
                        <th class="text-white font-bold opacity-90 text-left py-4 px-6">Pemahaman</th>
                        <th class="text-white font-bold opacity-90 text-right py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6">
                                <span class="text-sm font-semibold text-gray-900">{{ $report->created_at->format('d M Y') }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="avatar-gradient bg-gradient-to-br from-purple-500 to-pink-600 shadow-purple-500/20">
                                        <span>{{ substr($report->student->name, 0, 2) }}</span>
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $report->student->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="text-sm text-gray-700">{{ $report->schedule->subject->name }}</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="badge
                                    @if($report->student_understanding >= 4) badge-green
                                    @elseif($report->student_understanding >= 3) badge-amber
                                    @else badge-red @endif">
                                    {{ $report->student_understanding }}/5
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('tutor.reports.show', $report) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold text-slate-600 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state py-12">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="font-semibold">Belum ada laporan sesi</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="sm:hidden divide-y divide-slate-100">
            @forelse($reports as $report)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-md flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ substr($report->student->name, 0, 2) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 text-sm truncate">{{ $report->student->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $report->schedule->subject->name }}</p>
                            </div>
                        </div>
                        <span class="badge flex-shrink-0
                            @if($report->student_understanding >= 4) badge-green
                            @elseif($report->student_understanding >= 3) badge-amber
                            @else badge-red @endif">
                            {{ $report->student_understanding }}/5
                        </span>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-slate-500 bg-slate-50 rounded-xl px-3 py-2">
                        <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-semibold text-slate-700">{{ $report->created_at->format('d M Y') }}</span>
                    </div>

                    <a href="{{ route('tutor.reports.show', $report) }}" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2.5 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-xl text-xs font-bold text-indigo-700 transition-all">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Detail Laporan
                    </a>
                </div>
            @empty
                <div class="py-12 text-center text-slate-500">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="font-semibold italic text-sm">Belum ada laporan sesi</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($reports->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
