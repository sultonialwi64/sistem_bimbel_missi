@extends('layouts.app')

@section('title', 'My Schedules')
@section('page-title', 'My Schedules')
@section('page-subtitle', 'View and manage your teaching schedules')

@php
    $calendarEvents = $allSchedules->map(function($s) {
        if ($s->status === 'completed') {
            $bgColor = '#10b981'; // Green
            $borderColor = '#059669';
            $textColor = '#ffffff';
        } else if ($s->status === 'scheduled') {
            $bgColor = '#ffffff'; // White
            $borderColor = '#e2e8f0'; // Gray
            $textColor = '#1e293b'; // Dark
        } else if ($s->status === 'cancelled') {
            $bgColor = '#ef4444';
            $borderColor = '#dc2626';
            $textColor = '#ffffff';
        } else if ($s->status === 'rescheduled') {
            $bgColor = '#f59e0b';
            $borderColor = '#d97706';
            $textColor = '#ffffff';
        } else {
            $bgColor = '#f1f5f9';
            $borderColor = '#cbd5e1';
            $textColor = '#475569';
        }

        $classNames = [];
        if ($s->status === 'completed' && $s->sessionReport === null) {
            $classNames[] = 'needs-report-pulse';
        }

        return [
            'id' => $s->id,
            'title' => $s->student->name,
            'start' => $s->date->format('Y-m-d') . 'T' . $s->start_time->format('H:i:s'),
            'end' => $s->date->format('Y-m-d') . 'T' . $s->end_time->format('H:i:s'),
            'url' => route('tutor.schedules.show', $s->id),
            'backgroundColor' => $bgColor,
            'borderColor' => $borderColor,
            'textColor' => $textColor,
            'display' => 'block',
            'extendedProps' => [
                'student_name' => $s->student->name,
                'subject' => $s->subject->name,
                'status' => $s->status,
                'textColor' => $textColor,
                'has_report' => $s->sessionReport !== null,
            ],
            'classNames' => $classNames,
        ];
    })->values()->toArray();
@endphp

