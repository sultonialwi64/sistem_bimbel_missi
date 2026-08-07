@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto pb-12">
    <!-- Breadcrumb & Nav -->
    <div class="flex items-center gap-3 text-sm text-slate-500 bg-white/50 backdrop-blur-md px-6 py-3 rounded-2xl border border-slate-200/60 shadow-sm w-fit">
        <a href="{{ route('tutor.learning-media.index') }}" class="hover:text-indigo-600 transition-colors flex items-center gap-1.5 font-semibold">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Media Belajar
        </a>
        <span class="text-slate-300">/</span>
        <span class="text-slate-900 font-bold truncate max-w-[200px] sm:max-w-md">{{ $learningMedia->title }}</span>
    </div>

    <!-- Main Content Area -->
    <div class="bg-white rounded-[2.5rem] border border-slate-200/60 shadow-2xl overflow-hidden flex flex-col xl:flex-row relative">
        
        <!-- Media Viewer (Left side on desktop, top on mobile) -->
        <div class="flex-grow bg-slate-950 relative flex items-center justify-center min-h-[400px] xl:min-h-[750px] w-full group overflow-hidden">
            <!-- Background Glow -->
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-900/20 to-purple-900/20 pointer-events-none"></div>
            
            @if($learningMedia->type === 'pdf')
                @if($learningMedia->file_path)
                    <iframe src="{{ Storage::url($learningMedia->file_path) }}" class="w-full h-[85vh] xl:h-full border-0 relative z-10 shadow-2xl"></iframe>
                @else
                    <div class="text-center text-slate-400 p-8 relative z-10">
                        <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="h-12 w-12 opacity-50 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <p class="text-lg font-medium">File PDF tidak ditemukan atau belum diunggah.</p>
                    </div>
                @endif
                
            @elseif($learningMedia->type === 'video' || $learningMedia->type === 'web_game')
                @if($learningMedia->url)
                    <iframe src="{{ $learningMedia->url }}" class="w-full h-[65vh] xl:h-full border-0 relative z-10 shadow-2xl" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @else
                    <div class="text-center text-slate-400 p-8 relative z-10">
                        <div class="w-24 h-24 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                            <svg class="h-12 w-12 opacity-50 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <p class="text-lg font-medium">URL materi tidak valid atau kosong.</p>
                    </div>
                @endif
            @endif
            
        </div>

        <!-- Info Sidebar (Right side on desktop, bottom on mobile) -->
        <div class="w-full xl:w-[420px] shrink-0 bg-white border-l border-slate-100 flex flex-col justify-between">
            <div class="p-8 sm:p-10 overflow-y-auto">
                <div class="flex flex-wrap items-center gap-2 mb-6">
                    @if($learningMedia->type === 'pdf')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200/60 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                            PDF Document
                        </span>
                    @elseif($learningMedia->type === 'video')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-200/60 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
                            Video Player
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-purple-50 text-purple-600 border border-purple-200/60 shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-bounce"></span>
                            Interactive Game
                        </span>
                    @endif

                    @if($learningMedia->is_premium)
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-gradient-to-r from-amber-100 to-amber-50 text-amber-700 shadow-sm border border-amber-200">
                            <svg class="h-3 w-3 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                            PRO
                        </span>
                    @endif
                </div>

                <h2 class="text-3xl font-extrabold text-slate-900 mb-4 leading-tight tracking-tight">{{ $learningMedia->title }}</h2>
                
                <div class="flex items-center gap-3 text-sm text-slate-500 mb-8 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="p-2 bg-white rounded-xl shadow-sm border border-slate-100">
                        <svg class="h-5 w-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-0.5">Ditambahkan pada</p>
                        <p class="font-medium text-slate-700">{{ $learningMedia->created_at->translatedFormat('d F Y') }} <span class="text-slate-400 font-normal">({{ $learningMedia->created_at->diffForHumans() }})</span></p>
                    </div>
                </div>

                @if($learningMedia->description)
                    <div class="prose prose-slate prose-p:leading-relaxed text-slate-600">
                        <h4 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-3 flex items-center gap-2">
                            <svg class="h-4 w-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                            Deskripsi Materi
                        </h4>
                        <p class="text-base bg-white border border-slate-100 p-5 rounded-2xl shadow-sm">{{ $learningMedia->description }}</p>
                    </div>
                @endif
            </div>
            
            <div class="p-8 sm:p-10 bg-slate-50 border-t border-slate-100">
                @if($learningMedia->type === 'pdf' && $learningMedia->file_path)
                    <a href="{{ Storage::url($learningMedia->file_path) }}" target="_blank" download class="w-full flex items-center justify-center gap-3 py-4 px-6 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 hover:-translate-y-1">
                        <svg class="h-6 w-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download PDF File
                    </a>
                    <p class="text-center text-xs font-medium text-slate-400 mt-4">Anda dapat mendownload file ini untuk dibaca secara offline.</p>
                @elseif($learningMedia->url)
                    <a href="{{ $learningMedia->url }}" target="_blank" class="w-full flex items-center justify-center gap-3 py-4 px-6 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-indigo-200 hover:shadow-xl hover:shadow-indigo-300 hover:-translate-y-1">
                        Buka di Tab Baru / Fullscreen
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
