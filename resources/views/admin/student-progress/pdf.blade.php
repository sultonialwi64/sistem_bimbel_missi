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
        .table th, .table td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; vertical-align: top; }
        .table th { background-color: #f8fafc; font-weight: bold; color: #475569; }
        .rating { color: #eab308; font-weight: bold; }
        .summary-box { background-color: #f8fafc; border: 1px solid #e2e8f0; padding: 15px; border-radius: 5px; margin-bottom: 10px; }
        .photo-box { text-align: center; min-height: 170px; }
        .documentation-photo { max-width: 360px; max-height: 240px; border-radius: 6px; border: 1px solid #cbd5e1; }
        .photo-placeholder { height: 160px; border: 1px dashed #cbd5e1; color: #94a3b8; font-size: 11px; text-align: center; line-height: 160px; background-color: #f8fafc; }
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
                <th width="15%">Tanggal & Mapel</th>
                <th width="40%">Materi yang Diajarkan</th>
                <th width="35%">Catatan</th>
                <th width="10%">Pemahaman</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                @php
                    $report = $schedule->sessionReport;
                @endphp
                <tr>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}</strong><br>
                        {{ $schedule->subject->name ?? '-' }}
                    </td>
                    <td>{!! $report ? nl2br(e($report->material_covered)) : '&nbsp;' !!}</td>
                    <td>{!! $report && $report->notes_for_parent ? nl2br(e($report->notes_for_parent)) : '&nbsp;' !!}</td>
                    <td align="center">
                        @if($report)
                            <span class="rating">{{ $report->student_understanding }}</span> / 5
                        @else
                            &nbsp;
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Tidak ada sesi pembelajaran pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">3. DOKUMENTASI FOTO KEGIATAN</div>
    <table class="table">
        <thead>
            <tr>
                <th width="25%">Tanggal & Mapel</th>
                <th width="75%">Foto Dokumentasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                @php
                    $base64 = null;
                    if(isset($schedule->attendance) && $schedule->attendance->photo_path) {
                        $path = \Illuminate\Support\Facades\Storage::disk('public')->path($schedule->attendance->photo_path);
                        if (file_exists($path)) {
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    }
                @endphp
                <tr>
                    <td>
                        <strong>{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}</strong><br>
                        {{ $schedule->subject->name ?? '-' }}
                    </td>
                    <td class="photo-box">
                        @if($base64)
                            <img src="{{ $base64 }}" class="documentation-photo">
                        @else
                            <div class="photo-placeholder">Foto belum tersedia</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" align="center">Tidak ada dokumentasi foto pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