@section('content')
<div class="space-y-8" x-data="{ 
    viewMode: 'calendar',
    showMissingModal: false,
    missingData: { missingAttendances: [], missingReports: [] },
    isFetchingMissing: false,
    activeMissingTab: 'attendance',
    fetchMissingRecords() {
        this.showMissingModal = true;
        this.isFetchingMissing = true;
        let month = '';
        if (window.fullCalendarInstance) {
            let date = window.fullCalendarInstance.getDate();
            let m = date.getMonth() + 1;
            let y = date.getFullYear();
            month = '?month=' + y + '-' + (m < 10 ? '0' + m : m);
        }
        fetch('{{ route('tutor.schedules.missing-records') }}' + month)
            .then(res => res.json())
            .then(data => {
                this.missingData = data;
                this.isFetchingMissing = false;
            })
            .catch(err => {
                this.isFetchingMissing = false;
                alert('Gagal memuat data tunggakan.');
            });
    }
}">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <p class="text-gray-500 text-sm">Kelola jadwal mengajar Anda</p>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            {{-- View Mode Toggle --}}
            <div class="bg-gray-100 p-1 rounded-xl flex items-center shadow-inner">
                <button @click="viewMode = 'calendar'"
                        :class="viewMode === 'calendar' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                        class="px-3 py-2 rounded-lg text-sm font-bold flex items-center gap-1.5 transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="hidden sm:inline text-xs">Kalender</span>
                </button>
                <button @click="viewMode = 'list'"
                        :class="viewMode === 'list' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                        class="px-3 py-2 rounded-lg text-sm font-bold flex items-center gap-1.5 transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span class="hidden sm:inline text-xs">Daftar</span>
                </button>
            </div>

            {{-- Cek Tunggakan Button --}}
            <button @click="fetchMissingRecords()" class="px-3 py-2 bg-red-50 rounded-xl text-sm font-bold text-red-600 hover:bg-red-100 hover:text-red-700 border border-red-200 shadow-sm flex items-center gap-2 transition-all duration-200">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span class="hidden sm:inline">Cek Tunggakan</span>
            </button>

            <a href="{{ route('tutor.schedules.create') }}" class="btn-primary-gradient text-white font-bold px-4 py-2.5 rounded-xl hover:shadow-2xl flex items-center gap-2 shadow-xl shadow-indigo-500/30 transition-all flex-1 sm:flex-auto justify-center">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="text-sm">Jadwal Baru</span>
            </a>
        </div>
    </div>

    {{-- Calendar View --}}
    <div x-show="viewMode === 'calendar'" class="card-premium overflow-hidden bg-white p-6 shadow-2xl rounded-3xl border border-gray-100">
        <div id="calendar" class="w-full"></div>
    </div>

    {{-- List View --}}
    <div x-show="viewMode === 'list'" class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Daftar Jadwal Mengajar
                </h3>
                <span class="text-blue-100 text-sm font-semibold">{{ $schedules->total() }} jadwal</span>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead class="bg-indigo-900">
                    <tr>
                        <th class="text-left py-4 px-6 text-white font-bold opacity-90">Date &amp; Time</th>
                        <th class="text-left py-4 px-6 text-white font-bold opacity-90">Student</th>
                        <th class="text-left py-4 px-6 text-white font-bold opacity-90">Subject</th>
                        <th class="text-left py-4 px-6 text-white font-bold opacity-90">Status</th>
                        <th class="text-right py-4 px-6 text-white font-bold opacity-90">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <p class="font-bold text-gray-900">{{ $schedule->date->translatedFormat('l, d M Y') }}</p>
                                <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB</p>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-xs">{{ substr($schedule->student->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $schedule->student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $schedule->student->grade_level }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-900">{{ $schedule->subject->name }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold
                                    @if($schedule->status === 'completed') bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200
                                    @elseif($schedule->status === 'scheduled') bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200
                                    @elseif($schedule->status === 'cancelled') bg-gradient-to-r from-red-50 to-pink-50 text-red-700 border border-red-200
                                    @else bg-gradient-to-r from-amber-50 to-orange-50 text-amber-700 border border-amber-200
                                    @endif">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('tutor.schedules.show', $schedule) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-semibold text-xs hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>
                                    @if($schedule->status === 'scheduled')
                                        <a href="{{ route('tutor.schedules.edit', $schedule) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 text-amber-700 border border-amber-100 rounded-xl font-semibold text-xs hover:bg-amber-50 transition-all">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('tutor.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 text-red-700 border border-red-100 rounded-xl font-semibold text-xs hover:bg-red-50 transition-all">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">Tidak ada jadwal ditemukan</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($schedules as $schedule)
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-md flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ substr($schedule->student->name, 0, 2) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-gray-900 text-sm">{{ $schedule->student->name }}</p>
                                <p class="text-xs text-gray-500">{{ $schedule->subject->name }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold flex-shrink-0
                            @if($schedule->status === 'completed') bg-green-100 text-green-700
                            @elseif($schedule->status === 'scheduled') bg-blue-100 text-blue-700
                            @elseif($schedule->status === 'cancelled') bg-red-100 text-red-700
                            @else bg-amber-100 text-amber-700
                            @endif">
                            {{ ucfirst($schedule->status) }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 mb-3 text-xs text-gray-600">
                        <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="font-semibold text-gray-800">{{ $schedule->date->format('d M Y') }}</span>
                        <span class="text-gray-400">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                        <a href="{{ route('tutor.schedules.show', $schedule) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Detail
                        </a>
                        @if($schedule->status === 'scheduled')
                            <a href="{{ route('tutor.schedules.edit', $schedule) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-amber-50 text-amber-700 rounded-xl font-semibold text-xs hover:bg-amber-100 transition-all">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <div x-data="{ showDeleteModal: false }" class="inline flex-1">
                                <button type="button" @click="showDeleteModal = true" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-red-50 text-red-700 rounded-xl font-semibold text-xs hover:bg-red-100 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                                
                                <!-- Delete Confirmation Modal -->
                                <div x-show="showDeleteModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div x-show="showDeleteModal" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                                    <div class="fixed inset-0 z-10 overflow-y-auto">
                                        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                            <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition.scale class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                                                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                                    <div class="sm:flex sm:items-start">
                                                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                                                        </div>
                                                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                                            <h3 class="text-lg font-bold leading-6 text-gray-900">Hapus Jadwal</h3>
                                                            <div class="mt-2 text-wrap">
                                                                <p class="text-sm text-gray-500 whitespace-normal">Yakin ingin menghapus jadwal ini? Data ini tidak dapat dikembalikan.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                                    <form action="{{ route('tutor.schedules.destroy', $schedule) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-4 py-2 text-sm font-bold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">Hapus Permanen</button>
                                                    </form>
                                                    <button type="button" @click="showDeleteModal = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">Batal</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">Tidak ada jadwal ditemukan</p>
                </div>
            @endforelse
        </div>

        @if($schedules->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>

    {{-- Missing Records Modal --}}
    <div x-show="showMissingModal" 
         class="fixed inset-0 z-50 overflow-y-auto" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true"
         style="display: none;">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showMissingModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0" 
                 x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100" 
                 x-transition:leave-end="opacity-0" 
                 class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" 
                 @click="showMissingModal = false"
                 aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showMissingModal" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                
                <div class="bg-red-600 px-4 py-4 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-bold text-white flex items-center gap-2" id="modal-title">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        Daftar Tunggakan Anda
                    </h3>
                    <button @click="showMissingModal = false" class="text-red-100 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <div class="px-4 pt-5 pb-4 sm:p-6">
                    <div class="flex border-b border-gray-200 mb-4">
                        <button @click="activeMissingTab = 'attendance'" :class="activeMissingTab === 'attendance' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors">
                            Tunggakan Absen
                            <span x-show="!isFetchingMissing" x-text="missingData.missingAttendances.length" class="ml-2 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs"></span>
                        </button>
                        <button @click="activeMissingTab = 'report'" :class="activeMissingTab === 'report' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-2 px-4 border-b-2 font-medium text-sm transition-colors">
                            Tunggakan Laporan
                            <span x-show="!isFetchingMissing" x-text="missingData.missingReports.length" class="ml-2 bg-red-100 text-red-600 py-0.5 px-2 rounded-full text-xs"></span>
                        </button>
                    </div>

                    <div x-show="isFetchingMissing" class="py-10 text-center">
                        <i class="fa-solid fa-spinner fa-spin text-3xl text-red-500"></i>
                        <p class="mt-2 text-gray-500">Memuat data...</p>
                    </div>

                    <div x-show="!isFetchingMissing" class="overflow-y-auto max-h-96 pr-2 custom-scrollbar">
                        {{-- Attendance Tab --}}
                        <div x-show="activeMissingTab === 'attendance'">
                            <template x-if="missingData.missingAttendances.length === 0">
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-check-circle text-4xl text-green-400 mb-2"></i>
                                    <p>Hore! Anda tidak ada tunggakan absen.</p>
                                </div>
                            </template>
                            <template x-for="item in missingData.missingAttendances" :key="item.id">
                                <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-3 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 hover:shadow-md transition-shadow">
                                    <div>
                                        <div class="font-bold text-gray-800" x-text="item.student_name"></div>
                                        <div class="text-sm text-red-600 font-medium" x-text="item.date_formatted + ' | ' + item.time_formatted"></div>
                                    </div>
                                    <a :href="item.url" class="btn-primary-gradient px-3 py-1.5 text-xs text-white rounded-lg whitespace-nowrap">Isi Absen</a>
                                </div>
                            </template>
                        </div>

                        {{-- Report Tab --}}
                        <div x-show="activeMissingTab === 'report'">
                            <template x-if="missingData.missingReports.length === 0">
                                <div class="text-center py-8 text-gray-500">
                                    <i class="fa-solid fa-check-circle text-4xl text-green-400 mb-2"></i>
                                    <p>Hore! Anda tidak ada tunggakan laporan.</p>
                                </div>
                            </template>
                            <template x-for="item in missingData.missingReports" :key="item.id">
                                <div class="bg-orange-50 border border-orange-100 rounded-xl p-3 mb-3 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 hover:shadow-md transition-shadow">
                                    <div>
                                        <div class="font-bold text-gray-800" x-text="item.student_name"></div>
                                        <div class="text-sm text-orange-600 font-medium" x-text="item.date_formatted + ' | ' + item.time_formatted"></div>
                                    </div>
                                    <a :href="item.url" class="btn-primary-gradient px-3 py-1.5 text-xs text-white rounded-lg whitespace-nowrap">Isi Laporan</a>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .fc {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .fc-theme-standard .fc-scrollgrid {
        border: 1px solid #e1e7ef;
        border-radius: 1rem;
        overflow: hidden;
    }
    .fc-theme-standard th {
        border-color: #e1e7ef;
        padding: 12px 0;
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.05em;
    }
    .fc-theme-standard td {
        border-color: #e1e7ef;
    }
    .fc .fc-button-primary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.4rem 0.85rem;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        transition: all 0.2s ease;
    }
    .fc .fc-button-primary:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
        box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        transform: translateY(-1px);
    }
    .fc .fc-button-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .fc .fc-button-active {
        background: #312e81 !important;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2) !important;
    }
    .fc-toolbar-title {
        font-weight: 800 !important;
        font-size: 1.25rem !important;
        color: #1e293b;
    }
    .fc-event {
        border-radius: 0.5rem;
        border: none !important;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        margin-bottom: 0.25rem;
        cursor: pointer;
    }
    .fc-event:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 50 !important;
    }
    @keyframes pulse-glow {
        0% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0.7); }
        70% { box-shadow: 0 0 0 5px rgba(234, 179, 8, 0); }
        100% { box-shadow: 0 0 0 0 rgba(234, 179, 8, 0); }
    }
    .needs-report-pulse {
        border: 2px solid #fbbf24 !important;
        animation: pulse-glow 2s infinite ease-in-out;
    }
    .fc-daygrid-day-number {
        font-weight: 600;
        color: #64748b;
        padding: 0.5rem !important;
    }
    .fc-popover-body {
        max-height: 250px;
        overflow-y: auto;
    }
    .fc-day-today {
        background: #f8fafc !important;
    }
    .fc-day-today .fc-daygrid-day-number {
        color: #4f46e5;
        font-weight: 800;
        background: #e0e7ff;
        border-radius: 9999px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 4px;
    }
    /* Mobile responsive calendar toolbar */
    @media (max-width: 639px) {
        .fc-toolbar {
            flex-wrap: wrap;
            gap: 8px;
        }
        .fc-toolbar-title {
            font-size: 1rem !important;
        }
        .fc-toolbar-chunk {
            display: flex;
            gap: 4px;
            align-items: center;
        }
        .fc .fc-button-primary {
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
        }
        .fc-header-toolbar {
            margin-bottom: 0.75rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        if (!calendarEl) return;

        var eventsData = @json($calendarEvents);
        var isMobile = window.innerWidth < 640;
        var lastWidth = window.innerWidth;

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: isMobile ? 'listWeek' : 'dayGridMonth',
            headerToolbar: isMobile ? {
                left: 'prev,next',
                center: 'title',
                right: 'today,dayGridMonth,listWeek'
            } : {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'standard',
            events: eventsData,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            },
            displayEventEnd: true,
            height: 'auto',
            dayMaxEvents: isMobile ? 3 : 4,
            windowResize: function(view) {
                if (window.innerWidth === lastWidth) return;
                lastWidth = window.innerWidth;

                var newMobile = window.innerWidth < 640;
                if (newMobile) {
                    calendar.changeView('listWeek');
                    calendar.setOption('headerToolbar', {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today,dayGridMonth,listWeek'
                    });
                } else {
                    calendar.changeView('dayGridMonth');
                    calendar.setOption('headerToolbar', {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    });
                }
            },
            eventContent: function(arg) {
                var p = arg.event.extendedProps;
                var reportIcon = p.has_report ? '<span style="background:rgba(0,0,0,0.2);padding:2px 4px;border-radius:4px;margin-left:4px;font-size:9px;display:inline-flex;align-items:center;color:#ffffff;"><svg style="width:10px;height:10px;margin-right:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span class="hidden sm:inline">Laporan</span></span>' : '';
                return {
                    html: '<div style="padding:3px 6px;line-height:1.3;overflow:hidden;color:'+p.textColor+';">' +
                          '<div style="font-size:10px;font-weight:700;opacity:0.9;">' + arg.timeText + reportIcon + '</div>' +
                          '<div style="font-size:12px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + p.student_name + '</div>' +
                          '<div style="font-size:10px;opacity:0.85;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + p.subject + '</div>' +
                          '</div>'
                };
            }
        });

        calendar.render();
        window.fullCalendarInstance = calendar;
    });
</script>
@endpush
