@extends('layouts.app')

@section('title', 'Jadwal Belajar')
@section('page-title', 'Jadwal Anak Saya')
@section('page-subtitle', 'Jadwal belajar yang akan datang')

@section('content')
<div class="space-y-6">
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-5 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jadwal Mendatang
                </h3>
                <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30">
                    {{ $schedules->total() }} jadwal
                </span>
            </div>
        </div>

        @if($schedules->count() > 0)
            <div class="divide-y divide-slate-100">
                @foreach($schedules as $schedule)
                    <div class="group p-4 sm:p-5 hover:bg-blue-50/30 transition-colors">
                        <!-- Top row: avatar + name + date badge -->
                        <div class="flex items-start gap-3 mb-3">
                            <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-blue-500/20 flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ substr($schedule->student->name, 0, 2) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="min-w-0">
                                        <h4 class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors text-sm truncate">{{ $schedule->student->name }}</h4>
                                        <p class="text-xs text-gray-500 truncate">{{ $schedule->subject->name }}</p>
                                    </div>
                                    <!-- Date badge -->
                                    <span class="inline-flex items-center px-2.5 py-1 bg-blue-100 text-blue-700 rounded-xl text-xs font-bold flex-shrink-0">
                                        {{ $schedule->date->format('d M') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Info grid: time + tutor + level -->
                        <div class="ml-14 grid grid-cols-2 gap-x-4 gap-y-1.5">
                            <div class="flex items-center gap-1.5 text-xs text-gray-600">
                                <svg class="h-3.5 w-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="font-semibold">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-gray-600">
                                <svg class="h-3.5 w-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="truncate">{{ $schedule->tutor->user->name }}</span>
                            </div>
                            @if($schedule->subject->level)
                            <div class="flex items-center gap-1.5 text-xs text-gray-500 col-span-2">
                                <svg class="h-3.5 w-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span>{{ $schedule->subject->level }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Status + relative time -->
                        <div class="ml-14 mt-3 flex items-center justify-between">
                            @if($schedule->status === 'completed' || $schedule->attendance)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-bold">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold">
                                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Dijadwalkan
                                </span>
                            @endif
                            <span class="text-[10px] text-gray-400 font-medium">{{ $schedule->date->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($schedules->hasPages())
                <div class="px-5 py-4 border-t border-gray-100 bg-slate-50">
                    {{ $schedules->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <p class="text-gray-500 font-semibold">Tidak ada jadwal mendatang</p>
                <p class="text-gray-400 text-sm mt-1">Semua jadwal sudah selesai atau belum ada sesi yang dijadwalkan</p>
            </div>
        @endif
    </div>
</div>
@endsection
