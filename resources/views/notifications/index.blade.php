@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')
@section('page-subtitle', 'Pantau aktivitas penting sistem')

@section('content')
@php
    $unreadTotal = $notifications->where('is_read', false)->count();
    $iconStyles = [
        'new_schedule' => ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-600', 'ring' => 'ring-blue-500/20'],
        'new_report' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-500/20'],
        'payment_due' => ['bg' => 'bg-red-500/10', 'text' => 'text-red-600', 'ring' => 'ring-red-500/20'],
        'salary_ready' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-600', 'ring' => 'ring-amber-500/20'],
        'quality_alert' => ['bg' => 'bg-purple-500/10', 'text' => 'text-purple-600', 'ring' => 'ring-purple-500/20'],
        'new_client' => ['bg' => 'bg-sky-500/10', 'text' => 'text-sky-600', 'ring' => 'ring-sky-500/20'],
        'new_student' => ['bg' => 'bg-indigo-500/10', 'text' => 'text-indigo-600', 'ring' => 'ring-indigo-500/20'],
        'missing_report' => ['bg' => 'bg-orange-500/10', 'text' => 'text-orange-600', 'ring' => 'ring-orange-500/20'],
        'data_deactivated' => ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-600', 'ring' => 'ring-slate-500/20'],
    ];
@endphp

<div class="mx-auto max-w-5xl space-y-5">
    <section class="rounded-[1.35rem] border border-slate-700/70 bg-slate-800/45 p-4 shadow-xl shadow-slate-950/10 sm:p-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-start gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#205085] text-white shadow-lg shadow-blue-950/20">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-white">Pusat Notifikasi</h2>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-400">
                        Aktivitas terbaru dari jadwal, laporan sesi, client, siswa, dan tagihan akan muncul di sini.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="inline-flex items-center gap-2 rounded-full border border-slate-600/70 bg-slate-900/45 px-3 py-2 text-sm font-semibold text-slate-200">
                    <span class="h-2 w-2 rounded-full bg-orange-400"></span>
                    {{ $unreadTotal }} belum dibaca
                </span>
                <span class="inline-flex items-center rounded-full border border-slate-600/70 bg-slate-900/45 px-3 py-2 text-sm font-semibold text-slate-200">
                    {{ $notifications->count() }} total
                </span>

                @if($unreadTotal > 0)
                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-[#c28552] px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-[#b46c43] focus:outline-none focus:ring-2 focus:ring-[#c28552]/40">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Tandai Semua
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-[1.35rem] border border-slate-700/70 bg-white shadow-2xl shadow-slate-950/10">
        @forelse($notifications as $notification)
            @php
                $style = $iconStyles[$notification->type] ?? ['bg' => 'bg-slate-500/10', 'text' => 'text-slate-600', 'ring' => 'ring-slate-500/20'];
            @endphp

            <article class="relative border-b border-slate-100 last:border-b-0 {{ !$notification->is_read ? 'bg-[#f6f9fd]' : 'bg-white' }} transition hover:bg-slate-50">
                @if(!$notification->is_read)
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#c28552]"></div>
                @endif

                <div class="grid gap-4 px-4 py-4 sm:grid-cols-[auto_1fr_auto] sm:items-start sm:px-6 sm:py-5">
                    <div class="flex items-center gap-3 sm:block">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $style['bg'] }} {{ $style['text'] }} ring-1 {{ $style['ring'] }}">
                            @if($notification->type === 'new_schedule')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            @elseif($notification->type === 'new_report')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            @elseif($notification->type === 'payment_due' || $notification->type === 'salary_ready')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @elseif($notification->type === 'quality_alert' || $notification->type === 'missing_report')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            @elseif($notification->type === 'new_client')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-4-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            @elseif($notification->type === 'new_student')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0118 20.944M12 14L5.84 10.578A12.083 12.083 0 006 20.944M12 14v7"/>
                                </svg>
                            @elseif($notification->type === 'data_deactivated')
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 015.636 5.636m12.728 12.728A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            @else
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                            @endif
                        </div>

                        <div class="sm:hidden">
                            <p class="text-xs font-semibold text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                            @if(!$notification->is_read)
                                <span class="mt-1 inline-flex rounded-full bg-orange-50 px-2 py-0.5 text-[11px] font-bold text-orange-700 ring-1 ring-orange-200">Baru</span>
                            @endif
                        </div>
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h3 class="text-[15px] font-extrabold text-slate-950">{{ $notification->title }}</h3>
                            @if(!$notification->is_read)
                                <span class="hidden rounded-full bg-orange-50 px-2 py-0.5 text-[11px] font-bold text-orange-700 ring-1 ring-orange-200 sm:inline-flex">Baru</span>
                            @endif
                        </div>

                        <p class="mt-1 max-w-3xl text-sm leading-6 text-slate-600">{{ $notification->message }}</p>

                        <div class="mt-3 flex flex-wrap items-center gap-2">
                            @if($notification->action_url)
                                <a href="{{ $notification->action_url }}" class="inline-flex items-center gap-1.5 rounded-full border border-blue-100 bg-blue-50 px-3 py-1.5 text-xs font-bold text-[#205085] transition hover:border-blue-200 hover:bg-blue-100">
                                    Lihat Detail
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endif

                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-600 transition hover:border-slate-300 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-[#205085]/20">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Tandai Dibaca
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <div class="hidden min-w-[8rem] text-right sm:block">
                        <p class="text-xs font-semibold text-slate-500">{{ $notification->created_at->diffForHumans() }}</p>
                        @if($notification->is_read)
                            <p class="mt-2 text-[11px] font-semibold text-slate-400">Sudah dibaca</p>
                        @else
                            <span class="mt-2 inline-flex h-2.5 w-2.5 rounded-full bg-[#c28552] ring-4 ring-orange-100"></span>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="px-6 py-16 text-center">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-3xl bg-slate-100 text-slate-500">
                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-extrabold text-slate-950">Belum ada notifikasi</h3>
                <p class="mt-1 text-sm text-slate-500">Aktivitas penting sistem akan tampil di halaman ini.</p>
            </div>
        @endforelse
    </section>
</div>
@endsection
