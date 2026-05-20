@extends('layouts.app')

@section('title', 'Laporan Progres Siswa')
@section('page-title', 'Laporan Progres Siswa')
@section('page-subtitle', 'Pantau perkembangan belajar seluruh siswa')

@section('content')
<div class="space-y-6">

    <div class="card-premium overflow-hidden">
        {{-- Header --}}
        <div class="bg-indigo-800 px-6 py-4">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                    <svg class="h-5 w-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Laporan Progres Siswa
                </h3>

                {{-- Search Form --}}
                <form action="{{ route('admin.student-progress.index') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari siswa atau wali..."
                        class="rounded-xl border-none bg-indigo-900 text-white placeholder-indigo-400 text-sm focus:ring-2 focus:ring-blue-400 py-2 px-3 flex-1 sm:w-52"
                    >
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-xl text-sm font-bold transition-colors whitespace-nowrap">
                        Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.student-progress.index') }}" class="text-indigo-200 hover:text-white text-xs font-bold underline whitespace-nowrap">Hapus</a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Desktop Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="text-left py-4 px-6">Nama Siswa</th>
                        <th class="text-left py-4 px-6">Wali (Klien)</th>
                        <th class="text-left py-4 px-6">Kelas</th>
                        <th class="text-left py-4 px-6">Update Terakhir</th>
                        <th class="text-left py-4 px-6">Status Progres</th>
                        <th class="text-right py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr class="group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-xl bg-indigo-700 flex items-center justify-center shadow-lg flex-shrink-0">
                                        <span class="text-white font-bold text-xs">{{ substr($student->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $student->school_name ?? 'Sekolah tidak dicatat' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <p class="font-medium text-gray-900">{{ $student->client->user->name ?? '-' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $grade = $student->grade_level ?? null;
                                    $gradeColor = match($grade) {
                                        'SD'  => 'bg-sky-100 text-sky-700 border-sky-200',
                                        'SMP' => 'bg-violet-100 text-violet-700 border-violet-200',
                                        'SMA' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        default => 'bg-gray-100 text-gray-600 border-gray-200',
                                    };
                                @endphp
                                @if($grade)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold border {{ $gradeColor }}">
                                        {{ $grade }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($student->latestProgress)
                                    <p class="text-sm font-medium text-gray-900">{{ $student->latestProgress->assessment_date->format('d M Y') }}</p>
                                    <p class="text-xs text-indigo-500">oleh {{ $student->latestProgress->tutor->user->name ?? '-' }}</p>
                                @else
                                    <span class="text-sm text-gray-400 italic">Belum ada laporan</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($student->latestProgress)
                                    @php
                                        $trend = $student->latestProgress->trend;
                                        [$trendColor, $trendIcon, $trendLabel] = match($trend) {
                                            'improving' => ['bg-emerald-50 text-emerald-700 border-emerald-200', '📈', 'Meningkat'],
                                            'declining' => ['bg-red-50 text-red-700 border-red-200',           '📉', 'Menurun'],
                                            'stable'    => ['bg-amber-50 text-amber-700 border-amber-200',     '➡️', 'Stabil'],
                                            'new'       => ['bg-blue-50 text-blue-700 border-blue-200',          '✨', 'Baru'],
                                            default     => ['bg-gray-50 text-gray-600 border-gray-200',        '❓', ucfirst($trend)],
                                        };
                                    @endphp
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold border {{ $trendColor }}">
                                        {{ $trendIcon }} {{ $trendLabel }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.student-progress.show', $student) }}"
                                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold text-xs hover:bg-indigo-700 shadow-sm hover:shadow-md transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat & Unduh
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <p class="text-gray-500 font-semibold">Belum ada data siswa</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Card List --}}
        <div class="sm:hidden p-4 space-y-3">
            @forelse($students as $student)
                @php
                    $grade = $student->grade_level ?? null;
                    $gradeColor = match($grade) {
                        'SD'  => 'bg-sky-100 text-sky-700',
                        'SMP' => 'bg-violet-100 text-violet-700',
                        'SMA' => 'bg-rose-100 text-rose-700',
                        default => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <div class="bg-white border border-slate-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-11 w-11 rounded-xl bg-indigo-700 flex items-center justify-center shadow-md flex-shrink-0">
                            <span class="text-white font-bold text-sm">{{ substr($student->name, 0, 2) }}</span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <p class="font-bold text-gray-900 text-sm">{{ $student->name }}</p>
                                    <p class="text-xs text-gray-500 truncate">{{ $student->school_name ?? '-' }}</p>
                                </div>
                                @if($grade)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-bold flex-shrink-0 {{ $gradeColor }}">
                                        {{ $grade }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mb-3 text-xs">
                        <div class="bg-gray-50 rounded-xl p-2">
                            <p class="text-gray-400 font-semibold text-[10px] uppercase">Wali / Ortu</p>
                            <p class="text-gray-800 font-semibold truncate">{{ $student->client->user->name ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-2">
                            <p class="text-gray-400 font-semibold text-[10px] uppercase">Update Terakhir</p>
                            @if($student->latestProgress)
                                <p class="text-gray-800 font-semibold text-[11px]">{{ $student->latestProgress->assessment_date->format('d M Y') }}</p>
                            @else
                                <p class="text-gray-400 italic text-[11px]">Belum ada</p>
                            @endif
                        </div>
                    </div>

                    {{-- Progress Status --}}
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-[10px] text-gray-400 font-semibold uppercase">Status Progres</span>
                        @if($student->latestProgress)
                            @php
                                $trend = $student->latestProgress->trend;
                                [$trendColor, $trendIcon, $trendLabel] = match($trend) {
                                    'improving' => ['bg-emerald-50 text-emerald-700 border border-emerald-200', '📈', 'Meningkat'],
                                    'declining' => ['bg-red-50 text-red-700 border border-red-200',           '📉', 'Menurun'],
                                    'stable'    => ['bg-amber-50 text-amber-700 border border-amber-200',     '➡️', 'Stabil'],
                                    'new'       => ['bg-blue-50 text-blue-700 border border-blue-200',        '✨', 'Baru'],
                                    default     => ['bg-gray-50 text-gray-600 border border-gray-200',        '❓', ucfirst($trend)],
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold {{ $trendColor }}">
                                {{ $trendIcon }} {{ $trendLabel }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs italic">-</span>
                        @endif
                    </div>

                    <a href="{{ route('admin.student-progress.show', $student) }}"
                       class="w-full inline-flex items-center justify-center gap-1.5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-xs hover:bg-indigo-700 transition-all">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Lihat Laporan & Unduh PDF
                    </a>
                </div>
            @empty
                <div class="text-center py-12">
                    <p class="text-gray-500 font-semibold">Belum ada data siswa</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($students->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $students->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
