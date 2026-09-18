@extends('layouts.app')
@section('title', 'Schedule Detail')
@section('page-title', 'Schedule Detail')
@section('content')
<div class="max-w-4xl mx-auto">
    <a href="{{ route('admin.schedules.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">← Back to Schedules</a>
    
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="text-sm text-gray-500">Student</label>
                <p class="text-lg font-semibold">{{ $schedule->student->name }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->student->client->user->name }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Tutor</label>
                <p class="text-lg font-semibold">{{ $schedule->tutor->user->name }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->tutor->user->phone ?? '-' }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Subject</label>
                <p class="text-lg font-semibold">{{ $schedule->subject->name }}</p>
                <p class="text-sm text-gray-500">{{ $schedule->subject->gradeLevel->name ?? $schedule->subject->level }}</p>
            </div>
            <div>
                <label class="text-sm text-gray-500">Date & Time</label>
                <p class="text-lg font-bold text-indigo-700">{{ $schedule->date->translatedFormat('l, d M Y') }}</p>
                <p class="text-sm font-medium text-gray-600 bg-gray-100 px-3 py-1 rounded-lg inline-block mt-1">
                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }} WIB
                </p>
            </div>
            <div class="col-span-2">
                <label class="text-sm text-gray-500">Status</label>
                <div class="mt-1">
                    <span class="px-3 py-1 rounded-full text-sm font-bold
                        @if($schedule->status === 'completed') bg-green-100 text-green-800
                        @elseif($schedule->status === 'scheduled') bg-blue-100 text-blue-800
                        @elseif($schedule->status === 'cancelled') bg-red-100 text-red-800
                        @else bg-yellow-100 text-yellow-800 @endif">
                        {{ ucfirst($schedule->status) }}
                    </span>
                </div>
            </div>
            @if($schedule->notes)
                <div class="col-span-2">
                    <label class="text-sm text-gray-500">Notes</label>
                    <p class="mt-1 italic text-gray-600">"{{ $schedule->notes }}"</p>
                </div>
            @endif
        </div>
        
        <div class="mt-8 flex justify-end gap-3 border-t pt-6" x-data="{ showDeleteModal: false }">
            <a href="{{ route('admin.schedules.edit', $schedule) }}" class="px-6 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">Edit Schedule</a>
            <button type="button" @click="showDeleteModal = true" class="px-6 py-2 bg-red-50 text-red-700 border border-red-200 rounded-xl font-bold hover:bg-red-100 transition-all">
                Delete
            </button>

            <!-- Delete Confirmation Modal -->
            <div x-show="showDeleteModal" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <!-- Backdrop -->
                <div x-show="showDeleteModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                <div class="fixed inset-0 z-10 overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                                    </div>
                                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Hapus Jadwal</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus jadwal ini secara permanen? Data jadwal dan laporan yang terkait dengan sesi ini akan terhapus dan tidak dapat dikembalikan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST">
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
    </div>
</div>
@endsection
