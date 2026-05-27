@extends('layouts.app')

@section('title', 'Detail Progres - ' . $student->name)
@section('page-title', 'Detail Progres Siswa')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.student-progress.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">← Kembali ke Daftar</a>
    <div class="flex gap-2">
        <form action="{{ route('admin.student-progress.pdf', $student) }}" method="GET" class="flex gap-2">
            <input type="month" name="month" value="{{ now()->format('Y-m') }}" class="border-gray-300 rounded-lg shadow-sm text-sm" required>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Download PDF Bulanan
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Profil Siswa -->
    <div class="bg-white rounded-xl shadow p-6 border-t-4 border-indigo-600 h-fit">
        <div class="text-center mb-6">
            <div class="h-20 w-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-2xl font-black mx-auto mb-3">
                {{ substr($student->name, 0, 2) }}
            </div>
            <h3 class="text-xl font-bold text-gray-900">{{ $student->name }}</h3>
            <p class="text-sm text-gray-500">{{ $student->grade_level ?? '-' }}</p>
        </div>
        
        <div class="space-y-4 border-t pt-4">
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Nama Wali (Client)</p>
                <p class="text-sm font-medium text-gray-900">{{ $student->client->user->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Kontak Wali</p>
                <p class="text-sm font-medium text-gray-900">{{ $student->client->user->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase font-semibold">Asal Sekolah</p>
                <p class="text-sm font-medium text-gray-900">{{ $student->school_name ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Rangkuman Progres Bulanan -->
    <div class="col-span-2 space-y-6">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-200 px-6 py-4 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Evaluasi Periodik (Bulanan)</h3>
            </div>
            <div class="p-6">
                @if($progresses->count() > 0)
                    <div class="space-y-6">
                        @foreach($progresses as $prog)
                            <div class="border rounded-lg p-4 {{ $loop->first ? 'border-indigo-200 bg-indigo-50/30' : 'border-gray-200' }}">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h4 class="font-bold text-gray-900">{{ $prog->subject->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $prog->assessment_date->format('d M Y') }} • Dinilai oleh {{ $prog->tutor->user->name }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-2xl font-black text-indigo-600">{{ $prog->overall_score }}</span><span class="text-sm text-gray-500">/100</span>
                                        <div class="mt-1">
                                            <span class="px-2 py-1 text-[10px] rounded-full font-bold text-white {{ $prog->level_badge_color }} uppercase">
                                                {{ $prog->level_achieved ?? 'Evaluated' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-4">
                                    <div class="bg-white p-3 rounded border border-gray-100 shadow-sm">
                                        <p class="text-xs font-bold text-gray-500 uppercase mb-1">Catatan Perkembangan</p>
                                        <p class="text-sm text-gray-700">{{ $prog->improvement_notes ?? '-' }}</p>
                                    </div>
                                    <div class="bg-white p-3 rounded border border-gray-100 shadow-sm">
                                        <p class="text-xs font-bold text-gray-500 uppercase mb-1">Rekomendasi</p>
                                        <p class="text-sm text-gray-700">{{ $prog->recommendations ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <p>Belum ada evaluasi bulanan yang diinput oleh Tutor.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Histori Progres Per Sesi -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="bg-slate-50 border-b border-gray-200 px-6 py-4">
                <h3 class="font-bold text-gray-800">Laporan Progres Per Sesi</h3>
            </div>
            <div class="p-0">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Mata Pelajaran</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Materi & Pemahaman</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan Tutor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($sessionReports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 align-top">
                                <div class="text-sm font-bold text-gray-900">{{ $report->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $report->schedule->subject->name ?? '-' }}</div>
                                <div class="text-[10px] text-indigo-600 mt-1">oleh {{ $report->tutor->user->name }}</div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="text-sm text-gray-900 mb-2"><strong>Materi:</strong><br>{!! nl2br(e($report->material_covered)) !!}</div>
                                <div class="flex items-center gap-1">
                                    <span class="text-xs text-gray-500">Pemahaman:</span>
                                    <div class="flex text-yellow-400">
                                        @for($i=1; $i<=5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= $report->student_understanding ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        @endfor
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 align-top">
                                {!! nl2br(e($report->notes_for_parent ?? 'Tidak ada catatan')) !!}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Belum ada laporan sesi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($sessionReports->hasPages())
                    <div class="p-4 border-t">
                        {{ $sessionReports->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
