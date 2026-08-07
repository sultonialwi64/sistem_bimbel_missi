@extends('layouts.app')

@section('content')
<div class="space-y-10 min-h-screen pb-12">
    <!-- Hero Header -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 text-white shadow-xl">
        <!-- Abstract Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-[20%] -right-[10%] w-[50%] h-[100%] rounded-full bg-indigo-500/20 blur-[100px]"></div>
            <div class="absolute -bottom-[20%] -left-[10%] w-[50%] h-[100%] rounded-full bg-purple-500/20 blur-[100px]"></div>
            <div class="absolute top-[20%] left-[20%] w-[30%] h-[50%] rounded-full bg-blue-500/10 blur-[60px]"></div>
        </div>

        <div class="relative p-6 sm:p-8 lg:p-10 flex flex-col sm:flex-row justify-between items-center gap-6 backdrop-blur-3xl">
            <div class="max-w-2xl z-10 text-center sm:text-left">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-500/20 text-indigo-200 text-xs font-semibold mb-4 border border-indigo-500/30">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Digital Learning Hub (Tutor)
                </span>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold mb-3 tracking-tight leading-tight">
                    Eksplorasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 inline-block pb-1 pr-1">Media Belajar</span>
                </h1>
                <p class="text-slate-300 text-base sm:text-lg font-medium leading-relaxed max-w-xl">
                    Gunakan materi pelajaran, buku panduan, dan game interaktif ini untuk mendukung proses belajar mengajar.
                </p>
            </div>
            <div class="shrink-0 z-10 hidden md:block">
                <div class="relative p-4 bg-white/5 rounded-2xl border border-white/10 backdrop-blur-md shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-500">
                    <svg class="h-16 w-16 text-indigo-300 drop-shadow-2xl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="flex flex-wrap items-center gap-2 mb-8 px-2">
        @foreach($categories as $category)
            <a href="{{ route('tutor.learning-media.index', ['category' => $category]) }}" 
               class="px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 {{ $currentCategory === $category ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/30 ring-2 ring-indigo-500/50 ring-offset-2 ring-offset-slate-900' : 'bg-white/10 backdrop-blur-md text-slate-300 border border-white/10 hover:bg-white/20 hover:text-white' }}">
                {{ $category }}
            </a>
        @endforeach
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 px-2">
        @forelse($media as $item)
            <a href="{{ route('tutor.learning-media.show', $item) }}" class="group block relative rounded-2xl overflow-hidden bg-white/80 backdrop-blur-xl border border-slate-200/60 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-indigo-500/20">
                <!-- Thumbnail Container -->
                <div class="aspect-[4/3] w-full bg-slate-100 relative overflow-hidden">
                    @if($item->thumbnail_path)
                        <img src="{{ Storage::url($item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-200 group-hover:from-indigo-50 group-hover:to-slate-100 transition-colors duration-500">
                            @if($item->type === 'pdf')
                                <div class="p-4 bg-rose-100/50 rounded-2xl">
                                    <svg class="h-12 w-12 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                            @elseif($item->type === 'video')
                                <div class="p-4 bg-blue-100/50 rounded-2xl">
                                    <svg class="h-12 w-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            @else
                                <div class="p-4 bg-purple-100/50 rounded-2xl">
                                    <svg class="h-12 w-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300"></div>

                    <!-- Type Badge (Top Right) -->
                    <div class="absolute top-4 right-4 z-10 flex flex-col gap-2 items-end">
                        @if($item->type === 'pdf')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-rose-500/90 text-white backdrop-blur-md shadow-sm border border-rose-400/50">PDF</span>
                        @elseif($item->type === 'video')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-blue-500/90 text-white backdrop-blur-md shadow-sm border border-blue-400/50">VIDEO</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-purple-500/90 text-white backdrop-blur-md shadow-sm border border-purple-400/50">GAME</span>
                        @endif

                        @if($item->is_premium)
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-gradient-to-r from-amber-400 to-amber-500 text-white shadow-sm border border-amber-300/50">
                                <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                PRO
                            </span>
                        @endif
                    </div>

                    <!-- Overlay Icon (Play/Read) - Centered on Hover -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-100 scale-50 z-10">
                        <div class="bg-white/25 backdrop-blur-md p-5 rounded-full text-white shadow-[0_0_40px_rgba(255,255,255,0.3)] border border-white/40 group-hover:animate-pulse">
                            @if($item->type === 'pdf')
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            @else
                                <svg class="h-8 w-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Content Info -->
                <div class="p-6 relative">
                    <!-- Date indicator -->
                    <div class="text-[11px] font-medium text-slate-400 mb-3 flex items-center gap-1.5 uppercase tracking-wider">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $item->created_at->diffForHumans() }}
                    </div>
                    
                    <h3 class="font-bold text-slate-900 text-xl mb-2 line-clamp-1 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-indigo-600 group-hover:to-purple-600 transition-all">{{ $item->title }}</h3>
                    <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">{{ $item->description ?? 'Tidak ada deskripsi. Klik untuk mulai mengeksplorasi materi ini.' }}</p>
                    
                    <!-- Decorative line -->
                    <div class="h-1 w-12 bg-indigo-500 rounded-full mt-5 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-20 px-6 text-center bg-white/50 backdrop-blur-xl rounded-3xl border border-slate-200/60 shadow-sm relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-indigo-50/50 to-transparent pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="h-24 w-24 bg-indigo-100 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                        <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-extrabold text-slate-900 mb-2">Belum Ada Materi</h3>
                    <p class="text-slate-500 text-lg max-w-md mx-auto">Materi belajar sedang dalam persiapan. Silakan cek kembali beberapa saat lagi.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($media->hasPages())
        <div class="mt-12 flex justify-center pb-8">
            <div class="bg-white/80 backdrop-blur-xl p-2 rounded-2xl shadow-sm border border-slate-200/60">
                {{ $media->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
