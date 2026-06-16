@php
    $specializations = collect($tutor->specialization ?? [])->filter()->values();
    $rawAvatar = $tutor->user->avatar;
    $avatarUrl = null;

    if ($rawAvatar && str_starts_with($rawAvatar, 'http')) {
        $avatarUrl = $rawAvatar;
    } elseif ($rawAvatar) {
        $relativeAvatar = ltrim($rawAvatar, '/');
        $avatarUrl = file_exists(public_path($relativeAvatar)) ? asset($relativeAvatar) : null;
    }

    $initials = collect(explode(' ', $tutor->user->name))
        ->filter()
        ->take(2)
        ->map(fn ($part) => mb_substr($part, 0, 1))
        ->implode('');
@endphp

<article class="group relative overflow-hidden rounded-lg border border-white/80 bg-white p-5 shadow-xl shadow-slate-900/10 transition hover:-translate-y-1 hover:shadow-2xl">
    <div class="absolute inset-x-0 top-0 h-24 bg-gradient-to-br from-miss-navy via-miss-navyDark to-miss-gold"></div>
    <div class="relative">
        <div class="flex items-start justify-between gap-4">
            <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full border-4 border-white bg-miss-blueSoft shadow-xl sm:h-24 sm:w-24">
                @if($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="Tutor {{ $tutor->user->name }}" class="h-full w-full object-cover">
                @else
                    <span class="text-2xl font-black text-miss-navy">{{ $initials }}</span>
                @endif
            </div>
            <span class="rounded-full bg-white/90 px-3 py-1 text-[11px] font-black text-miss-goldDark shadow-sm sm:text-xs">Tutor Missi</span>
        </div>

        <div class="mt-5">
            <h3 class="text-lg font-black leading-7 text-slate-950 sm:text-xl">{{ $tutor->user->name }}</h3>
            <p class="mt-1 min-h-5 text-sm font-bold leading-6 text-slate-500">{{ $tutor->education ?: 'Pengajar Missi' }}</p>
        </div>

        <p class="mt-4 text-xs font-black uppercase text-miss-goldDark">Bidang yang diampu</p>
        <div class="mt-3 flex flex-wrap gap-2">
            @forelse($specializations->take(4) as $specialization)
                <span class="rounded-full bg-miss-blueSoft px-3 py-1 text-xs font-black text-miss-navy">{{ $specialization }}</span>
            @empty
                <span class="rounded-full bg-miss-blueSoft px-3 py-1 text-xs font-black text-miss-navy">Tutor Missi</span>
            @endforelse
        </div>
        @if($specializations->count() > 4)
            <p class="mt-3 text-xs font-bold text-slate-500">+{{ $specializations->count() - 4 }} bidang lainnya</p>
        @endif
    </div>
</article>
