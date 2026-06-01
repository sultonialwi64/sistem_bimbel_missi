@extends('layouts.app')

@section('title', 'Client Detail')
@section('page-title', $client->user->name)

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
@php
    $canDeletePermanently = $client->students->isEmpty() && $client->payments->isEmpty();
@endphp

<div class="mx-auto max-w-7xl space-y-6" x-data="{ accountOpen: false, addressOpen: false, typeOpen: false, deactivateOpen: false, deleteOpen: false, forceDeleteOpen: false, forceDeleteName: '', addChildOpen: {{ $errors->any() ? 'true' : 'false' }} }">
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
                        <button type="button" @click="accountOpen = true" class="rounded-lg bg-white/10 p-1.5 text-blue-100 transition hover:bg-white/20 hover:text-white" title="Edit informasi akun">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </button>
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
                        <div class="relative rounded-2xl border border-amber-100 bg-amber-50 p-4 text-center">
                            <button type="button" @click="typeOpen = true" class="absolute right-2 top-2 rounded-lg p-1 text-amber-700 transition hover:bg-amber-100" title="Edit tipe client">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <p class="text-sm font-black text-amber-800">{{ $client->client_type === 'tipe_1' ? 'Tipe 1' : 'Tipe 2' }}</p>
                            <p class="text-xs font-semibold text-amber-600">{{ $client->client_type === 'tipe_1' ? 'Rp45rb/sesi' : 'Rp50rb/sesi' }}</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2 sm:flex-row">
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

                    @if($canDeletePermanently)
                        <button type="button" @click="deleteOpen = true" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-50 px-4 py-2.5 text-sm font-bold text-red-700 shadow-sm ring-1 ring-red-100 transition hover:bg-red-100">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Permanen
                        </button>
                    @else
                        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-xs font-semibold leading-5 text-amber-800">
                            Client sudah memiliki anak atau histori tagihan. Gunakan Nonaktifkan untuk operasional normal.
                        </div>
                        <button type="button" @click="forceDeleteOpen = true; forceDeleteName = ''" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-500">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Semua Data
                        </button>
                    @endif
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <h3 class="text-base font-black text-slate-900">Informasi Kontak</h3>
                    <button type="button" @click="addressOpen = true" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" title="Edit kontak">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                </div>
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
                <div class="flex items-start justify-between gap-3">
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
                    <button type="button" @click="addressOpen = true" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700" title="Edit alamat">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                </div>
                <p class="mt-4 leading-7 text-slate-800">{{ $client->address }}</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Daftar Anak</h3>
                        <p class="text-sm text-slate-500">Anak yang terhubung dengan client ini.</p>
                    </div>
                    <button type="button" @click="addChildOpen = true" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Anak
                    </button>
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

    <div x-cloak x-show="accountOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
        <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200" @click.outside="accountOpen = false" x-transition.scale.origin.center>
            <form action="{{ route('admin.clients.update-account', $client) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="border-b border-slate-100 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Edit Informasi Akun</h3>
                            <p class="mt-1 text-sm text-slate-500">Ubah nama, email, telepon, atau password client.</p>
                        </div>
                        <button type="button" @click="accountOpen = false" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <div>
                        <label for="account_name" class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                        <input id="account_name" type="text" name="name" value="{{ old('name', $client->user->name) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div>
                        <label for="account_email" class="block text-sm font-bold text-slate-700">Email</label>
                        <input id="account_email" type="email" name="email" value="{{ old('email', $client->user->email) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div>
                        <label for="account_phone" class="block text-sm font-bold text-slate-700">No. Telepon</label>
                        <input id="account_phone" type="text" name="phone" value="{{ old('phone', $client->user->phone) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label for="account_password" class="block text-sm font-bold text-slate-700">Password Baru</label>
                        <input id="account_password" type="password" name="password" placeholder="Kosongkan jika tidak diubah" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400">
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="accountOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <div x-cloak x-show="addressOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
        <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200" @click.outside="addressOpen = false" x-transition.scale.origin.center>
            <form action="{{ route('admin.clients.update-address', $client) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="border-b border-slate-100 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Edit Alamat & Kontak</h3>
                            <p class="mt-1 text-sm text-slate-500">Ubah alamat home visit dan kontak darurat.</p>
                        </div>
                        <button type="button" @click="addressOpen = false" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-5 p-6">
                    <div>
                        <label for="address" class="block text-sm font-bold text-slate-700">Alamat Lengkap</label>
                        <textarea id="address" name="address" rows="4" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400" required>{{ old('address', $client->address) }}</textarea>
                    </div>
                    <div>
                        <label for="emergency_contact" class="block text-sm font-bold text-slate-700">Kontak Darurat</label>
                        <input id="emergency_contact" type="text" name="emergency_contact" value="{{ old('emergency_contact', $client->emergency_contact) }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400">
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="addressOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>

    <div x-cloak x-show="typeOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
        <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200" @click.outside="typeOpen = false" x-transition.scale.origin.center>
            <form action="{{ route('admin.clients.update-type', $client) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="border-b border-slate-100 px-6 py-5">
                    <h3 class="text-lg font-black text-slate-900">Edit Tipe Client</h3>
                    <p class="mt-1 text-sm text-slate-500">Perubahan tipe akan menyesuaikan tagihan pending.</p>
                </div>
                <div class="space-y-3 p-6">
                    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 p-4 transition hover:bg-slate-50">
                        <input type="radio" name="client_type" value="tipe_1" {{ $client->client_type === 'tipe_1' ? 'checked' : '' }} class="text-indigo-700 focus:ring-indigo-500">
                        <span>
                            <span class="block font-black text-slate-900">Tipe 1</span>
                            <span class="text-sm text-slate-500">Rp45.000 per sesi</span>
                        </span>
                    </label>
                    <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 p-4 transition hover:bg-slate-50">
                        <input type="radio" name="client_type" value="tipe_2" {{ $client->client_type === 'tipe_2' ? 'checked' : '' }} class="text-indigo-700 focus:ring-indigo-500">
                        <span>
                            <span class="block font-black text-slate-900">Tipe 2</span>
                            <span class="text-sm text-slate-500">Rp50.000 per sesi</span>
                        </span>
                    </label>
                </div>
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="typeOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">Simpan Tipe</button>
                </div>
            </form>
        </div>
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

    <div x-cloak x-show="addChildOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
        <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200" @click.outside="addChildOpen = false" x-transition.scale.origin.center>
            <form action="{{ route('admin.clients.students.store', $client) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="border-b border-slate-100 px-6 py-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Tambah Anak</h3>
                            <p class="mt-1 text-sm text-slate-500">Anak akan otomatis terhubung ke {{ $client->user->name }}.</p>
                        </div>
                        <button type="button" @click="addChildOpen = false" class="rounded-xl p-2 text-slate-400 transition hover:bg-slate-100 hover:text-slate-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="child_name" class="block text-sm font-bold text-slate-700">Nama Anak</label>
                        <input id="child_name" type="text" name="name" value="{{ old('name') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400" required>
                        @error('name')
                            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="child_birth_date" class="block text-sm font-bold text-slate-700">Tanggal Lahir</label>
                        <input id="child_birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400">
                        @error('birth_date')
                            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="child_grade_level" class="block text-sm font-bold text-slate-700">Kelas/Jenjang</label>
                        <select id="child_grade_level" name="grade_level" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400">
                            <option value="">Pilih Jenjang</option>
                            @foreach($gradeLevels as $gradeLevel)
                                <option value="{{ $gradeLevel->name }}" {{ old('grade_level') === $gradeLevel->name ? 'selected' : '' }}>
                                    {{ $gradeLevel->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('grade_level')
                            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="child_school_name" class="block text-sm font-bold text-slate-700">Sekolah</label>
                        <input id="child_school_name" type="text" name="school_name" value="{{ old('school_name') }}" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400">
                        @error('school_name')
                            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="child_photo" class="block text-sm font-bold text-slate-700">Foto Anak</label>
                        <input id="child_photo" type="file" name="photo" accept="image/*" class="mt-2 w-full rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-lg file:border-0 file:bg-indigo-700 file:px-4 file:py-2 file:text-sm file:font-bold file:text-white hover:file:bg-indigo-600">
                        <p class="mt-1 text-xs text-slate-400">Opsional, maksimal 2 MB.</p>
                        @error('photo')
                            <p class="mt-1 text-xs font-semibold text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="addChildOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-indigo-700 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-indigo-600">Simpan Anak</button>
                </div>
            </form>
        </div>
    </div>

    @if($canDeletePermanently)
        <div x-cloak x-show="deleteOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
            <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-red-100" @click.outside="deleteOpen = false" x-transition.scale.origin.center>
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Hapus Permanen Client?</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $client->user->name }} akan dihapus permanen beserta akun loginnya. Aksi ini tidak bisa dibatalkan.</p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="deleteOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                    <form action="{{ route('admin.clients.destroy', $client) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-500 sm:w-auto">Ya, Hapus Permanen</button>
                    </form>
                </div>
            </div>
        </div>
    @endif

    @unless($canDeletePermanently)
        <div x-cloak x-show="forceDeleteOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/80 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
            <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl ring-1 ring-red-100" @click.outside="forceDeleteOpen = false" x-transition.scale.origin.center>
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-900">Hapus Semua Data Client?</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Ini akan menghapus permanen client, akun login, anak, jadwal, attendance, laporan, progress, dan tagihan yang terhubung. Aksi ini tidak bisa dibatalkan.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        Ketik nama client persis untuk melanjutkan:
                        <span class="font-black">{{ $client->user->name }}</span>
                    </div>

                    <div class="mt-4">
                        <label for="force_delete_name" class="block text-sm font-bold text-slate-700">Konfirmasi Nama Client</label>
                        <input id="force_delete_name" type="text" x-model="forceDeleteName" class="mt-2 w-full rounded-xl border border-slate-200 px-4 py-3 text-sm shadow-sm focus:border-red-400 focus:ring-2 focus:ring-red-400" autocomplete="off">
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                    <button type="button" @click="forceDeleteOpen = false" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Batal</button>
                    <form action="{{ route('admin.clients.force-destroy', $client) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="confirmation_name" :value="forceDeleteName">
                        <button type="submit" :disabled="forceDeleteName !== @js($client->user->name)" class="w-full rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-red-500 disabled:cursor-not-allowed disabled:bg-red-300 sm:w-auto">
                            Ya, Hapus Semua Data
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endunless
</div>
@endsection
