<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Progres Siswa - {{ $student->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; color: #1e293b; margin: 0; }
        .subtitle { font-size: 14px; color: #64748b; margin: 5px 0 0 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .info-label { font-weight: bold; width: 120px; color: #475569; }
        .section-title { font-size: 14px; font-weight: bold; color: #1e293b; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; }
        .table th { background-color: #f8fafc; font-weight: bold; color: #475569; }
        .rating { color: #eab308; font-weight: bold; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 5px; margin-bottom: 10px; }
        .footer { margin-top: 50px; text-align: right; }
        .signature-line { border-top: 1px solid #333; width: 200px; display: inline-block; margin-top: 60px; text-align: center; padding-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1 class="title">LAPORAN PROGRES BELAJAR SISWA</h1>
        <p class="subtitle">Periode: {{ \Carbon\Carbon::parse($month)->translatedFormat('F Y') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td class="info-label">Nama Siswa</td>
            <td>: {{ $student->name }}</td>
            <td class="info-label">Tingkat / Kelas</td>
            <td>: {{ $student->grade_level ?? '-' }}</td>
        </tr>
        <tr>
            <td class="info-label">Nama Wali</td>
            <td>: {{ $student->client->user->name ?? '-' }}</td>
            <td class="info-label">Asal Sekolah</td>
            <td>: {{ $student->school_name ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">1. RANGKUMAN EVALUASI PERKEMBANGAN</div>
    @if($progress)
        <div class="summary-box">
            <p><strong>Mata Pelajaran:</strong> {{ $progress->subject->name ?? '-' }}</p>
            <p><strong>Tutor Penilai:</strong> {{ $progress->tutor->user->name ?? '-' }}</p>
            <p><strong>Nilai Rata-rata / Score:</strong> {{ $progress->overall_score }}/100 ({{ ucfirst($progress->level_achieved ?? 'Evaluated') }})</p>
            <p><strong>Rekomendasi untuk Siswa/Orang Tua:</strong></p>
            <p>{{ $progress->recommendations ?? 'Tidak ada rekomendasi.' }}</p>
        </div>
    @else
        <p><em>Belum ada data evaluasi bulanan untuk periode ini.</em></p>
    @endif

    <div class="section-title">2. RINCIAN KEGIATAN PEMBELAJARAN</div>
    <table class="table">
        <thead>
            <tr>
                <th width="10%">Tanggal</th>
                <th width="12%">Mata Pelajaran</th>
                <th width="25%">Materi yang Diajarkan</th>
                <th width="8%">Pemahaman</th>
                <th width="25%">Catatan</th>
                <th width="20%">Foto Kegiatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sessionReports as $report)
                <tr>
                    <td>{{ $report->created_at->format('d/m/Y') }}</td>
                    <td>{{ $report->schedule->subject->name ?? '-' }}</td>
                    <td>{{ $report->material_covered }}</td>
                    <td align="center"><span class="rating">{{ $report->student_understanding }}</span> / 5</td>
                    <td>{{ $report->notes_for_parent ?? '-' }}</td>
                    <td align="center">
                        @php
                            $base64 = null;
                            if(isset($report->schedule->attendance) && $report->schedule->attendance->photo_path) {
                                $path = \Illuminate\Support\Facades\Storage::disk('public')->path($report->schedule->attendance->photo_path);
                                if (file_exists($path)) {
                                    $type = pathinfo($path, PATHINFO_EXTENSION);
                                    $data = file_get_contents($path);
                                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                }
                            }
                        @endphp
                        @if($base64)
                            <img src="{{ $base64 }}" style="max-width: 80px; max-height: 80px; border-radius: 4px; object-fit: contain;">
                        @else
                            <span style="font-size: 10px; color: #999;">Tidak ada foto</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">Tidak ada sesi pembelajaran pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>



</body>
</html>
