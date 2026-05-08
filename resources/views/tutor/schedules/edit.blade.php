@extends('layouts.app')
@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal')
@section('page-subtitle', 'Perbarui jadwal mengajar Anda')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card-premium overflow-hidden">

        {{-- Header --}}
        <div class="bg-amber-600 px-6 py-4">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Detail Edit Jadwal
            </h3>
            <p class="text-amber-100 text-sm mt-0.5">Ubah informasi jadwal yang sudah direncanakan.</p>
        </div>

        <form action="{{ route('tutor.schedules.update', $schedule) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                        <p class="text-sm font-bold text-red-700 mb-1">Terdapat kesalahan:</p>
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
                        Pilih Murid
                    </p>
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="form-label" for="student_id">Siswa <span class="text-red-500">*</span></label>
                            <select name="student_id" id="student_id" required class="input-premium mt-1">
                                <option value="">-- Pilih Siswa --</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ old('student_id', $schedule->student_id) == $student->id ? 'selected' : '' }}>
                                        {{ $student->name }} — (Wali: {{ $student->client->user->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

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
                                <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} — {{ $subject->level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

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
                            <input type="date" name="date" id="date" required value="{{ old('date', $schedule->date->format('Y-m-d')) }}" class="input-premium mt-1">
                        </div>
                        <div>
                            <label class="form-label" for="start_time">Jam Mulai <span class="text-red-500">*</span></label>
                            <input type="time" name="start_time" id="start_time" required value="{{ old('start_time', \Carbon\Carbon::parse($schedule->start_time)->format('H:i')) }}" class="input-premium mt-1">
                        </div>
                        <div>
                            <label class="form-label" for="end_time">Jam Selesai <span class="text-red-500">*</span></label>
                            <input type="time" name="end_time" id="end_time" required value="{{ old('end_time', \Carbon\Carbon::parse($schedule->end_time)->format('H:i')) }}" class="input-premium mt-1">
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer Actions --}}
            <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50 border-t border-gray-100 rounded-b-2xl">
                <a href="{{ route('tutor.schedules.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold text-sm hover:bg-gray-50 transition-all shadow-sm">
                    Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-600 text-white rounded-xl font-bold text-sm hover:bg-amber-700 shadow-sm hover:shadow-md transition-all">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>
@endsection
