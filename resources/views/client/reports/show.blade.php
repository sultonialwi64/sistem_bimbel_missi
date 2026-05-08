@extends('layouts.app')

@section('title', 'Detail Laporan Sesi')
@section('page-title', 'Laporan Sesi')
@section('page-subtitle', 'Detail laporan perkembangan belajar anak')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    <!-- Back Button -->
    <a href="{{ route('client.reports.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-semibold group">
        <svg class="h-5 w-5 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar Laporan
    </a>

    <!-- Main Report Card -->
    <div class="card-premium overflow-hidden">
        <!-- Gradient Header -->
        <div class="bg-gradient-to-r from-purple-600 via-purple-700 to-pink-800 px-8 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-16 w-16 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-xl">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $report->schedule->subject->name }}</h2>
                        <p class="text-purple-100">{{ $report->created_at->format('d F Y') }}</p>
                    </div>
                </div>
                
                <div class="text-right">
                    <div class="inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <span class="text-4xl font-black text-white">{{ $report->student_understanding }}</span>
                        <span class="text-xl font-bold text-purple-100">/5</span>
                    </div>
                    <p class="text-purple-100 text-sm mt-2">Tingkat Pemahaman</p>
                </div>
            </div>
        </div>

        <div class="p-8">
            <!-- Student & Tutor Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ substr($report->student->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">Siswa</p>
                            <h3 class="text-xl font-bold text-gray-900">{{ $report->student->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $report->student->grade_level }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border border-purple-100">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ substr($report->tutor->user->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-purple-600 uppercase tracking-wide">Tutor</p>
                            <h3 class="text-xl font-bold text-gray-900">{{ $report->tutor->user->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $report->tutor->user->phone ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Details -->
            <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-100 mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-lg font-bold text-amber-800">Informasi Sesi</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-amber-600 font-semibold mb-1">Mata Pelajaran</p>
                        <p class="font-bold text-gray-900">{{ $report->schedule->subject->name }}</p>
                        <p class="text-sm text-gray-500">{{ $report->schedule->subject->level }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-amber-600 font-semibold mb-1">Tanggal & Waktu</p>
                        <p class="font-bold text-gray-900">{{ $report->schedule->date->format('d M Y') }}</p>
                        <p class="text-sm text-gray-500">{{ $report->schedule->start_time }} - {{ $report->schedule->end_time }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-amber-600 font-semibold mb-1">Status Sesi</p>
                        <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-full text-xs font-bold">
                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Selesai
                        </span>
                    </div>
                </div>
            </div>

            <!-- Material Covered -->
            <div class="mb-8">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Materi yang Dipelajari</h3>
                </div>
                <div class="bg-white rounded-2xl border-2 border-gray-100 p-6">
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $report->material_covered }}</p>
                </div>
            </div>



            <!-- Notes for Parent -->
            @if($report->notes_for_parent)
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Catatan dari Tutor</h3>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl border-2 border-purple-200 p-6">
                        <p class="text-gray-700 text-lg leading-relaxed italic">"{{ $report->notes_for_parent }}"</p>
                    </div>
                </div>
            @endif


            <!-- Student Rating for Tutor -->
            @if($report->tutor_rating_by_student)
                <div class="mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Rating dari Tutor untuk Anak pada sesi ini</h3>
                    </div>
                    <div class="bg-white rounded-2xl border-2 border-gray-100 p-6 space-y-4">
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-8 w-8 {{ $i <= $report->tutor_rating_by_student ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-3 text-2xl font-bold text-gray-900">{{ $report->tutor_rating_by_student }}<span class="text-lg text-gray-500">/5</span></span>
                        </div>
                    </div>
                </div>
            @endif



            <!-- Understanding Level Indicator -->
            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border border-green-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Evaluasi Pemahaman</h3>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-black {{ $report->student_understanding >= 4 ? 'text-green-600' : ($report->student_understanding >= 3 ? 'text-amber-600' : 'text-red-600') }}">
                            {{ $report->student_understanding }}/5
                        </p>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-semibold text-gray-700">Tingkat Pemahaman</span>
                        <span class="font-bold {{ $report->student_understanding >= 4 ? 'text-green-700' : ($report->student_understanding >= 3 ? 'text-amber-700' : 'text-red-700') }}">
                            @if($report->student_understanding >= 5)
                                Sangat Baik! 🌟
                            @elseif($report->student_understanding >= 4)
                                Baik 👍
                            @elseif($report->student_understanding >= 3)
                                Cukup 😊
                            @elseif($report->student_understanding >= 2)
                                Kurang 😟
                            @else
                                Sangat Kurang 😞
                            @endif
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4">
                        <div class="h-4 rounded-full transition-all duration-500
                            @if($report->student_understanding >= 4) bg-gradient-to-r from-green-500 to-emerald-600
                            @elseif($report->student_understanding >= 3) bg-gradient-to-r from-amber-500 to-orange-600
                            @else bg-gradient-to-r from-red-500 to-pink-600
                            @endif"
                             style="width: {{ ($report->student_understanding / 5) * 100 }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Parent Rating & Feedback -->
            @if($report->parent_rating)
                <div class="mt-8 mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Ulasan dari Orang Tua</h3>
                    </div>
                    <div class="bg-white rounded-2xl border-2 border-gray-100 p-6 space-y-4">
                        <div class="flex items-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-8 w-8 {{ $i <= $report->parent_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                            <span class="ml-3 text-2xl font-bold text-gray-900">{{ $report->parent_rating }}<span class="text-lg text-gray-500">/5</span></span>
                        </div>
                        @if($report->parent_feedback)
                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Komentar / Masukan</p>
                                <p class="text-gray-800 text-lg">"{{ $report->parent_feedback }}"</p>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="mt-8 mb-8">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-yellow-500 to-amber-600 flex items-center justify-center shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Berikan Ulasan untuk Tutor</h3>
                    </div>
                    
                    <form action="{{ route('client.reports.feedback', $report) }}" method="POST" class="bg-white rounded-2xl border-2 border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Beri Rating Bintang <span class="text-red-500">*</span></label>
                                <div x-data="{ rating: 0, hover: 0 }" class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="cursor-pointer transition-transform hover:scale-110" 
                                               @mouseenter="hover = {{ $i }}" 
                                               @mouseleave="hover = 0">
                                            <input type="radio" name="parent_rating" value="{{ $i }}" 
                                                   class="hidden" 
                                                   x-model="rating"
                                                   required>
                                            <svg class="h-10 w-10 transition-colors duration-150" 
                                                 :class="(hover || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"
                                                 fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Komentar / Masukan <span class="text-gray-400 font-normal">(opsional)</span></label>
                                <textarea name="parent_feedback" rows="3" placeholder="Tulis masukan untuk tutor..." class="w-full rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all resize-none"></textarea>
                            </div>

                            <div class="flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white font-bold py-2.5 px-6 rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-500/30">
                                    Kirim Ulasan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
