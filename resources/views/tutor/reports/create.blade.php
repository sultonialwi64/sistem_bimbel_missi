@extends('layouts.app')

@section('title', 'Buat Laporan Sesi')
@section('page-title', 'Buat Laporan Sesi')

@section('content')
@php
    $startFormatted = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
    $endFormatted   = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
    $dateFormatted  = $schedule->date->translatedFormat('l, d F Y');
    $understandingLabels = [1 => 'Sangat Kurang', 2 => 'Kurang', 3 => 'Cukup', 4 => 'Baik', 5 => 'Sangat Baik'];
    $understandingColors = [1 => 'red', 2 => 'orange', 3 => 'yellow', 4 => 'blue', 5 => 'green'];
@endphp

<div class="max-w-5xl mx-auto space-y-6">

    {{-- ===== HEADER ===== --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-700 rounded-2xl shadow-xl p-6 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 400 100" preserveAspectRatio="none">
                <circle cx="350" cy="50" r="80" fill="white"/>
                <circle cx="50" cy="80" r="50" fill="white"/>
            </svg>
        </div>
        <div class="relative z-10 flex items-center gap-4">
            <div class="h-12 w-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-white">Laporan Sesi Mengajar</h2>
                <p class="text-indigo-200 text-sm mt-0.5">Dokumentasikan perkembangan siswa setelah sesi selesai</p>
            </div>
        </div>
    </div>

    {{-- ===== INFO SESI ===== --}}
    <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Informasi Sesi</p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            {{-- Siswa --}}
            <div class="flex items-center gap-3 bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                <div class="h-10 w-10 rounded-full bg-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-sm flex-shrink-0">
                    {{ substr($schedule->student->name, 0, 2) }}
                </div>
                <div>
                    <p class="text-xs text-indigo-500 font-semibold uppercase tracking-wide">Siswa</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $schedule->student->name }}</p>
                    <p class="text-xs text-gray-500">{{ $schedule->student->grade_level }}</p>
                </div>
            </div>
            {{-- Mapel --}}
            <div class="flex items-center gap-3 bg-purple-50 rounded-xl p-4 border border-purple-100">
                <div class="h-10 w-10 rounded-full bg-purple-200 flex items-center justify-center flex-shrink-0">
                    <svg class="h-5 w-5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-purple-500 font-semibold uppercase tracking-wide">Mata Pelajaran</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $schedule->subject->name }}</p>
                    <p class="text-xs text-gray-500">{{ $schedule->subject->level }}</p>
                </div>
            </div>
            {{-- Waktu --}}
            <div class="flex items-center gap-3 bg-amber-50 rounded-xl p-4 border border-amber-100">
                <div class="h-10 w-10 rounded-full bg-amber-200 flex items-center justify-center flex-shrink-0">
                    <svg class="h-5 w-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-amber-600 font-semibold uppercase tracking-wide">Jadwal</p>
                    <p class="font-bold text-gray-900 text-sm">{{ $dateFormatted }}</p>
                    <p class="text-xs text-gray-500">{{ $startFormatted }} – {{ $endFormatted }} WIB</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== FORM ===== --}}
    <form action="{{ route('tutor.reports.store') }}" method="POST">
        @csrf
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- === KOLOM KIRI === --}}
            <div class="space-y-6">

                {{-- Materi --}}
                <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
                    <label for="material_covered" class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-1">
                        <svg class="h-4 w-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Materi yang Diajarkan
                        <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-3">Tuliskan materi, topik, atau bab yang dibahas pada sesi ini.</p>
                    <textarea id="material_covered" name="material_covered" rows="6" required
                              placeholder="Contoh: Pembahasan Bab 3 tentang Persamaan Linear Satu Variabel, latihan soal hal. 45-50..."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 transition-all resize-none p-4 text-sm text-gray-700 outline-none @error('material_covered') border-red-400 @enderror">{{ old('material_covered') }}</textarea>
                    @error('material_covered')
                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Catatan untuk Ortu --}}
                <div class="bg-white rounded-2xl shadow border border-gray-100 p-6">
                    <label for="notes_for_parent" class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-1">
                        <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        Catatan untuk Orang Tua
                        <span class="text-xs text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-3">Pesan khusus, PR, atau hal penting yang perlu diketahui orang tua.</p>
                    <textarea id="notes_for_parent" name="notes_for_parent" rows="5"
                              placeholder="Contoh: Siswa perlu mengulang perkalian dasar di rumah, PR halaman 52 nomor 1-10..."
                              class="w-full rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-amber-400 focus:ring-2 focus:ring-amber-100 transition-all resize-none p-4 text-sm text-gray-700 outline-none">{{ old('notes_for_parent') }}</textarea>
                </div>

            </div>

            {{-- === KOLOM KANAN === --}}
            <div class="space-y-6">

                {{-- Pemahaman Siswa --}}
                <div x-data="{ understanding: {{ old('student_understanding', 0) }} }" class="bg-white rounded-2xl shadow border border-gray-100 p-6">
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-1">
                        <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Tingkat Pemahaman Siswa
                        <span class="text-red-500">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-4">Seberapa baik siswa memahami materi yang diajarkan hari ini?</p>

                    <div class="grid grid-cols-5 gap-2">
                        @php
                            $uColors = [1=>'red',2=>'orange',3=>'yellow',4=>'blue',5=>'green'];
                            $uLabels = [1=>'Sangat Kurang',2=>'Kurang',3=>'Cukup',4=>'Baik',5=>'Sangat Baik'];
                            $uGradients = [
                                1=>'from-red-400 to-red-600',
                                2=>'from-orange-400 to-orange-600',
                                3=>'from-yellow-400 to-amber-500',
                                4=>'from-blue-400 to-blue-600',
                                5=>'from-green-400 to-emerald-600'
                            ];
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="student_understanding" value="{{ $i }}"
                                       x-model="understanding"
                                       {{ old('student_understanding') == $i ? 'checked' : '' }} required
                                       class="sr-only">
                                <div :class="understanding == {{ $i }} ? 'bg-gradient-to-b {{ $uGradients[$i] }} border-transparent shadow-md scale-105 text-white' : 'border-gray-200 text-gray-400 hover:border-gray-300'"
                                     class="rounded-xl border-2 py-3 text-center transition-all duration-200">
                                    <div class="text-xl font-black">{{ $i }}</div>
                                </div>
                                <p class="text-center text-[10px] mt-1.5 font-semibold leading-tight
                                    @if($i==1) text-red-500
                                    @elseif($i==2) text-orange-500
                                    @elseif($i==3) text-amber-500
                                    @elseif($i==4) text-blue-500
                                    @else text-green-500 @endif">
                                    {{ $uLabels[$i] }}
                                </p>
                            </label>
                        @endfor
                    </div>

                    {{-- Deskripsi pilihan aktif --}}
                    <div class="mt-4 min-h-[36px]">
                        <template x-if="understanding > 0">
                            <div class="flex items-center gap-2 text-sm rounded-lg px-3 py-2"
                                 :class="{
                                     'bg-red-50 text-red-700': understanding == 1,
                                     'bg-orange-50 text-orange-700': understanding == 2,
                                     'bg-amber-50 text-amber-700': understanding == 3,
                                     'bg-blue-50 text-blue-700': understanding == 4,
                                     'bg-green-50 text-green-700': understanding == 5
                                 }">
                                <svg class="h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                <span x-text="{
                                    1: 'Siswa belum memahami materi, perlu pengulangan intensif.',
                                    2: 'Siswa sedikit mengerti, perlu lebih banyak latihan.',
                                    3: 'Pemahaman cukup, sudah bisa mengerjakan soal dasar.',
                                    4: 'Pemahaman baik, bisa mengerjakan soal dengan mandiri.',
                                    5: 'Siswa sangat paham dan mampu menjelaskan kembali materi.'
                                }[understanding]"></span>
                            </div>
                        </template>
                    </div>

                    @error('student_understanding')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Rating dari Siswa --}}
                <div x-data="{ rating: {{ old('tutor_rating_by_student', 0) }} }" class="bg-white rounded-2xl shadow border border-gray-100 p-6">
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-800 mb-1">
                        <svg class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Rating dari Tutor untuk Anak pada sesi ini
                        <span class="text-xs text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-4">Berapa rating bintang secara keseluruhan untuk anak pada sesi ini?</p>

                    <div class="flex gap-3 justify-center">
                        @for($i = 1; $i <= 5; $i++)
                            <label class="cursor-pointer">
                                <input type="radio" name="tutor_rating_by_student" value="{{ $i }}"
                                       x-model="rating"
                                       {{ old('tutor_rating_by_student') == $i ? 'checked' : '' }}
                                       class="sr-only">
                                <div :class="rating >= {{ $i }} ? 'border-yellow-400 bg-gradient-to-br from-yellow-400 to-orange-500 shadow-md scale-110' : 'border-gray-200 bg-white hover:border-yellow-200'"
                                     class="h-14 w-14 rounded-xl border-2 flex items-center justify-center transition-all duration-200">
                                    <svg :class="rating >= {{ $i }} ? 'text-white' : 'text-gray-300'"
                                         class="h-7 w-7 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            </label>
                        @endfor
                    </div>

                    {{-- Label rating aktif --}}
                    <div class="mt-3 text-center min-h-[20px]">
                        <template x-if="rating > 0">
                            <p class="text-sm font-semibold text-amber-600" x-text="{
                                1: '⭐ Perlu Perbaikan',
                                2: '⭐⭐ Cukup',
                                3: '⭐⭐⭐ Baik',
                                4: '⭐⭐⭐⭐ Sangat Baik',
                                5: '⭐⭐⭐⭐⭐ Luar Biasa!'
                            }[rating]"></p>
                        </template>
                        <template x-if="rating == 0">
                            <p class="text-xs text-gray-400">Pilih bintang di atas</p>
                        </template>
                    </div>
                </div>

            </div>
        </div>

        {{-- ===== TOMBOL AKSI ===== --}}
        <div class="flex items-center justify-between mt-6 bg-white rounded-2xl shadow border border-gray-100 p-4">
            <a href="{{ route('tutor.schedules.show', $schedule) }}"
               class="flex items-center gap-2 text-gray-500 hover:text-gray-700 font-semibold text-sm transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
            <button type="submit"
                    class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-700 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-indigo-500/30 hover:scale-105 transition-all duration-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Kirim Laporan
            </button>
        </div>
    </form>
</div>
@endsection
