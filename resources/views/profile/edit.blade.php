@extends('layouts.app')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-subtitle', 'Kelola informasi akun dan foto profil Anda.')

@section('content')
@php
    $avatarUrl = $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=205085&color=fff&size=128';
    $tutorProfile = $user->tutor;
    $tutorSpecializations = collect($tutorProfile?->specialization ?? [])->filter()->values();

    $roleLabel = match($user->role) {
        'admin' => 'Administrator',
        'tutor' => 'Tutor Aktif',
        'client' => 'Wali Murid',
        default => ucfirst($user->role),
    };

    $roleNote = match($user->role) {
        'tutor' => 'Foto dan nama di sini dipakai sebagai identitas profil tutor, termasuk untuk tampilan publik jika profil tutor ditampilkan.',
        'client' => 'Pastikan data akun mudah dikenali agar komunikasi terkait siswa dan tagihan tetap lancar.',
        default => 'Gunakan data akun yang rapi agar identitas di sistem tetap konsisten.',
    };

@endphp

<div class="grid gap-6 xl:grid-cols-[280px_minmax(0,1fr)]">
    <aside class="xl:sticky xl:top-28 xl:self-start">
        <div class="rounded-3xl border border-slate-700/50 bg-slate-800 shadow-xl">
            <div class="px-6 py-6">
                <div class="flex items-center gap-4">
                    <img
                        src="{{ $avatarUrl }}"
                        alt="Foto profil {{ $user->name }}"
                        class="h-16 w-16 rounded-2xl object-cover ring-2 ring-white/10"
                    >
                    <div class="min-w-0">
                        <p class="text-lg font-black leading-tight text-white">{{ $user->name }}</p>
                        <p class="mt-1 truncate text-sm text-slate-300">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="mt-4 inline-flex rounded-full border border-[#c28552]/30 bg-[#c28552]/10 px-3 py-1 text-xs font-black text-[#f3c79f]">
                    {{ $roleLabel }}
                </div>

                <p class="mt-4 text-sm leading-7 text-slate-300">{{ $roleNote }}</p>

                @if($user->role === 'tutor' && $tutorSpecializations->isNotEmpty())
                    <div class="mt-5 border-t border-white/10 pt-5">
                        <p class="text-[11px] font-black uppercase tracking-wide text-slate-400">Bidang yang Diampu</p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach($tutorSpecializations->take(4) as $specialization)
                                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-bold text-white">
                                    {{ $specialization }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </aside>

    <div class="space-y-6">
        <div class="rounded-3xl border border-slate-700/50 bg-white p-5 shadow-xl sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-3xl border border-slate-700/50 bg-white p-5 shadow-xl sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-3xl border border-red-200/70 bg-white p-5 shadow-xl sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
