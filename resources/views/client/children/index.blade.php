@extends('layouts.app')

@section('title', 'Data Anak')
@section('page-title', 'Data Anak')
@section('page-subtitle', 'Daftar anak Anda dan perkembangan belajarnya')

@section('content')
<div class="space-y-5">
    @if($students->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($students as $student)
                <a href="{{ route('client.children.show', $student) }}" class="group card-premium block hover:scale-[1.01] transition-all duration-300">
                    <!-- Gradient Top Bar -->
                    <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                    <div class="p-4 sm:p-5">
                        <!-- Student info row -->
                        <div class="flex items-center gap-3 mb-4">
                            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}"
                                 class="h-14 w-14 rounded-2xl object-cover ring-2 ring-indigo-500/20 group-hover:ring-indigo-500/40 transition-all flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors truncate">{{ $student->name }}</h3>
                                <p class="text-xs text-gray-500 truncate mt-0.5">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                                <span class="badge mt-1 {{ $student->is_active ? 'badge-green' : 'badge-gray' }}">
                                    {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>

                        <!-- Stats row -->
                        <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                            <div class="bg-slate-50 rounded-xl p-2.5 border border-slate-100">
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Tgl Lahir</div>
                                <div class="font-semibold text-slate-700">{{ $student->birth_date?->format('d M Y') ?? '-' }}</div>
                            </div>
                            <div class="bg-indigo-50 rounded-xl p-2.5 border border-indigo-100 text-center">
                                <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider mb-0.5">Sesi Mendatang</div>
                                <div class="text-xl font-black text-indigo-700">
                                    {{ $student->schedules()->where('date', '>=', today())->where('status', 'scheduled')->count() }}
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-xs font-bold text-indigo-600 group-hover:text-indigo-700">Lihat perkembangan</span>
                            <svg class="h-4 w-4 text-indigo-400 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <div class="card-premium p-12">
            <div class="empty-state">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <p class="font-semibold text-gray-500">Belum ada data anak</p>
                <p class="text-sm text-gray-400">Hubungi admin untuk mendaftarkan anak Anda</p>
            </div>
        </div>
    @endif
</div>
@endsection
