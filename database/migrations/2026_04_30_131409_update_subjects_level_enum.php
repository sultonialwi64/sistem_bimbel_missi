<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Mengubah kolom level dari ENUM sempit ke VARCHAR
     * agar mendukung jenjang baru: PAUD, Semua Jenjang, Non-Akademik
     */
    public function up(): void
    {
        // MySQL: ubah ENUM ke VARCHAR agar lebih fleksibel
        DB::statement("ALTER TABLE subjects MODIFY COLUMN level VARCHAR(20) NOT NULL DEFAULT 'SD'");
    }

    public function down(): void
    {
        // Kembalikan ke ENUM (SD, SMP, SMA) — data lain akan fallback ke 'SMP'
        DB::statement("UPDATE subjects SET level = 'SMP' WHERE level NOT IN ('SD','SMP','SMA')");
        DB::statement("ALTER TABLE subjects MODIFY COLUMN level ENUM('SD','SMP','SMA') NOT NULL DEFAULT 'SMP'");
    }
};
