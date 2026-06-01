@extends('layouts.app')

@section('title', 'Manage Clients')
@section('page-title', 'Client Management')
@section('page-subtitle', 'Manage clients and their information')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="space-y-8" x-data="{ deactivateOpen: false, deactivateAction: '', deactivateName: '' }">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <p class="text-gray-500 text-sm">Manage clients and their information</p>
        </div>
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
            <div class="flex items-center gap-2 rounded-2xl border border-indigo-200 bg-white p-1 shadow-sm w-full sm:w-auto">
                <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="flex-1 sm:flex-none px-3 py-1.5 rounded-xl text-center text-xs font-bold transition-all {{ $statusFilter === 'active' ? 'bg-indigo-700 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50' }}">
                    Aktif
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'inactive']) }}" class="flex-1 sm:flex-none px-3 py-1.5 rounded-xl text-center text-xs font-bold transition-all {{ $statusFilter === 'inactive' ? 'bg-slate-700 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50' }}">
                    Nonaktif
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'all']) }}" class="flex-1 sm:flex-none px-3 py-1.5 rounded-xl text-center text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-amber-500 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50' }}">
                    Semua
                </a>
            </div>
            <form action="{{ route('admin.clients.index') }}" method="GET" class="w-full sm:w-auto relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, telepon..." 
                       class="w-full sm:w-64 pl-10 pr-4 py-2.5 rounded-2xl border border-gray-200 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm shadow-sm transition-all"
                       onblur="this.form.submit()">
                <input type="hidden" name="status" value="{{ $statusFilter }}">
                <svg class="h-4 w-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
            <a href="{{ route('admin.clients.create') }}" class="btn-primary-gradient text-white font-bold px-5 py-2.5 rounded-2xl hover:shadow-2xl flex items-center gap-2 shadow-xl shadow-indigo-500/30 w-full sm:w-auto justify-center">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Client
            </a>
        </div>
    </div>

    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    All Clients
                </h3>
                <span class="text-green-100 text-sm font-semibold">{{ $clients->total() }} clients found</span>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Client</th>
                        <th class="text-left py-4 px-6">Contact</th>
                        <th class="text-left py-4 px-6">Address</th>
                        <th class="text-left py-4 px-6">Children</th>
                        <th class="text-right py-4 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-xl bg-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:shadow-xl group-hover:shadow-indigo-500/30 transition-all">
                                        <span class="text-white font-bold text-sm">{{ substr($client->user->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <div class="flex flex-wrap items-center gap-2">
                                            <p class="font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $client->user->name }}</p>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-black {{ $client->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                                {{ $client->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-500">{{ $client->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-medium text-gray-900">{{ $client->user->phone ?? '-' }}</p>
                                @if($client->emergency_contact)
                                    <p class="text-xs text-gray-500 mt-1">Emergency: {{ $client->emergency_contact }}</p>
                                @endif
                                <div class="mt-2">
                                    @if($client->client_type == 'tipe_1')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            Tipe 1 (Rp 45rb)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                            Tipe 2 (Rp 50rb)
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-900 max-w-xs truncate">{{ $client->address }}</p>
                                @if($client->address_lat && $client->address_lng)
                                    <a href="https://www.google.com/maps?q={{ $client->address_lat }},{{ $client->address_lng }}" target="_blank" class="text-xs text-green-600 hover:text-green-800 inline-flex items-center gap-1 mt-1">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        View on map
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-700 rounded-full text-xs font-bold">
                                    {{ $client->students->count() }} children
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.clients.show', $client) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-blue-500/20 transition-all">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Kelola
                                    </a>
                                    @if($client->is_active)
                                        <div class="inline">
                                            <button type="button" @click="deactivateAction = '{{ route('admin.clients.deactivate', $client) }}'; deactivateName = @js($client->user->name); deactivateOpen = true" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-slate-50 to-gray-100 text-slate-700 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-slate-500/20 transition-all">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 115.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                Nonaktifkan
                                            </button>
                                        </div>
                                    @else
                                        <form action="{{ route('admin.clients.activate', $client) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-700 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-emerald-500/20 transition-all">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                Aktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <p class="text-gray-500 font-semibold">No clients found</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($clients as $client)
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-11 w-11 rounded-xl bg-indigo-700 flex items-center justify-center shadow-md flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ substr($client->user->name, 0, 2) }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <p class="font-bold text-gray-900 text-sm">{{ $client->user->name }}</p>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[9px] font-black {{ $client->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $client->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 truncate">{{ $client->user->email }}</p>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 bg-blue-50 border border-blue-200 text-blue-700 rounded-full text-[10px] font-bold flex-shrink-0">
                            {{ $client->students->count() }} anak
                        </span>
                    </div>

                    <div class="space-y-1.5 mb-3 text-xs text-gray-600">
                        @if($client->user->phone)
                            <div class="flex items-center gap-2">
                                <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span class="font-semibold text-gray-800">{{ $client->user->phone }}</span>
                            </div>
                        @endif
                        @if($client->address)
                            <div class="flex items-start gap-2">
                                <svg class="h-3.5 w-3.5 text-indigo-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="line-clamp-2">{{ $client->address }}</span>
                            </div>
                        @endif
                        @if($client->emergency_contact)
                            <div class="flex items-center gap-2">
                                <svg class="h-3.5 w-3.5 text-red-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <span class="text-red-600">Emergency: {{ $client->emergency_contact }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <svg class="h-3.5 w-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            @if($client->client_type == 'tipe_1')
                                <span class="text-green-700 font-medium">Tipe 1 (Rp 45.000)</span>
                            @else
                                <span class="text-blue-700 font-medium">Tipe 2 (Rp 50.000)</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-3 border-t border-gray-50">
                        <a href="{{ route('admin.clients.show', $client) }}" class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Kelola
                        </a>
                        @if($client->is_active)
                            <div class="inline flex-1">
                                <button type="button" @click="deactivateAction = '{{ route('admin.clients.deactivate', $client) }}'; deactivateName = @js($client->user->name); deactivateOpen = true" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-slate-50 text-slate-700 rounded-xl font-semibold text-xs hover:bg-slate-100 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 115.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                    Nonaktif
                                </button>
                            </div>
                        @else
                            <form action="{{ route('admin.clients.activate', $client) }}" method="POST" class="inline flex-1">
                                @csrf
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-1.5 py-2 bg-emerald-50 text-emerald-700 rounded-xl font-semibold text-xs hover:bg-emerald-100 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Aktifkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">No clients found</p>
                </div>
            @endforelse
        </div>

        @if($clients->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $clients->links() }}
            </div>
        @endif
    </div>

    <div x-cloak x-show="deactivateOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/70 px-4 py-6 backdrop-blur-sm" x-transition.opacity>
        <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl ring-1 ring-slate-200" @click.outside="deactivateOpen = false" x-transition.scale.origin.center>
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-slate-100 text-slate-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 115.636 5.636m12.728 12.728L5.636 5.636"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="text-lg font-black text-slate-900">Nonaktifkan Client?</h3>
                        <p class="mt-1 text-sm leading-6 text-slate-600">
                            <span class="font-bold text-slate-800" x-text="deactivateName"></span> akan dinonaktifkan dari operasional baru. Data siswa, sesi, laporan, dan tagihan lama tetap tersimpan.
                        </p>
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                    Client tidak akan ikut auto-generate tagihan baru dan akun loginnya tidak bisa masuk sampai diaktifkan kembali.
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-100 bg-slate-50 px-6 py-4 sm:flex-row sm:justify-end">
                <button type="button" @click="deactivateOpen = false" class="inline-flex justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition-all hover:bg-slate-50">
                    Batal
                </button>
                <form method="POST" :action="deactivateAction">
                    @csrf
                    <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition-all hover:bg-slate-700 sm:w-auto">
                        Ya, Nonaktifkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
