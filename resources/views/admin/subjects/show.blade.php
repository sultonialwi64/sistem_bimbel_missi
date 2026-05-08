@extends('layouts.app')

@section('title', 'Detail Subject - ' . $subject->name)
@section('page-title', $subject->name)
@section('page-subtitle', 'Detail mata pelajaran')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Back Button --}}
    <a href="{{ route('admin.subjects.index') }}"
       class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-amber-600 transition-colors">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Subjects
    </a>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl text-green-700 text-sm font-medium">
            <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ===== HERO HEADER CARD ===== --}}
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 via-orange-600 to-red-700 px-8 py-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">

                {{-- Left: Icon + Info --}}
                <div class="flex items-center gap-5">
                    <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center shadow-lg flex-shrink-0">
                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">{{ $subject->name }}</h1>
                        <div class="flex items-center gap-3 mt-2 flex-wrap">
                            <span class="inline-flex items-center px-3 py-1 bg-white/20 text-white rounded-full text-xs font-bold backdrop-blur-sm">
                                📚 Jenjang {{ $subject->level }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                {{ $subject->is_active
                                    ? 'bg-green-400/30 text-green-100 border border-green-300/40'
                                    : 'bg-gray-400/30 text-gray-100 border border-gray-300/40' }}">
                                {{ $subject->is_active ? '● Aktif' : '○ Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Right: Action Buttons --}}
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="{{ route('admin.subjects.edit', $subject) }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 hover:bg-white/30 text-white rounded-xl font-semibold text-sm backdrop-blur-sm transition-all border border-white/30">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                    <form action="{{ route('admin.subjects.destroy', $subject) }}" method="POST"
                          onsubmit="return confirm('Hapus mata pelajaran \'{{ $subject->name }}\'? Tindakan ini tidak bisa dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500/30 hover:bg-red-500/50 text-white rounded-xl font-semibold text-sm backdrop-blur-sm transition-all border border-red-400/40">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-3 divide-x divide-gray-100 border-t border-gray-100">
            <div class="px-6 py-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ $subject->schedules->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Total Jadwal</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-2xl font-bold text-orange-600">{{ $subject->studentProgress->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Siswa Aktif</p>
            </div>
            <div class="px-6 py-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $subject->schedules->where('status', 'completed')->count() }}</p>
                <p class="text-xs text-gray-500 mt-0.5 font-medium">Sesi Selesai</p>
            </div>
        </div>
    </div>

    {{-- ===== DESCRIPTION CARD ===== --}}
    @if($subject->description)
    <div class="card-premium p-6">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3">Deskripsi</h3>
        <p class="text-gray-700 leading-relaxed">{{ $subject->description }}</p>
    </div>
    @endif

    {{-- ===== SCHEDULES TABLE ===== --}}
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-amber-500 via-orange-600 to-red-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jadwal Menggunakan Mata Pelajaran Ini
                </h3>
                <span class="text-amber-100 text-sm font-semibold">{{ $subject->schedules->count() }} jadwal</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Siswa</th>
                        <th class="text-left py-4 px-6">Tutor</th>
                        <th class="text-left py-4 px-6">Tanggal</th>
                        <th class="text-left py-4 px-6">Waktu</th>
                        <th class="text-left py-4 px-6">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subject->schedules->sortByDesc('date')->take(10) as $schedule)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <p class="font-semibold text-gray-800 group-hover:text-amber-600 transition-colors">
                                    {{ $schedule->student->name ?? '-' }}
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600">{{ $schedule->tutor->user->name ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->date)->isoFormat('D MMM YYYY') }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                </p>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $statusMap = [
                                        'scheduled'  => ['bg-blue-50 text-blue-700 border-blue-200',   'Terjadwal'],
                                        'ongoing'    => ['bg-yellow-50 text-yellow-700 border-yellow-200', 'Berlangsung'],
                                        'completed'  => ['bg-green-50 text-green-700 border-green-200', 'Selesai'],
                                        'cancelled'  => ['bg-red-50 text-red-700 border-red-200',     'Dibatalkan'],
                                    ];
                                    [$cls, $label] = $statusMap[$schedule->status] ?? ['bg-gray-50 text-gray-700 border-gray-200', ucfirst($schedule->status)];
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $cls }}">
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-16 w-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-3">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold text-sm">Belum ada jadwal untuk mata pelajaran ini</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subject->schedules->count() > 10)
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50/50 text-center">
                <a href="{{ route('admin.schedules.index') }}"
                   class="text-sm text-amber-600 hover:text-amber-700 font-semibold">
                    Lihat semua jadwal →
                </a>
            </div>
        @endif
    </div>

    {{-- ===== STUDENT PROGRESS TABLE ===== --}}
    <div class="card-premium overflow-hidden">
        <div class="bg-gradient-to-r from-orange-500 via-red-500 to-rose-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Progress Siswa
                </h3>
                <span class="text-orange-100 text-sm font-semibold">{{ $subject->studentProgress->count() }} siswa</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Siswa</th>
                        <th class="text-left py-4 px-6">Nilai / Skor</th>
                        <th class="text-left py-4 px-6">Area Skill</th>
                        <th class="text-left py-4 px-6">Update Terakhir</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subject->studentProgress as $progress)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-gradient-to-br from-orange-400 to-red-500 flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-xs font-bold">
                                            {{ strtoupper(substr($progress->student->name ?? 'S', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800 group-hover:text-orange-600 transition-colors text-sm">
                                            {{ $progress->student->name ?? '-' }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $progress->student->grade_level ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($progress->score !== null)
                                    @php
                                        $score = $progress->score;
                                        $colorClass = $score >= 80 ? 'text-green-600' : ($score >= 60 ? 'text-yellow-600' : 'text-red-600');
                                        $bgClass = $score >= 80 ? 'from-green-50 to-emerald-50 border-green-200' : ($score >= 60 ? 'from-yellow-50 to-amber-50 border-yellow-200' : 'from-red-50 to-pink-50 border-red-200');
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-gradient-to-r border {{ $bgClass }} {{ $colorClass }}">
                                        {{ $score }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($progress->skill_areas)
                                    @php $skills = is_array($progress->skill_areas) ? $progress->skill_areas : json_decode($progress->skill_areas, true); @endphp
                                    <div class="flex flex-wrap gap-1">
                                        @foreach(array_slice((array)$skills, 0, 3) as $skill)
                                            <span class="inline-flex items-center px-2 py-0.5 bg-orange-50 text-orange-700 border border-orange-200 rounded-lg text-xs font-medium">
                                                {{ $skill }}
                                            </span>
                                        @endforeach
                                        @if(count((array)$skills) > 3)
                                            <span class="text-xs text-gray-400 font-medium">+{{ count((array)$skills) - 3 }} lagi</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <p class="text-sm text-gray-500">
                                    {{ $progress->updated_at ? $progress->updated_at->diffForHumans() : '—' }}
                                </p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="h-16 w-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-3">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-semibold text-sm">Belum ada data progress siswa</p>
                                    <p class="text-gray-400 text-xs mt-1">Progress akan muncul setelah sesi berlangsung</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
