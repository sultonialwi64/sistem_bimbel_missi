@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-8 rounded-[2rem] shadow-sm border border-slate-200/60 relative overflow-hidden">
        <div class="absolute right-0 top-0 w-64 h-64 bg-indigo-50 rounded-full blur-3xl -mr-20 -mt-20 pointer-events-none"></div>
        <div class="relative z-10">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Media Belajar & Game</h1>
            <p class="text-slate-500 text-base">Kelola semua materi PDF, Video, dan Web Game untuk client.</p>
        </div>
        <div class="relative z-10">
            <a href="{{ route('admin.learning-media.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-2xl transition-all duration-300 shadow-lg shadow-slate-900/20 hover:-translate-y-0.5 focus:ring-4 focus:ring-slate-200">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Media Baru
            </a>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-[2rem] border border-slate-200/60 shadow-xl shadow-slate-200/40 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200">
                        <th class="px-8 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest w-2/5">Judul & Info</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest w-1/5">Tipe</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest w-1/5">Status & Akses</th>
                        <th class="px-8 py-5 text-xs font-bold text-slate-500 uppercase tracking-widest text-right w-1/5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    <!-- STATIC SPELLING GAME ROW -->
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200 group bg-yellow-50/30">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-5">
                                <div class="shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-yellow-100 flex items-center justify-center border border-yellow-200 shadow-sm relative group-hover:shadow-md transition-shadow">
                                    <svg class="h-8 w-8 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-slate-900 text-lg mb-1 truncate group-hover:text-amber-600 transition-colors">Spelling Game (Prototype)</h3>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-yellow-100 text-yellow-700 border border-yellow-200">Mini Game</span>
                                        <p class="text-sm text-slate-500 truncate max-w-[150px]">Latih kemampuan mengeja kosakata bahasa Inggris.</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-purple-50 text-purple-600 border border-purple-200">Game</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-2 items-start">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-slate-100 text-slate-600 border border-slate-200">Gratis</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('game.prototype') }}" 
                                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-xl transition-colors shadow-sm shadow-amber-200">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Mainkan
                                </a>
                            </div>
                        </td>
                    </tr>
                    <!-- SORT GAME ROW -->
                    <tr class="hover:bg-slate-50/50 transition-colors duration-200 group bg-indigo-50/30">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-5">
                                <div class="shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-indigo-100 flex items-center justify-center border border-indigo-200 shadow-sm relative group-hover:shadow-md transition-shadow">
                                    <svg class="h-8 w-8 text-indigo-500" fill="currentColor" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" fill="none" stroke="currentColor" stroke-width="2"/></svg>
                                </div>
                                <div class="min-w-0">
                                    <h3 class="font-bold text-slate-900 text-lg mb-1 truncate group-hover:text-indigo-600 transition-colors">Sort The Days</h3>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-indigo-100 text-indigo-700 border border-indigo-200">Interactive</span>
                                        <p class="text-sm text-slate-500 truncate max-w-[150px]">Sortir nama hari dan bulan.</p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-purple-50 text-purple-600 border border-purple-200">Game</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col gap-2 items-start">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-emerald-50 text-emerald-700 border border-emerald-200/60">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Active
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-slate-100 text-slate-600 border border-slate-200">Gratis</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('game.sort') }}" 
                                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-bold text-white bg-indigo-500 hover:bg-indigo-600 rounded-xl transition-colors shadow-sm shadow-indigo-200">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Mainkan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @forelse($media as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-5">
                                    <div class="shrink-0 w-16 h-16 rounded-2xl overflow-hidden bg-slate-100 flex items-center justify-center border border-slate-200 shadow-sm relative group-hover:shadow-md transition-shadow">
                                        @if($item->thumbnail_path)
                                            <img src="{{ Storage::url($item->thumbnail_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        @else
                                            @if($item->type === 'pdf')
                                                <svg class="h-8 w-8 text-rose-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            @elseif($item->type === 'video')
                                                <svg class="h-8 w-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @else
                                                <svg class="h-8 w-8 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h3 class="font-bold text-slate-900 text-lg mb-1 truncate">{{ $item->title }}</h3>
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-600 border border-slate-200">{{ $item->category }}</span>
                                            <p class="text-sm text-slate-500 truncate max-w-[150px]">{{ $item->description ?? 'Tidak ada deskripsi' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                @if($item->type === 'pdf')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-rose-50 text-rose-600 border border-rose-200">PDF</span>
                                @elseif($item->type === 'video')
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-600 border border-blue-200">Video</span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider bg-purple-50 text-purple-600 border border-purple-200">Game</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex flex-col gap-2 items-start">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold tracking-wide {{ $item->is_active ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $item->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        {{ $item->is_active ? 'Active' : 'Draft' }}
                                    </span>
                                    
                                    @if($item->is_premium)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-gradient-to-r from-amber-100 to-amber-50 text-amber-700 shadow-sm border border-amber-200">
                                            <svg class="h-3 w-3 text-amber-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                            PRO
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold tracking-wide bg-slate-100 text-slate-600 border border-slate-200">Gratis</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.learning-media.edit', $item) }}" 
                                       class="p-2.5 text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-xl transition-colors tooltip" data-tip="Edit">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.learning-media.destroy', $item) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini? Data tidak dapat dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 text-rose-600 bg-rose-50 hover:bg-rose-600 hover:text-white rounded-xl transition-colors tooltip" data-tip="Hapus">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-8 py-24 text-center">
                                <div class="w-24 h-24 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-slate-100">
                                    <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Materi</h3>
                                <p class="text-slate-500 max-w-sm mx-auto mb-6">Mulai tambahkan PDF, Video, atau Game Interaktif untuk client Anda.</p>
                                <a href="{{ route('admin.learning-media.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all shadow-md shadow-indigo-200">
                                    Tambah Materi Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($media->hasPages())
            <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                {{ $media->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
