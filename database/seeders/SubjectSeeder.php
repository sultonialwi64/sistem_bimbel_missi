<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Program kelas dari Missi Private Course (Wonosobo-Magelang-Purwokerto)
     * Sumber: Foto pricelist & program yang dikirimkan.
     *
     * Target usia: 2 Tahun - Dewasa
     * Format: Private Class - Home Visit
     * Paket Bulanan  : Rp 200.000 / 4 sesi (1x seminggu)
     * Paket Hemat    : Rp 380.000 / 8 sesi (2x seminggu)
     * Durasi per sesi: 60–90 menit
     */
    public function run(): void
    {
        // Reset subjects lama — disable FK check sementara agar bisa truncate
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Subject::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $subjects = [
            // ── 1. Calistung ───────────────────────────────────────────────
            [
                'name'        => 'Calistung (Baca Tulis Hitung)',
                'description' => 'Program membaca, menulis, dan berhitung dasar untuk anak usia dini hingga kelas awal SD. Metode bermain sambil belajar agar anak tidak bosan.',
                'level'       => 'PAUD',
                'is_active'   => true,
            ],

            // ── 2. Bahasa Inggris ──────────────────────────────────────────
            [
                'name'        => 'Bahasa Inggris',
                'description' => 'Les Bahasa Inggris privat untuk semua jenjang. Meliputi grammar, reading, writing, speaking, dan persiapan ujian (TOEFL/IELTS/Cambridge).',
                'level'       => 'SD',
                'is_active'   => true,
            ],
            [
                'name'        => 'Bahasa Inggris',
                'description' => 'Les Bahasa Inggris privat untuk SMP. Fokus pada speaking, listening, dan persiapan ujian nasional.',
                'level'       => 'SMP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Bahasa Inggris',
                'description' => 'Les Bahasa Inggris privat untuk SMA. Fokus pada persiapan ujian TOEFL, IELTS, dan ujian masuk universitas.',
                'level'       => 'SMA',
                'is_active'   => true,
            ],

            // ── 3. Matematika ──────────────────────────────────────────────
            [
                'name'        => 'Matematika',
                'description' => 'Les Matematika privat untuk SD. Dasar-dasar operasi hitung, pecahan, dan pengenalan konsep geometri dengan metode yang menyenangkan.',
                'level'       => 'SD',
                'is_active'   => true,
            ],
            [
                'name'        => 'Matematika',
                'description' => 'Les Matematika privat untuk SMP. Mencakup aljabar, geometri, statistika, dan persiapan ujian sekolah.',
                'level'       => 'SMP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Matematika',
                'description' => 'Les Matematika privat untuk SMA. Meliputi trigonometri, kalkulus dasar, statistika, dan persiapan UTBK/SNBT.',
                'level'       => 'SMA',
                'is_active'   => true,
            ],

            // ── 4. Semua Mapel & Persiapan Tes ────────────────────────────
            [
                'name'        => 'Semua Mapel & Persiapan Tes (SD)',
                'description' => 'Bimbingan semua mata pelajaran SD: Matematika, IPA, IPS, Bahasa Indonesia, dan persiapan ujian sekolah.',
                'level'       => 'SD',
                'is_active'   => true,
            ],
            [
                'name'        => 'Semua Mapel & Persiapan Tes (SMP)',
                'description' => 'Bimbingan semua mata pelajaran SMP dan persiapan Ujian Nasional / Ujian Sekolah.',
                'level'       => 'SMP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Semua Mapel & Persiapan Tes (SMA)',
                'description' => 'Bimbingan semua mata pelajaran SMA dan persiapan UTBK, SNBT, serta tes masuk PTN/PTS.',
                'level'       => 'SMA',
                'is_active'   => true,
            ],

            // ── 5. Mengaji ─────────────────────────────────────────────────
            [
                'name'        => 'Mengaji (Al-Qur\'an)',
                'description' => 'Program belajar membaca Al-Qur\'an dengan tartil dan tajwid yang benar. Untuk anak usia dini hingga dewasa, semua level (Iqro hingga Al-Qur\'an).',
                'level'       => 'PAUD',
                'is_active'   => true,
            ],

            // ── 6. Berenang ────────────────────────────────────────────────
            [
                'name'        => 'Berenang',
                'description' => 'Les renang privat di rumah / kolam renang terdekat. Program untuk pemula (pengenalan air) hingga mahir. Cocok untuk anak dan dewasa.',
                'level'       => 'SD',
                'is_active'   => true,
            ],

            // ── 7. Skill & Kreatifitas ─────────────────────────────────────
            [
                'name'        => 'Skill & Kreatifitas (Mewarnai, Menggambar & Crafting)',
                'description' => 'Program mengembangkan kreativitas anak melalui mewarnai, menggambar, dan kerajinan tangan (crafting). Menggunakan LKPD & Interactive Activity Kit.',
                'level'       => 'PAUD',
                'is_active'   => true,
            ],

            // ── 8. Online Class ────────────────────────────────────────────
            [
                'name'        => 'Online Class',
                'description' => 'Les privat secara daring via Zoom / Google Meet. Tersedia untuk semua mata pelajaran dan semua jenjang. Fleksibel waktu dan lokasi.',
                'level'       => 'SD',
                'is_active'   => true,
            ],
            [
                'name'        => 'Online Class',
                'description' => 'Les privat online untuk SMP. Via Zoom/Google Meet, semua mata pelajaran, jadwal fleksibel.',
                'level'       => 'SMP',
                'is_active'   => true,
            ],
            [
                'name'        => 'Online Class',
                'description' => 'Les privat online untuk SMA/dewasa. Via Zoom/Google Meet, semua mata pelajaran, termasuk persiapan UTBK dan tes profesi.',
                'level'       => 'SMA',
                'is_active'   => true,
            ],

            // ── 9. Others Package ──────────────────────────────────────────
            [
                'name'        => 'Others Package (Speaking Events & Lainnya)',
                'description' => 'Paket khusus untuk kebutuhan lain: pelatihan public speaking, persiapan event, debate club, story telling, dan program khusus lainnya. Bisa dikustomisasi.',
                'level'       => 'SMA',
                'is_active'   => true,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        $this->command->info('✅ SubjectSeeder selesai! ' . count($subjects) . ' program berhasil ditambahkan.');
        $this->command->info('   Program: Calistung, Bahasa Inggris (SD/SMP/SMA), Matematika (SD/SMP/SMA),');
        $this->command->info('   Semua Mapel (SD/SMP/SMA), Mengaji, Berenang, Skill & Kreatifitas,');
        $this->command->info('   Online Class (SD/SMP/SMA), Others Package');
    }
}
