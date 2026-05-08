@extends('layouts.app')
@section('title', 'Detail Laporan')
@section('page-title', 'Detail Laporan Sesi')
@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('tutor.reports.index') }}" class="text-indigo-600 hover:text-indigo-800">← Kembali ke Daftar Laporan</a>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="text-sm text-gray-500">Siswa</label>
                <p class="text-lg font-semibold">{{ $report->student->name }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Mata Pelajaran</label>
                <p class="text-lg font-semibold">{{ $report->schedule->subject->name }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Tanggal</label>
                <p class="text-lg font-semibold">{{ $report->created_at->format('d M Y') }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Tingkat Pemahaman</label>
                <p class="text-2xl font-bold {{ $report->student_understanding >= 4 ? 'text-green-600' : ($report->student_understanding >= 3 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $report->student_understanding }}<span class="text-sm text-gray-500">/5</span>
                </p>
            </div>
        </div>
        
        <div class="space-y-4 border-t pt-6">
            <div>
                <label class="text-sm font-medium text-gray-700">Materi yang Dipelajari</label>
                <p class="mt-1 text-gray-800">{{ $report->material_covered }}</p>
            </div>
            

            
            @if($report->notes_for_parent)
                <div>
                    <label class="text-sm font-medium text-gray-700">Catatan untuk Orang Tua</label>
                    <p class="mt-1 text-gray-800">{{ $report->notes_for_parent }}</p>
                </div>
            @endif
            
            @if($report->tutor_rating_by_student)
                <div>
                    <label class="text-sm font-medium text-gray-700">Rating dari Tutor untuk Anak pada sesi ini</label>
                    <p class="text-xs text-gray-500 mb-2">Penilaian tutor terhadap performa siswa pada sesi ini.</p>
                    <div class="mt-1 flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-6 w-6 {{ $i <= $report->tutor_rating_by_student ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
            @endif

            @if($report->parent_rating)
                <div>
                    <label class="text-sm font-medium text-gray-700">Rating dari Orang Tua</label>
                    <div class="mt-1 flex">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="h-6 w-6 {{ $i <= $report->parent_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
            @endif

            @if($report->parent_feedback)
                <div>
                    <label class="text-sm font-medium text-gray-700">Feedback dari Orang Tua</label>
                    <p class="mt-1 text-gray-800 italic bg-gray-50 p-3 rounded-lg border border-gray-100">"{{ $report->parent_feedback }}"</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
