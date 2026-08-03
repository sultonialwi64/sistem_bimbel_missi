@extends('layouts.app')
@section('title', 'Edit Jadwal')
@section('page-title', 'Edit Jadwal')
@section('page-subtitle', 'Perbarui jadwal mengajar Anda')

@section('content')
<div class="max-w-3xl mx-auto" x-data="{
    showStudentModal: false,
    searchStudent: '',
    selectedStudentId: '{{ old('student_id', $schedule->student_id) }}',
    selectedStudentName: '',
    students: [
        @foreach($students as $student)
            { id: '{{ $student->id }}', name: '{{ addslashes($student->name) }}', parent: '{{ addslashes($student->client->user->name ?? '-') }}', address: '{{ addslashes($student->client->address ?? '-') }}' },
        @endforeach
    ],
    init() {
        if(this.selectedStudentId) {
            let s = this.students.find(s => s.id == this.selectedStudentId);
            if(s) this.selectedStudentName = s.name + ' — (Wali: ' + s.parent + ')';
        }
    },
    filteredStudents() {
        if(this.searchStudent === '') return this.students;
        return this.students.filter(s => 
            s.name.toLowerCase().includes(this.searchStudent.toLowerCase()) || 
            s.parent.toLowerCase().includes(this.searchStudent.toLowerCase())
        );
    }
}">
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
                            <label class="form-label">Siswa <span class="text-red-500">*</span></label>
                            <input type="hidden" name="student_id" x-model="selectedStudentId" required>
                            <div @click="showStudentModal = true" class="mt-2 cursor-pointer flex items-center gap-3 bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 hover:bg-white hover:border-amber-400 hover:shadow-sm transition-all group">
                                <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0 group-hover:bg-amber-500 transition-colors">
                                    <svg class="h-5 w-5 text-amber-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p x-show="selectedStudentName" x-text="selectedStudentName" class="text-sm font-bold text-gray-900 truncate"></p>
                                    <p x-show="!selectedStudentName" class="text-sm font-medium text-gray-500">Klik untuk memilih siswa dari daftar</p>
                                    <p x-show="selectedStudentName" class="text-xs text-green-600 font-medium mt-0.5 flex items-center gap-1">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        Siswa Terpilih
                                    </p>
                                </div>
                                <button type="button" class="px-4 py-2 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 shadow-sm group-hover:bg-amber-50 group-hover:text-amber-700 group-hover:border-amber-200 shrink-0 transition-all">
                                    <span x-text="selectedStudentName ? 'Ubah' : 'Pilih'"></span>
                                </button>
                            </div>
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
    
    {{-- Modal Student --}}
    <div x-show="showStudentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-md p-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;">
        <div @click.away="showStudentModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl max-h-[90vh] flex flex-col overflow-hidden ring-1 ring-white/10" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <div class="p-6 border-b border-indigo-50 flex justify-between items-center bg-gradient-to-r from-indigo-50/50 via-white to-white">
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-200 transform -rotate-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-800 text-xl tracking-tight">Daftar Siswa</h3>
                        <p class="text-sm text-slate-500 mt-0.5 font-medium">Pilih salah satu siswa untuk ditugaskan ke jadwal ini.</p>
                    </div>
                </div>
                <button type="button" @click="showStudentModal = false" class="h-10 w-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-rose-500 hover:border-rose-200 transition-all shadow-sm hover:shadow"><svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="p-5 bg-white border-b border-slate-100 z-20 shadow-sm relative">
                <div class="relative max-w-2xl mx-auto">
                    <input type="text" x-model="searchStudent" placeholder="Cari berdasarkan nama siswa atau nama wali..." class="w-full pl-12 pr-4 py-3.5 rounded-2xl border-0 ring-1 ring-slate-200 focus:ring-2 focus:ring-indigo-500 bg-slate-50/50 hover:bg-slate-50 text-sm transition-all shadow-inner font-medium text-slate-700 placeholder-slate-400">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </div>
            </div>
            <div class="p-0 overflow-y-auto flex-1 bg-slate-50/50 relative">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-white/90 backdrop-blur-md sticky top-0 shadow-sm z-10">
                        <tr>
                            <th class="py-4 px-6 text-xs font-black text-indigo-900 uppercase tracking-widest border-b border-slate-200 bg-indigo-50/30">Siswa</th>
                            <th class="py-4 px-6 text-xs font-black text-indigo-900 uppercase tracking-widest border-b border-slate-200 bg-indigo-50/30">Wali</th>
                            <th class="py-4 px-6 text-xs font-black text-indigo-900 uppercase tracking-widest border-b border-slate-200 bg-indigo-50/30">Alamat</th>
                            <th class="py-4 px-6 text-xs font-black text-indigo-900 uppercase tracking-widest text-right border-b border-slate-200 bg-indigo-50/30">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <template x-for="s in filteredStudents()" :key="s.id">
                            <tr class="hover:bg-indigo-50/80 transition-all duration-200 group cursor-pointer" @click="selectedStudentId = s.id; selectedStudentName = s.name + ' — (Wali: ' + s.parent + ')'; showStudentModal = false">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="h-11 w-11 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center shrink-0 border border-white shadow-sm group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                                            <span class="text-indigo-700 font-black text-sm" x-text="s.name.substring(0, 2).toUpperCase()"></span>
                                        </div>
                                        <p class="font-bold text-slate-900 text-sm group-hover:text-indigo-700 transition-colors" x-text="s.name"></p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-2.5">
                                        <div class="h-8 w-8 rounded-full bg-slate-50 flex items-center justify-center border border-slate-200 shrink-0 group-hover:border-indigo-200 group-hover:bg-indigo-50 transition-colors">
                                            <svg class="h-4 w-4 text-slate-400 group-hover:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-700 group-hover:text-slate-900" x-text="s.parent"></p>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-sm text-slate-600">
                                    <div class="flex items-start gap-2">
                                        <svg class="h-4 w-4 text-slate-400 shrink-0 mt-0.5 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="s.address" class="line-clamp-2 leading-relaxed"></span>
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <button type="button" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 group-hover:bg-gradient-to-r group-hover:from-indigo-600 group-hover:to-purple-600 group-hover:text-white group-hover:border-transparent rounded-xl text-xs font-bold transition-all duration-300 shadow-sm group-hover:shadow-md transform group-hover:-translate-y-0.5 flex items-center gap-2 ml-auto">
                                        Pilih Siswa
                                        <svg class="h-3.5 w-3.5 opacity-0 group-hover:opacity-100 transition-opacity -ml-4 group-hover:ml-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredStudents().length === 0">
                            <td colspan="4" class="py-20 text-center bg-slate-50/50">
                                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-white shadow-sm border border-slate-100 mb-5 relative">
                                    <div class="absolute inset-0 rounded-full bg-indigo-50 animate-ping opacity-20"></div>
                                    <svg class="h-10 w-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <h4 class="text-slate-800 font-black text-lg">Tidak Ada Siswa Ditemukan</h4>
                                <p class="text-slate-500 text-sm mt-1 max-w-sm mx-auto">Maaf, kami tidak dapat menemukan siswa atau wali dengan kata kunci tersebut. Silakan coba kata kunci lain.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div></div>
</div>
@endsection
