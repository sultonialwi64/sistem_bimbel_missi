@extends('layouts.app')

@section('title', 'Manage Clients')
@section('page-title', 'Client Management')
@section('page-subtitle', 'Manage clients and their information')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <p class="text-gray-500 text-sm">Kelola data orang tua / wali murid Anda</p>
        </div>
        <a href="{{ route('tutor.clients.create') }}" class="btn-primary-gradient text-white font-bold px-5 py-2.5 rounded-2xl hover:shadow-2xl flex items-center gap-2 shadow-xl shadow-indigo-500/30 w-full sm:w-auto justify-center">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Klien
        </a>
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
                <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30">
                    {{ $clients->total() }} klien
                </span>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Client</th>
                        <th class="text-left py-4 px-6">Kontak</th>
                        <th class="text-left py-4 px-6">Alamat</th>
                        <th class="text-left py-4 px-6">Anak</th>
                        <th class="text-right py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($clients as $client)
                        <tr class="group hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-xl bg-indigo-700 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:shadow-xl group-hover:shadow-indigo-500/30 transition-all">
                                        <span class="text-white font-bold text-sm">{{ substr($client->user->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-green-600 transition-colors">{{ $client->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $client->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm font-medium text-gray-900">{{ $client->user->phone ?? '-' }}</p>
                                @if($client->emergency_contact)
                                    <p class="text-xs text-gray-500 mt-1">Emergency: {{ $client->emergency_contact }}</p>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-900 max-w-xs truncate">{{ $client->address }}</p>
                                @if($client->address_lat && $client->address_lng)
                                    <a href="https://www.google.com/maps?q={{ $client->address_lat }},{{ $client->address_lng }}" target="_blank" class="text-xs text-green-600 hover:text-green-800 inline-flex items-center gap-1 mt-1">
                                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        View on map
                                    </a>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 text-blue-700 rounded-full text-xs font-bold">
                                    {{ $client->students->count() }} anak
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('tutor.clients.show', $client) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl font-semibold text-xs hover:bg-indigo-100 transition-all">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Detail
                                    </a>
                                    <a href="{{ route('tutor.clients.edit', $client) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-xl font-semibold text-xs hover:bg-amber-100 transition-all">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('tutor.clients.destroy', $client) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus klien ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-700 rounded-xl font-semibold text-xs hover:bg-red-100 transition-all">
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="h-20 w-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold">Belum ada klien</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards --}}
        <div class="sm:hidden divide-y divide-slate-100">
            @forelse($clients as $client)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    {{-- Header: avatar + name + children count --}}
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="h-11 w-11 rounded-xl bg-indigo-700 flex items-center justify-center shadow-md flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ substr($client->user->name, 0, 2) }}</span>
                            </div>
                            <div class="min-w-0">
                                <p class="font-bold text-slate-800 truncate">{{ $client->user->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ $client->user->email }}</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 bg-blue-100 text-blue-700 rounded-full text-[10px] font-bold flex-shrink-0">
                            {{ $client->students->count() }} anak
                        </span>
                    </div>

                    {{-- Info grid --}}
                    <div class="bg-slate-50 rounded-xl p-3 space-y-2 border border-slate-100">
                        <div class="flex items-start gap-2">
                            <svg class="h-3.5 w-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span class="text-xs font-semibold text-slate-700">{{ $client->user->phone ?? '-' }}</span>
                        </div>
                        @if($client->emergency_contact)
                        <div class="flex items-start gap-2">
                            <svg class="h-3.5 w-3.5 text-red-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-xs text-slate-600">Darurat: {{ $client->emergency_contact }}</span>
                        </div>
                        @endif
                        @if($client->address)
                        <div class="flex items-start gap-2">
                            <svg class="h-3.5 w-3.5 text-slate-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-xs text-slate-600 leading-relaxed">{{ $client->address }}</span>
                        </div>
                        @endif
                        @if($client->address_lat && $client->address_lng)
                            <a href="https://www.google.com/maps?q={{ $client->address_lat }},{{ $client->address_lng }}" target="_blank" class="inline-flex items-center gap-1 text-[10px] text-green-600 font-semibold hover:text-green-800">
                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                                Lihat di Maps
                            </a>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="grid grid-cols-3 gap-2 pt-1">
                        <a href="{{ route('tutor.clients.show', $client) }}" class="inline-flex items-center justify-center gap-1 py-2 bg-indigo-50 text-indigo-700 rounded-xl font-bold text-xs hover:bg-indigo-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail
                        </a>
                        <a href="{{ route('tutor.clients.edit', $client) }}" class="inline-flex items-center justify-center gap-1 py-2 bg-amber-50 text-amber-700 rounded-xl font-bold text-xs hover:bg-amber-100 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('tutor.clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Yakin hapus klien ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1 py-2 bg-red-50 text-red-700 rounded-xl font-bold text-xs hover:bg-red-100 transition-all">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center">
                    <div class="flex flex-col items-center gap-3">
                        <div class="h-16 w-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-semibold text-sm">Belum ada klien</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($clients->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-slate-50">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
