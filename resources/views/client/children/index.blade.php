@extends('layouts.app')

@section('title', 'Data Anak')
@section('page-title', 'Data Anak')
@section('page-subtitle', 'Daftar anak Anda dan perkembangan belajarnya')

@section('content')
<div class="space-y-6">
    @if($students->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($students as $student)
            <a href="{{ route('client.children.show', $student) }}" class="group card-premium block hover:scale-[1.02]">
                <!-- Gradient Top Bar -->
                <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-5">
                        <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($student->name) . '&background=205085&color=fff&size=128' }}" 
                             class="h-16 w-16 rounded-2xl object-cover ring-2 ring-indigo-500/20 group-hover:ring-indigo-500/40 transition-all">
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $student->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $student->grade_level ?? '-' }} • {{ $student->school_name ?? '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Tanggal Lahir</span>
                            <span class="font-semibold text-gray-900">{{ $student->birth_date?->format('d M Y') ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status</span>
                            <span class="badge {{ $student->is_active ? 'badge-green' : 'badge-gray' }}">
                                {{ $student->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-sm text-gray-500">Sesi Mendatang</span>
                        <span class="text-lg font-black text-indigo-600">
                            {{ $student->schedules()->where('date', '>=', today())->where('status', 'scheduled')->count() }}
                        </span>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
    @else
    <div class="card-premium p-12">
        <div class="empty-state">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <p class="font-semibold text-gray-500">Belum ada data anak</p>
            <p class="text-sm text-gray-400">Hubungi admin untuk mendaftarkan anak Anda</p>
        </div>
    </div>
    @endif
</div>
@endsection
