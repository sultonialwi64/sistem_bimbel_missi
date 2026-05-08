@extends('layouts.app')

@section('title', 'Laporan Sesi')
@section('page-title', 'Laporan Sesi')
@section('page-subtitle', 'Laporan perkembangan belajar anak')

@section('content')
<div class="space-y-8">
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-pink-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Semua Laporan Sesi
                </h3>
                <span class="text-purple-100 text-sm font-semibold">{{ $reports->total() }} laporan</span>
            </div>
        </div>

        <div class="p-6">
            @if($reports->count() > 0)
                <div class="space-y-4">
                    @foreach($reports as $report)
                        <a href="{{ route('client.reports.show', $report) }}" class="group block bg-gradient-to-br from-gray-50 to-white rounded-2xl border-2 border-gray-100 hover:border-purple-300 hover:shadow-xl hover:shadow-purple-500/10 transition-all duration-300 p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg">
                                            <span class="text-white font-bold text-xs">{{ substr($report->student->name, 0, 2) }}</span>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 group-hover:text-purple-600 transition-colors">{{ $report->student->name }}</h4>
                                            <p class="text-sm text-gray-500">{{ $report->schedule->subject->name }} • {{ $report->tutor->user->name }}</p>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mb-3 line-clamp-2">{{ $report->material_covered }}</p>
                                    
                                    @if($report->homework_assigned)
                                        <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 text-amber-700 rounded-lg text-xs font-semibold mb-3">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                            {{-- Homework removed --}}
                                        </div>
                                    @endif
                                    
                                    @if($report->notes_for_parent)
                                        <p class="text-sm text-gray-600 italic">"{{ Str::limit($report->notes_for_parent, 100) }}"</p>
                                    @endif
                                </div>
                                
                                <div class="text-right ml-4">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-xl
                                        @if($report->student_understanding >= 4) bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700
                                        @elseif($report->student_understanding >= 3) bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 text-amber-700
                                        @else bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700
                                        @endif">
                                        <span class="text-2xl font-black">{{ $report->student_understanding }}</span>
                                        <span class="text-sm font-bold">/5</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">{{ $report->created_at->format('d M Y') }}</p>
                                    <p class="text-xs text-gray-400">{{ $report->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                
                @if($reports->hasPages())
                    <div class="mt-6">
                        {{ $reports->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="h-24 w-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-semibold text-lg">Belum ada laporan sesi</p>
                    <p class="text-gray-400 text-sm mt-2">Laporan akan muncul setelah sesi bimbingan belajar selesai</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
