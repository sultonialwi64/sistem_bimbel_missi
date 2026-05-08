@extends('layouts.app')

@section('title', 'Hasil Belajar - ' . $student->name)
@section('page-title', $student->name)
@section('page-subtitle', 'Detail hasil belajar per mata pelajaran')

@section('content')
<div class="space-y-6">

    {{-- Back Button --}}
    <a href="{{ route('client.progress.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar Anak
    </a>

    {{-- Student Info Card --}}
    <div class="card-premium overflow-hidden">
        <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        <div class="p-6 flex items-center gap-5">
            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}"
                 class="h-20 w-20 rounded-2xl object-cover ring-4 ring-indigo-100">
            <div>
                <h2 class="text-2xl font-black text-gray-900">{{ $student->name }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold">
                        {{ $subjectStats->count() }} Mata Pelajaran
                    </span>
                    <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold">
                        {{ $recentReports->count() > 0 ? $recentReports->count() . ' Sesi Terakhir' : 'Belum ada sesi' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Per-Subject Rating --}}
    @if($subjectStats->count() > 0)
        <div>
            <h3 class="text-base font-bold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Rata-rata Pemahaman per Mata Pelajaran
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($subjectStats as $stat)
                    @php
                        $score = $stat['avg_score'];
                        $colorClass = $score >= 4 ? 'text-green-600' : ($score >= 3 ? 'text-blue-600' : 'text-red-500');
                        $bgClass    = $score >= 4 ? 'bg-green-50 border-green-100' : ($score >= 3 ? 'bg-blue-50 border-blue-100' : 'bg-red-50 border-red-100');
                        $label      = $score >= 4.5 ? 'Sangat Baik' : ($score >= 3.5 ? 'Baik' : ($score >= 2.5 ? 'Cukup' : 'Perlu Perhatian'));
                    @endphp
                    <div class="p-5 rounded-2xl border bg-white shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-black text-gray-900 text-lg">{{ $stat['subject_name'] }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-1">{{ $stat['total_sessions'] }} Sesi Dilalui</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-baseline gap-0.5">
                                    <span class="text-3xl font-black {{ $colorClass }}">{{ $score }}</span>
                                    <span class="text-sm font-bold text-gray-300">/5</span>
                                </div>
                                <span class="text-[10px] font-black {{ $colorClass }} uppercase">{{ $label }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card-premium p-10 text-center">
            <svg class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <p class="font-bold text-gray-500">Belum ada data mata pelajaran</p>
            <p class="text-sm text-gray-400 mt-1">Data akan muncul setelah tutor mengisi laporan sesi</p>
        </div>
    @endif

    {{-- Recent Session Reports --}}
    <div>
        <h3 class="text-base font-bold text-gray-700 mb-3 flex items-center gap-2">
            <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Riwayat Laporan Sesi
        </h3>

        <div class="card-premium overflow-hidden">
            <div class="divide-y divide-gray-100">
                @forelse($recentReports as $report)
                    @php
                        $u = $report->student_understanding;
                        $uColor = $u >= 4 ? 'text-green-600' : ($u >= 3 ? 'text-blue-600' : 'text-red-500');
                        $uBg    = $u >= 4 ? 'bg-green-50' : ($u >= 3 ? 'bg-blue-50' : 'bg-red-50');
                        $uLabel = match(true) { $u >= 5 => 'Sangat Paham', $u >= 4 => 'Paham', $u >= 3 => 'Cukup', default => 'Kurang Paham' };
                    @endphp
                    <div class="p-5 hover:bg-gray-50/50 transition-colors">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                    <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 rounded-full text-[10px] font-bold uppercase">
                                        {{ $report->schedule->subject->name ?? '-' }}
                                    </span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase">
                                        {{ $report->created_at->format('d M Y') }}
                                    </span>
                                    <span class="text-[10px] font-medium text-gray-400 uppercase">
                                        Tutor: <span class="font-bold text-gray-600">{{ $report->tutor->user->name ?? '-' }}</span>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-bold text-gray-900">Materi:</span> {{ $report->material_covered }}
                                </p>
                                @if($report->notes_for_parent)
                                    <p class="text-sm text-gray-500 mt-2 italic border-l-2 border-indigo-200 pl-3 bg-indigo-50/30 py-2 rounded-r-lg">
                                        "{{ $report->notes_for_parent }}"
                                    </p>
                                @endif
                            </div>
                            <div class="shrink-0 text-center">
                                <div class="flex items-baseline justify-center gap-0.5">
                                    <span class="text-2xl font-black {{ $uColor }}">{{ $u }}</span>
                                    <span class="text-xs font-bold text-gray-300">/5</span>
                                </div>
                                <div class="px-2 py-0.5 rounded text-[9px] font-black uppercase {{ $uColor }} {{ $uBg }} border border-current opacity-80">
                                    {{ $uLabel }}
                                </div>
                            </div>
                        </div>

                        {{-- Tutor Rating by Student --}}
                        @if($report->tutor_rating_by_student)
                            <div class="mt-4 flex items-center gap-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Rating tutor:</span>
                                <div class="flex gap-0.5">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="h-3.5 w-3.5 {{ $i <= $report->tutor_rating_by_student ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="h-12 w-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="font-bold text-gray-500">Belum ada laporan sesi</p>
                        <p class="text-sm text-gray-400 mt-1">Laporan dari tutor akan muncul di sini setelah selesai mengajar</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
