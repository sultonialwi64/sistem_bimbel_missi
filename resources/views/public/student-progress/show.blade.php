<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Belajar {{ $student->name }} - {{ $startDate->translatedFormat('F Y') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus+jakarta+sans:400,500,600,700,800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Plus Jakarta Sans", Arial, sans-serif;
            background: #0f172a;
            color: #0f172a;
        }
        .page {
            width: min(1120px, calc(100% - 28px));
            margin: 0 auto;
            padding: 28px 0 44px;
        }
        .hero {
            border: 1px solid rgba(148, 163, 184, .28);
            border-radius: 24px;
            background: linear-gradient(135deg, #173b63 0%, #205085 56%, #7a4b35 100%);
            color: #fff;
            padding: 24px;
            box-shadow: 0 22px 60px rgba(2, 6, 23, .24);
        }
        .hero-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
        }
        .eyebrow {
            margin: 0 0 8px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: #dbeafe;
        }
        h1 {
            margin: 0;
            font-size: clamp(24px, 5vw, 38px);
            line-height: 1.15;
            letter-spacing: 0;
        }
        .hero-subtitle {
            margin: 10px 0 0;
            color: #dbeafe;
            font-size: 14px;
            line-height: 1.7;
        }
        .download {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 10px 15px;
            border-radius: 14px;
            background: #fff;
            color: #17446f;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
            box-shadow: 0 10px 24px rgba(2, 6, 23, .18);
        }
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-top: 22px;
        }
        .meta-card {
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 16px;
            background: rgba(15, 23, 42, .22);
            padding: 14px;
        }
        .meta-label {
            margin: 0 0 6px;
            color: #bfdbfe;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
        }
        .meta-value {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.45;
        }
        .section {
            margin-top: 18px;
            overflow: hidden;
            border-radius: 22px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 18px 50px rgba(2, 6, 23, .18);
        }
        .section-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .section-title {
            margin: 0;
            font-size: 18px;
            font-weight: 900;
        }
        .section-note {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }
        .summary {
            padding: 20px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(180px, 240px);
            gap: 16px;
        }
        .summary-box {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #f8fafc;
            padding: 16px;
        }
        .summary-box p {
            margin: 0;
            color: #475569;
            font-size: 14px;
            line-height: 1.75;
        }
        .score {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 140px;
            border-radius: 18px;
            background: #173b63;
            color: #fff;
        }
        .score strong {
            display: block;
            font-size: 40px;
            line-height: 1;
        }
        .score span {
            margin-top: 6px;
            color: #dbeafe;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background: #173b63;
            color: #fff;
            padding: 13px 14px;
            text-align: left;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }
        td {
            border-bottom: 1px solid #e2e8f0;
            padding: 14px;
            vertical-align: top;
            color: #334155;
            font-size: 13px;
            line-height: 1.65;
        }
        tr:last-child td { border-bottom: 0; }
        .date {
            color: #0f172a;
            font-weight: 900;
        }
        .subject {
            margin-top: 4px;
            color: #64748b;
            font-weight: 700;
        }
        .rating {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            border-radius: 999px;
            background: #fffbeb;
            color: #b45309;
            padding: 6px 10px;
            font-weight: 900;
            border: 1px solid #fde68a;
        }
        .empty-text {
            color: #94a3b8;
            font-style: italic;
        }
        .photo-table td:first-child { width: 24%; }
        .documentation-photo {
            display: block;
            width: min(520px, 100%);
            max-height: 420px;
            object-fit: contain;
            margin: 0 auto;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        .photo-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 220px;
            border-radius: 14px;
            border: 1px dashed #cbd5e1;
            background: #f8fafc;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 800;
        }
        .session-cards { display: none; }
        .footer {
            margin-top: 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            line-height: 1.6;
        }
        @media (max-width: 820px) {
            .page { width: min(100% - 20px, 1120px); padding-top: 14px; }
            .hero { padding: 18px; border-radius: 20px; }
            .download { width: 100%; }
            .meta-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .summary { grid-template-columns: 1fr; padding: 14px; }
            .section-header { padding: 16px; }
            .desktop-session-table { display: none; }
            .session-cards { display: block; }
            .session-card {
                border-bottom: 1px solid #e2e8f0;
                padding: 16px;
            }
            .session-card:last-child { border-bottom: 0; }
            .session-card-head {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
                margin-bottom: 12px;
            }
            .mobile-field {
                border-radius: 14px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                padding: 12px;
                margin-top: 10px;
            }
            .mobile-label {
                margin: 0 0 6px;
                color: #64748b;
                font-size: 11px;
                font-weight: 900;
                text-transform: uppercase;
            }
            .mobile-value {
                margin: 0;
                color: #334155;
                font-size: 13px;
                line-height: 1.7;
            }
            .photo-table { min-width: 0; }
            .photo-table thead { display: none; }
            .photo-table, .photo-table tbody, .photo-table tr, .photo-table td { display: block; width: 100%; }
            .photo-table tr { border-bottom: 1px solid #e2e8f0; }
            .photo-table td { border-bottom: 0; }
            .documentation-photo { max-height: none; }
        }
        @media (max-width: 520px) {
            .meta-grid { grid-template-columns: 1fr; }
            h1 { font-size: 25px; }
        }
    </style>
</head>
<body>
@php
    $pdfLink = URL::signedRoute('public.report.download', ['student' => $student->id, 'month' => $month]);
@endphp

<main class="page">
    <section class="hero">
        <div class="hero-top">
            <div>
                <p class="eyebrow">Laporan Progres Belajar</p>
                <h1>{{ $student->name }}</h1>
                <p class="hero-subtitle">
                    Periode {{ $startDate->translatedFormat('F Y') }}. Laporan ini dapat dibuka tanpa login melalui link resmi yang dikirim oleh Bimbel Miss I.
                </p>
            </div>
            <a href="{{ $pdfLink }}" class="download">
                <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download PDF
            </a>
        </div>

        <div class="meta-grid">
            <div class="meta-card">
                <p class="meta-label">Wali Murid</p>
                <p class="meta-value">{{ $student->client->user->name ?? '-' }}</p>
            </div>
            <div class="meta-card">
                <p class="meta-label">Kelas</p>
                <p class="meta-value">{{ $student->grade_level ?? '-' }}</p>
            </div>
            <div class="meta-card">
                <p class="meta-label">Sekolah</p>
                <p class="meta-value">{{ $student->school_name ?? '-' }}</p>
            </div>
            <div class="meta-card">
                <p class="meta-label">Jumlah Sesi</p>
                <p class="meta-value">{{ $schedules->count() }} sesi</p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Rangkuman Evaluasi Perkembangan</h2>
            <p class="section-note">Ringkasan penilaian dan rekomendasi belajar pada periode laporan ini.</p>
        </div>
        <div class="summary">
            <div class="summary-box">
                @if($progress)
                    <p><strong>Mata Pelajaran:</strong> {{ $progress->subject->name ?? '-' }}</p>
                    <p><strong>Tutor Penilai:</strong> {{ $progress->tutor->user->name ?? '-' }}</p>
                    <p><strong>Level:</strong> {{ ucfirst($progress->level_achieved ?? 'Evaluated') }}</p>
                    <p><strong>Rekomendasi:</strong><br>{{ $progress->recommendations ?? 'Tidak ada rekomendasi.' }}</p>
                @else
                    <p class="empty-text">Belum ada data evaluasi bulanan untuk periode ini.</p>
                @endif
            </div>
            <div class="score">
                <strong>{{ $progress ? $progress->overall_score : '-' }}</strong>
                <span>Nilai Rata-rata</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Rincian Kegiatan Pembelajaran</h2>
            <p class="section-note">Daftar sesi yang sudah terlaksana pada periode laporan.</p>
        </div>
        <div class="table-wrap desktop-session-table">
            <table>
                <thead>
                    <tr>
                        <th style="width: 16%;">Tanggal & Mapel</th>
                        <th style="width: 39%;">Materi yang Diajarkan</th>
                        <th style="width: 35%;">Catatan</th>
                        <th style="width: 10%;">Pemahaman</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        @php
                            $report = $schedule->sessionReport;
                        @endphp
                        <tr>
                            <td>
                                <div class="date">{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}</div>
                                <div class="subject">{{ $schedule->subject->name ?? '-' }}</div>
                            </td>
                            <td>{!! $report ? nl2br(e($report->material_covered)) : '<span class="empty-text">Laporan belum diisi.</span>' !!}</td>
                            <td>{!! $report && $report->notes_for_parent ? nl2br(e($report->notes_for_parent)) : '<span class="empty-text">Belum ada catatan.</span>' !!}</td>
                            <td>
                                @if($report)
                                    <span class="rating">{{ $report->student_understanding }} / 5</span>
                                @else
                                    <span class="empty-text">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center;">Tidak ada sesi pembelajaran pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="session-cards">
            @forelse($schedules as $schedule)
                @php
                    $report = $schedule->sessionReport;
                @endphp
                <article class="session-card">
                    <div class="session-card-head">
                        <div>
                            <div class="date">{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}</div>
                            <div class="subject">{{ $schedule->subject->name ?? '-' }}</div>
                        </div>
                        <div>
                            @if($report)
                                <span class="rating">{{ $report->student_understanding }} / 5</span>
                            @else
                                <span class="rating">-</span>
                            @endif
                        </div>
                    </div>

                    <div class="mobile-field">
                        <p class="mobile-label">Materi yang Diajarkan</p>
                        <p class="mobile-value">{!! $report ? nl2br(e($report->material_covered)) : '<span class="empty-text">Laporan belum diisi.</span>' !!}</p>
                    </div>

                    <div class="mobile-field">
                        <p class="mobile-label">Catatan</p>
                        <p class="mobile-value">{!! $report && $report->notes_for_parent ? nl2br(e($report->notes_for_parent)) : '<span class="empty-text">Belum ada catatan.</span>' !!}</p>
                    </div>
                </article>
            @empty
                <div class="session-card" style="text-align: center;">Tidak ada sesi pembelajaran pada periode ini.</div>
            @endforelse
        </div>
    </section>

    <section class="section">
        <div class="section-header">
            <h2 class="section-title">Dokumentasi Foto Kegiatan</h2>
            <p class="section-note">Foto dokumentasi sesi belajar berdasarkan tanggal dan mata pelajaran.</p>
        </div>
        <table class="photo-table">
            <thead>
                <tr>
                    <th>Tanggal & Mapel</th>
                    <th>Foto Dokumentasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($schedules as $schedule)
                    @php
                        $photoUrl = null;
                        if ($schedule->attendance?->photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($schedule->attendance->photo_path)) {
                            $photoUrl = \Illuminate\Support\Facades\Storage::url($schedule->attendance->photo_path);
                        }
                    @endphp
                    <tr>
                        <td>
                            <div class="date">{{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}</div>
                            <div class="subject">{{ $schedule->subject->name ?? '-' }}</div>
                        </td>
                        <td>
                            @if(!empty($photoUrl))
                                <img src="{{ $photoUrl }}" class="documentation-photo" alt="Dokumentasi {{ $student->name }} {{ \Carbon\Carbon::parse($schedule->date)->format('d/m/Y') }}">
                            @else
                                <div class="photo-placeholder">Foto belum tersedia</div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center;">Tidak ada dokumentasi foto pada periode ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

    <p class="footer">
        Halaman ini hanya menampilkan laporan belajar yang dikirim melalui link resmi. Orang tua tidak perlu login untuk melihat laporan ini.
    </p>
</main>
</body>
</html>
