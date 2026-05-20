@extends('layouts.app')

@section('title', 'Schedules')
@section('page-title', 'Schedule Management')
@section('page-subtitle', 'Manage all tutoring schedules')

@php
    $calendarEvents = $allSchedules->map(function($s) {
        $color = match($s->status) {
            'completed' => '#10b981',
            'scheduled' => '#6366f1',
            'cancelled' => '#ef4444',
            'rescheduled' => '#f59e0b',
            default => '#64748b',
        };

        return [
            'id' => $s->id,
            'title' => $s->student->name . ' - ' . $s->tutor->user->name,
            'start' => $s->date->format('Y-m-d') . 'T' . $s->start_time->format('H:i:s'),
            'end' => $s->date->format('Y-m-d') . 'T' . $s->end_time->format('H:i:s'),
            'url' => route('admin.schedules.show', $s->id),
            'backgroundColor' => $color,
            'borderColor' => $color,
            'textColor' => '#ffffff',
            'extendedProps' => [
                'tutor_name' => $s->tutor->user->name,
                'student_name' => $s->student->name,
                'subject' => $s->subject->name,
            ],
        ];
    })->values()->toArray();
@endphp

@section('content')
<div class="space-y-8" x-data="{ viewMode: 'calendar' }">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <p class="text-gray-500 text-sm">Manage all tutoring schedules</p>
        </div>
        <div class="flex items-center gap-3 w-full sm:w-auto">
            {{-- View Mode Toggle --}}
            <div class="bg-gray-100 p-1 rounded-xl flex items-center shadow-inner">
                <button @@click="viewMode = 'calendar'"
                        :class="viewMode === 'calendar' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                        class="px-3 py-2 rounded-lg text-sm font-bold flex items-center gap-1.5 transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="hidden sm:inline">Calendar</span>
                </button>
                <button @@click="viewMode = 'list'"
                        :class="viewMode === 'list' ? 'bg-white shadow-md text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                        class="px-3 py-2 rounded-lg text-sm font-bold flex items-center gap-1.5 transition-all duration-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    <span class="hidden sm:inline">List</span>
                </button>
            </div>

            <a href="{{ route('admin.schedules.create') }}" class="btn-primary-gradient text-white font-bold px-4 py-2.5 rounded-xl hover:shadow-2xl flex items-center gap-2 shadow-xl shadow-indigo-500/30 transition-all flex-1 sm:flex-auto justify-center">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New
            </a>
        </div>
    </div>

    {{-- Calendar View --}}
    <div x-show="viewMode === 'calendar'" class="card-premium overflow-hidden bg-white shadow-2xl rounded-3xl border border-gray-100">
        <div class="p-3 sm:p-6">
            <div id="calendar" class="w-full"></div>
        </div>
    </div>

    {{-- List View --}}
    <div x-show="viewMode === 'list'" class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    All Schedules List
                </h3>
                <span class="text-blue-100 text-sm font-semibold">{{ $schedules->total() }} schedules</span>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Date &amp; Time</th>
                        <th class="text-left py-4 px-6">Student</th>
                        <th class="text-left py-4 px-6">Tutor</th>
                        <th class="text-left py-4 px-6">Subject</th>
                        <th class="text-left py-4 px-6">Status</th>
                        <th class="text-right py-4 px-6">Actions</th>
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
                                <p class="font-medium text-gray-900">{{ $schedule->tutor->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $schedule->tutor->user->phone ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $schedule->subject->name }}</p>
                                    <span class="inline-flex items-center px-2 py-0.5 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 rounded text-xs font-semibold">{{ $schedule->subject->level }}</span>
                                </div>
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
                                    <a href="{{ route('admin.schedules.show', $schedule) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 text-indigo-700 border border-indigo-100 rounded-xl font-semibold text-xs hover:bg-indigo-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        View
                                    </a>
                                    <a href="{{ route('admin.schedules.edit', $schedule) }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 text-amber-700 border border-amber-100 rounded-xl font-semibold text-xs hover:bg-amber-50 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-50 text-red-700 border border-red-100 rounded-xl font-semibold text-xs hover:bg-red-50 transition-all">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">No schedules found</p>
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
                                <p class="text-xs text-gray-500">{{ $schedule->student->grade_level }}</p>
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
                    <div class="space-y-1 mb-3 text-xs text-gray-600">
                        <div class="flex items-center gap-2">
                            <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="font-semibold text-gray-800">{{ $schedule->date->format('d M Y') }}</span>
                            <span class="text-gray-400">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ $schedule->tutor->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>{{ $schedule->subject->name }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                        <a href="{{ route('admin.schedules.show', $schedule) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            View
                        </a>
                        <a href="{{ route('admin.schedules.edit', $schedule) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-amber-50 text-amber-700 rounded-xl font-semibold text-xs hover:bg-amber-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?');" class="inline flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 text-red-700 rounded-xl font-semibold text-xs hover:bg-red-100 transition-all">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">No schedules found</p>
                </div>
            @endforelse
        </div>

        @if($schedules->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    /* === Base === */
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
        padding: 8px 0;
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.05em;
    }
    .fc-theme-standard td {
        border-color: #e1e7ef;
    }
    .fc .fc-button-primary {
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        border-radius: 0.5rem;
        padding: 0.4rem 0.75rem;
        font-weight: 600;
        font-size: 0.75rem;
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);
        transition: all 0.2s ease;
    }
    .fc .fc-button-primary:hover {
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
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
        margin-bottom: 0.2rem;
        cursor: pointer;
    }
    .fc-event:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 50 !important;
    }
    .fc-daygrid-day-number {
        font-weight: 600;
        color: #64748b;
        padding: 0.4rem !important;
        font-size: 0.8rem;
    }
    .fc-day-today {
        background: #f8fafc !important;
    }
    .fc-day-today .fc-daygrid-day-number {
        color: #4f46e5;
        font-weight: 800;
        background: #e0e7ff;
        border-radius: 9999px;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 3px;
    }
    /* === List view (mobile) === */
    .fc-list-event-title a {
        font-weight: 700;
        color: #1e293b !important;
    }
    .fc-list-day-cushion {
        background: linear-gradient(to right, #f8fafc, #f1f5f9) !important;
    }
    .fc-list-event:hover td {
        background: #eef2ff !important;
    }
    /* === Mobile responsive === */
    @media (max-width: 639px) {
        .fc-toolbar {
            flex-wrap: wrap;
            gap: 8px;
        }
        .fc-toolbar-chunk {
            flex: 0 0 auto;
        }
        .fc-toolbar-title {
            font-size: 1rem !important;
        }
        .fc .fc-button-primary {
            padding: 0.35rem 0.6rem;
            font-size: 0.7rem;
        }
        .fc .fc-button-group {
            gap: 2px;
        }
        .fc-header-toolbar {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }
        .fc-header-toolbar .fc-toolbar-chunk:first-child {
            order: 2;
        }
        .fc-header-toolbar .fc-toolbar-chunk:nth-child(2) {
            order: 1;
            text-align: center;
        }
        .fc-header-toolbar .fc-toolbar-chunk:last-child {
            order: 3;
            display: flex;
            justify-content: flex-end;
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
                right: 'today,listWeek,dayGridMonth'
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
            dayMaxEvents: isMobile ? 2 : 4,
            windowResize: function(view) {
                if (window.innerWidth === lastWidth) return; // Ignore vertical resize (mobile scroll)
                lastWidth = window.innerWidth;
                
                var mobile = window.innerWidth < 640;
                if (mobile && calendar.view.type !== 'listWeek') {
                    calendar.changeView('listWeek');
                    calendar.setOption('headerToolbar', {
                        left: 'prev,next',
                        center: 'title',
                        right: 'today,listWeek,dayGridMonth'
                    });
                } else if (!mobile && calendar.view.type === 'listWeek') {
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
                if (arg.view.type === 'listWeek' || arg.view.type === 'listMonth') {
                    return {
                        html: '<div style="padding:2px 0;">' +
                              '<div style="font-weight:700;color:#1e293b;">' + p.student_name + '</div>' +
                              '<div style="font-size:11px;color:#64748b;">' + p.tutor_name + ' · ' + p.subject + '</div>' +
                              '</div>'
                    };
                }
                return {
                    html: '<div style="padding:2px 5px;line-height:1.3;overflow:hidden;">' +
                          '<div style="font-size:9px;font-weight:700;opacity:0.9;">' + arg.timeText + '</div>' +
                          '<div style="font-size:11px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + p.student_name + '</div>' +
                          '<div style="font-size:9px;opacity:0.85;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">' + p.tutor_name + '</div>' +
                          '</div>'
                };
            }
        });

        calendar.render();
    });
</script>
@endpush
