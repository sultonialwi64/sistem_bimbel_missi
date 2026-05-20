@extends('layouts.app')

@section('title', 'Laporan Sesi')
@section('page-title', 'Laporan Sesi')
@section('page-subtitle', 'Laporan perkembangan belajar anak')

@section('content')
<div class="space-y-6">
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-purple-700 to-pink-800 px-5 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Semua Laporan Sesi
                </h3>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30">
                    {{ $reports->total() }} laporan
                </span>
            </div>
        </div>

        @if($reports->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($reports as $report)
                    <a href="{{ route('client.reports.show', $report) }}" class="group block p-4 sm:p-5 hover:bg-purple-50/30 transition-colors">
                        <div class="flex items-start gap-3">
                            <!-- Avatar -->
                            <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg shadow-purple-500/20 flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ substr($report->student->name, 0, 2) }}</span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-1.5">
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-gray-900 group-hover:text-purple-600 transition-colors text-sm truncate">{{ $report->student->name }}</h4>
                                        <p class="text-xs text-gray-500 truncate">{{ $report->schedule->subject->name }} • {{ $report->tutor->user->name }}</p>
                                    </div>
                                    <!-- Score badge -->
                                    <div class="flex-shrink-0 text-center">
                                        <div class="inline-flex flex-col items-center px-3 py-1.5 rounded-xl
                                            @if($report->student_understanding >= 4) bg-green-100 border border-green-200 text-green-700
                                            @elseif($report->student_understanding >= 3) bg-amber-100 border border-amber-200 text-amber-700
                                            @else bg-red-100 border border-red-200 text-red-700 @endif">
                                            <span class="text-lg font-black leading-none">{{ $report->student_understanding }}</span>
                                            <span class="text-[10px] font-bold">/5</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Material covered -->
                                @if($report->material_covered)
                                    <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed">{{ $report->material_covered }}</p>
                                @endif

                                <!-- Notes for parent -->
                                @if($report->notes_for_parent)
                                    <p class="text-xs text-gray-500 italic mt-1.5 line-clamp-1">"{{ $report->notes_for_parent }}"</p>
                                @endif

                                <!-- Date -->
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-[10px] text-gray-400 font-medium">{{ $report->created_at->format('d M Y') }}</span>
                                    <span class="text-[10px] text-gray-400">{{ $report->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($reports->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-slate-50">
                    {{ $reports->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold">Belum ada laporan sesi</p>
                <p class="text-gray-400 text-sm mt-1">Laporan akan muncul setelah sesi bimbingan selesai</p>
            </div>
        @endif
    </div>
</div>
@endsection
