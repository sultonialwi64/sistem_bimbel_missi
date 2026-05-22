@extends('layouts.app')
@section('title', 'Buat Jadwal Baru')
@section('page-title', 'Buat Jadwal Baru')
@section('page-subtitle', 'Tambahkan sesi les baru untuk siswa')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-premium overflow-hidden">

        {{-- Header --}}
        <div class="bg-indigo-800 px-6 py-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Detail Jadwal Les
            </h3>
            <p class="text-indigo-300 text-sm mt-0.5">Isi semua informasi di bawah ini dengan lengkap</p>
        </div>

        <form action="{{ route('admin.schedules.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-6">

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <p class="text-sm font-bold text-red-700 mb-1">Terdapat kesalahan input:</p>
                        <ul class="list-disc list-inside text-sm text-red-600 space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Section: Peserta --}}
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Peserta
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label" for="student_id">Siswa <span class="text-red-500">*</span></label>
                            <select name="student_id" id="student_id" required class="input-premium mt-1">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} — (Wali: {{ $student->client->user->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label" for="tutor_id">Tutor <span class="text-red-500">*</span></label>
                            <select name="tutor_id" id="tutor_id" required class="input-premium mt-1">
                                <option value="">-- Pilih Tutor --</option>
                                @foreach($tutors as $tutor)
                                    <option value="{{ $tutor->id }}" {{ old('tutor_id') == $tutor->id ? 'selected' : '' }}>
                                        {{ $tutor->user->name }}
                                        @if(!empty($tutor->specialization))
                                            ({{ implode(', ', $tutor->specialization) }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="border-gray-100">

                {{-- Section: Mata Pelajaran --}}
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        Mata Pelajaran
                    </p>
                    <div>
                        <label class="form-label" for="subject_id">Pelajaran <span class="text-red-500">*</span></label>
                        <select name="subject_id" id="subject_id" required class="input-premium mt-1">
                            <option value="">-- Pilih Mata Pelajaran --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} — {{ $subject->level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="border-gray-100">

                {{-- Section: Waktu --}}
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Waktu Pelaksanaan
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="form-label" for="date">Tanggal <span class="text-red-500">*</span></label>
                            <input type="date" name="date" id="date" required value="{{ old('date') }}" class="input-premium mt-1">
                        </div>
                        <div>
                            <label class="form-label" for="start_time">Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" id="start_time" required value="{{ old('start_time') }}" class="input-premium mt-1">
                        </div>
                        <div>
                            <label class="form-label" for="end_time">Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" id="end_time" required value="{{ old('end_time') }}" class="input-premium mt-1">
                        </div>
                    </div>

                    <div class="mt-5 pt-5 border-t border-gray-100">
                        <label class="form-label" for="repeat_weeks">Ulangi Jadwal <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <select name="repeat_weeks" id="repeat_weeks" class="input-premium mt-1">
                            <option value="0" {{ old('repeat_weeks') == '0' ? 'selected' : '' }}>Hanya Sekali (Tidak Diulang)</option>
                            <option value="1" {{ old('repeat_weeks') == '1' ? 'selected' : '' }}>Ulangi +1 Minggu (Total 2 Sesi)</option>
                            <option value="2" {{ old('repeat_weeks') == '2' ? 'selected' : '' }}>Ulangi +2 Minggu (Total 3 Sesi)</option>
                            <option value="3" {{ old('repeat_weeks') == '3' ? 'selected' : '' }}>Ulangi +3 Minggu (Total 4 Sesi - Paket 1 Bulan)</option>
                            <option value="4" {{ old('repeat_weeks') == '4' ? 'selected' : '' }}>Ulangi +4 Minggu (Total 5 Sesi)</option>
                            <option value="7" {{ old('repeat_weeks') == '7' ? 'selected' : '' }}>Ulangi +7 Minggu (Total 8 Sesi - Paket 2 Bulan)</option>
                            <option value="11" {{ old('repeat_weeks') == '11' ? 'selected' : '' }}>Ulangi +11 Minggu (Total 12 Sesi - Paket 3 Bulan)</option>
                        </select>
                        <p class="text-xs text-gray-400 mt-1.5 flex items-start gap-1.5">
                            <svg class="h-4 w-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Sistem akan otomatis membuat jadwal untuk hari dan jam yang sama pada minggu-minggu berikutnya sesuai pilihan Anda.</span>
                        </p>
                    </div>
                </div>

                {{-- Divider --}}
                <hr class="border-gray-100">

                {{-- Section: Catatan --}}
                <div>
                    <label class="form-label" for="notes">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Tambahkan catatan khusus untuk jadwal ini..." class="input-premium mt-1">{{ old('notes') }}</textarea>
                </div>

            </div>

            {{-- Footer Actions --}}
            <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl">
                <a href="{{ route('admin.schedules.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all shadow-sm">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-sm hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Jadwal
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
