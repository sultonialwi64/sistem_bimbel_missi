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

<article class="group relative flex h-[400px] w-full flex-col justify-end overflow-hidden rounded-2xl border-[3px] border-dark-ink bg-slate-950 brutal-shadow transition-transform duration-300 hover:scale-[1.02] hover:brutal-shadow-hover sm:h-[450px]">
    <!-- Image Background -->
    @if($avatarUrl)
        <img src="{{ $avatarUrl }}" alt="Tutor {{ $tutor->user->name }}" class="absolute inset-0 h-full w-full object-cover grayscale-[30%] transition-all duration-500 group-hover:scale-105 group-hover:grayscale-0">
    @else
        <!-- Placeholder -->
        <div class="absolute inset-0 bg-blue-50 bg-grid-pattern opacity-60"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-7xl font-black text-electric-blue opacity-20">{{ $initials }}</span>
        </div>
    @endif

    <!-- Gradient Overlay (Dark bottom for text legibility) -->
    <div class="absolute inset-x-0 bottom-0 h-3/5 bg-gradient-to-t from-dark-ink via-dark-ink/80 to-transparent"></div>

    <!-- Top Badge (Neo-Brutalist New/Tutor Badge) -->
    <div class="absolute left-4 top-4">
        <span class="inline-flex rounded-full border-2 border-dark-ink bg-acid-lime px-3 py-1 text-xs font-black uppercase text-dark-ink shadow-[2px_2px_0px_#0f172a] font-mono">
            Tutor
        </span>
    </div>

    <!-- Content (bottom) -->
    <div class="relative z-10 p-5 pb-6 text-left">
        <!-- Education / Subtitle -->
        <p class="text-xs font-bold uppercase tracking-wide text-vivid-amber font-mono">
            {{ $tutor->education ?: 'Pengajar Missi' }}
        </p>
        
        <!-- Name -->
        <h3 class="mt-1 text-2xl font-black leading-tight text-white font-display">
            {{ $tutor->user->name }}
        </h3>
        
        <!-- Divider -->
        <div class="my-3 h-1 w-10 rounded-full bg-electric-blue"></div>
        
        <!-- Specializations -->
        <div class="flex flex-wrap gap-2">
            @forelse($specializations->take(2) as $specialization)
                <span class="rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-[10px] font-bold text-white backdrop-blur-sm">
                    {{ $specialization }}
                </span>
            @empty
                <span class="rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-[10px] font-bold text-white backdrop-blur-sm">
                    Privat
                </span>
            @endforelse
            
            @if($specializations->count() > 2)
                <span class="rounded-full border border-white/20 bg-white/10 px-2.5 py-1 text-[10px] font-bold text-white backdrop-blur-sm">
                    +{{ $specializations->count() - 2 }}
                </span>
            @endif
        </div>
    </div>
</article>
