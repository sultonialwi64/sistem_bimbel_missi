@extends('layouts.app')

@section('title', 'Laporan Sesi')
@section('page-title', 'Laporan Sesi Mengajar')
@section('page-subtitle', 'Pantau laporan mengajar dan feedback dari orang tua')

@section('content')
<div class="space-y-8">
    {{-- Search/Filter Card --}}
    <div class="card-premium p-6">
        <form action="{{ route('admin.session-reports.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Tentor</label>
                <select name="tutor_id" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500">
                    <option value="">Semua Tentor</option>
                    @foreach($tutors as $tutor)
                        <option value="{{ $tutor->id }}" {{ request('tutor_id') == $tutor->id ? 'selected' : '' }}>
                            {{ $tutor->user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Murid</label>
                <select name="student_id" class="w-full rounded-xl border-gray-200 focus:ring-indigo-500">
                    <option value="">Semua Murid</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                            {{ $student->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="submit" class="w-full btn-primary-gradient text-white font-bold py-2.5 rounded-xl shadow-lg shadow-indigo-500/30">
                    Filter Laporan
                </button>
            </div>
        </form>
    </div>

    {{-- Reports List --}}
    <div class="card-premium overflow-hidden">
        <div class="bg-indigo-800 px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Daftar Laporan Sesi
            </h3>
            <span class="bg-white/20 text-white px-3 py-1 rounded-full text-xs font-bold border border-white/30 uppercase">
                Total: {{ $reports->total() }}
            </span>
        </div>

        <div class="hidden sm:block overflow-x-auto">
            <table class="table-premium">
                <thead>
                    <tr>
                        <th class="py-4 px-6 text-left">Waktu Sesi</th>
                        <th class="py-4 px-6 text-left">Tentor & Murid</th>
                        <th class="py-4 px-6 text-left">Materi</th>
                        <th class="py-4 px-6 text-left text-center">Pemahaman</th>
                        <th class="py-4 px-6 text-left">Feedback Ortu</th>
                        <th class="py-4 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-700">{{ $report->schedule->date->translatedFormat('d M Y') }}</div>
                                <div class="text-xs text-slate-400 font-semibold">{{ $report->schedule->start_time->format('H:i') }} - {{ $report->schedule->end_time->format('H:i') }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-indigo-600">{{ $report->tutor->user->name }}</span>
                                    <span class="text-xs text-slate-500">Membimbing: {{ $report->student->name }}</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="text-sm font-semibold text-slate-700">{{ $report->schedule->subject->name }}</div>
                                <div class="text-xs text-slate-500 truncate max-w-[200px]" title="{{ $report->topics_covered }}">
                                    {{ $report->topics_covered }}
                                </div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $report->student_understanding >= 4 ? 'bg-emerald-100 text-emerald-700' : ($report->student_understanding >= 3 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ $report->student_understanding }}/5
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @if($report->parent_rating)
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-3.5 w-3.5 {{ $i <= $report->parent_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="text-[10px] text-slate-500 mt-1 truncate max-w-[150px]" title="{{ $report->parent_feedback }}">
                                        {{ $report->parent_feedback }}
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 italic">Belum ada feedback</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.session-reports.show', $report->id) }}" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-indigo-600 hover:text-white rounded-lg text-xs font-bold text-slate-600 transition-all">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-semibold italic text-sm">Belum ada laporan sesi yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Mobile Cards List --}}
        <div class="sm:hidden divide-y divide-slate-100">
            @forelse($reports as $report)
                <div class="p-4 space-y-3 hover:bg-slate-50/50 transition-colors">
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <span class="text-xs font-bold text-indigo-600 block mb-0.5">{{ $report->tutor->user->name }}</span>
                            <span class="text-xs text-slate-500 font-medium">Membimbing: {{ $report->student->name }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-bold text-slate-400 block">{{ $report->schedule->date->translatedFormat('d M Y') }}</span>
                            <span class="text-[10px] text-slate-400 font-semibold">{{ $report->schedule->start_time->format('H:i') }} - {{ $report->schedule->end_time->format('H:i') }}</span>
                        </div>
                    </div>

                    <div class="bg-slate-50/70 rounded-xl p-3 space-y-2 border border-slate-100">
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Materi</div>
                            <div class="text-xs font-bold text-slate-700 mt-0.5">{{ $report->schedule->subject->name }}</div>
                            <div class="text-xs text-slate-500 mt-1 font-medium leading-relaxed">{{ $report->topics_covered }}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Pemahaman</div>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $report->student_understanding >= 4 ? 'bg-emerald-100 text-emerald-700' : ($report->student_understanding >= 3 ? 'bg-amber-100 text-amber-700' : 'bg-rose-100 text-rose-700') }}">
                                    {{ $report->student_understanding }}/5
                                </span>
                            </div>
                            <div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Feedback Ortu</div>
                                @if($report->parent_rating)
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="h-3 w-3 {{ $i <= $report->parent_rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <div class="text-[10px] text-slate-500 mt-0.5 italic leading-relaxed truncate max-w-[150px]" title="{{ $report->parent_feedback }}">
                                        "{{ $report->parent_feedback }}"
                                    </div>
                                @else
                                    <span class="text-[10px] text-slate-400 italic">Belum ada</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 pt-1">
                        <a href="{{ route('admin.session-reports.show', $report->id) }}" class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-indigo-600 hover:text-white rounded-xl text-xs font-bold text-slate-600 transition-all">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Detail Laporan
                        </a>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-slate-500">
                    <div class="flex flex-col items-center gap-3">
                        <svg class="h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="font-semibold italic text-sm">Belum ada laporan sesi yang ditemukan.</p>
                    </div>
                </div>
            @endforelse
        </div>
        
        <div class="px-6 py-4 bg-slate-50 border-t border-gray-100">
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
