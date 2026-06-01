@extends('layouts.app')

@section('title', 'Client Detail')
@section('page-title', $client->user->name)

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="mx-auto max-w-7xl space-y-6" x-data="{ deactivateOpen: false }">
    <a href="{{ route('admin.clients.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-300 transition hover:text-white">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Back to Clients
    </a>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-[360px_minmax(0,1fr)]">
        <aside class="space-y-6">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="bg-gradient-to-br from-indigo-800 to-blue-900 px-6 py-8 text-center text-white">
                    <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-3xl bg-white/15 text-4xl font-black shadow-lg ring-1 ring-white/20">
                        {{ strtoupper(substr($client->user->name, 0, 2)) }}
                    </div>
                    <div class="mt-4 flex items-center justify-center gap-2">
                        <h2 class="text-2xl font-black">{{ $client->user->name }}</h2>
                        <span class="rounded-full px-2.5 py-1 text-[10px] font-black {{ $client->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                            {{ $client->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                    <p class="mt-1 text-sm text-blue-100">{{ $client->user->email }}</p>
                    <p class="text-sm text-blue-100">{{ $client->user->phone ?? '-' }}</p>
                </div>

                <div class="space-y-5 p-6">
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4 text-center">
                            <p class="text-2xl font-black text-blue-800">{{ $client->students->count() }}</p>
                            <p class="text-xs font-semibold text-blue-500">Anak</p>
                        </div>
                        <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4 text-center">
                            <p class="text-sm font-black text-amber-800">{{ $client->client_type === 'tipe_1' ? 'Tipe 1' : 'Tipe 2' }}</p>
                            <p class="text-xs font-semibold text-amber-600">{{ $client->client_type === 'tipe_1' ? 'Rp45rb/sesi' : 'Rp50rb/sesi' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row">
                        <a href="{{ route('admin.clients.edit', $client) }}" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        @if($client->is_active)
                            <button type="button" @click="deactivateOpen = true" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-200">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 115.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                                Nonaktifkan
                            </button>
                        @else
                            <form action="{{ route('admin.clients.activate', $client) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-500">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Aktifkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <h3 class="text-base font-black text-slate-900">Informasi Kontak</h3>
                <div class="mt-4 space-y-4 text-sm">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Kontak Darurat</p>
                        <p class="mt-1 font-semibold text-slate-800">{{ $client->emergency_contact ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Ditambahkan Oleh</p>
                        <p class="mt-1 font-semibold text-slate-800">{{ $client->createdBy?->name ?? 'Data lama / tidak tercatat' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Tanggal Ditambahkan</p>
                        <p class="mt-1 font-semibold text-slate-800">{{ $client->created_at?->translatedFormat('d F Y H:i') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <main class="space-y-6">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Alamat</h3>
                        <p class="text-sm text-slate-500">Alamat utama client untuk layanan home visit.</p>
                    </div>
                </div>
                <p class="mt-4 leading-7 text-slate-800">{{ $client->address }}</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Daftar Anak</h3>
                        <p class="text-sm text-slate-500">Anak yang terhubung dengan client ini.</p>
                    </div>
                    <a href="{{ route('admin.students.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Anak
                    </a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($client->students as $student)
                        <div class="flex flex-col gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex min-w-0 items-center gap-3">
                                <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&size=80' }}" class="h-12 w-12 rounded-xl object-cover">
                                <div class="min-w-0">
                                    <p class="truncate font-black text-slate-900">{{ $student->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $student->grade_level ?: '-' }}{{ $student->school_name ? ' - '.$student->school_name : '' }}</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.students.show', $student) }}" class="inline-flex items-center justify-center rounded-xl bg-white px-4 py-2 text-sm font-bold text-indigo-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-indigo-50">View</a>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center">
                            <p class="font-bold text-slate-700">Belum ada anak</p>
                            <p class="mt-1 text-sm text-slate-500">Tambahkan anak dari client ini agar jadwal dan tagihan bisa dibuat.</p>
                        </div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Riwayat Tagihan</h3>
                        <p class="text-sm text-slate-500">Lima tagihan terakhir dari client ini.</p>
                    </div>
                    <a href="{{ route('admin.payments.index', ['search' => $client->user->name]) }}" class="text-sm font-bold text-indigo-700 hover:text-indigo-900">View All</a>
                </div>

                <div class="mt-5 space-y-3">
                    @forelse($client->payments()->with('student')->latest()->take(5)->get() as $payment)
                        <div class="flex flex-col gap-3 rounded-2xl border border-slate-100 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="font-black text-slate-900">{{ $payment->student->name ?? '-' }}</p>
                                <p class="text-sm text-slate-500">Jatuh tempo {{ $payment->due_date?->translatedFormat('d F Y') ?? '-' }}</p>
                            </div>
                            <div class="text-left sm:text-right">
                                <p class="text-lg font-black text-slate-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-black {{ $payment->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center">
                            <p class="font-bold text-slate-700">Belum ada tagihan</p>
                            <p class="mt-1 text-sm text-slate-500">Tagihan akan muncul setelah ada sesi yang valid.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </main>
    </div>

    <div x-cloak x-show="deactivateOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
        <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200" @click.outside="deactivateOpen = false" x-transition.scale.origin.center>
            <div class="p-6">
                <h3 class="text-lg font-black text-slate-900">Nonaktifkan Client?</h3>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $client->user->name }} akan dinonaktifkan dari operasional baru. Data siswa, sesi, laporan, dan tagihan lama tetap tersimpan.</p>
            </div>
            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                <button type="button" @click="deactivateOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                <form action="{{ route('admin.clients.deactivate', $client) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-700 sm:w-auto">Ya, Nonaktifkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
