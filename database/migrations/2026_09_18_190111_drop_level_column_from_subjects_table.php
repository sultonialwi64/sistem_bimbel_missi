<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Data Migration: Pastikan tidak ada data jenjang yang hilang
        $subjects = \Illuminate\Support\Facades\DB::table('subjects')
            ->whereNotNull('level')
            ->whereNull('grade_level_id')
            ->get();

        foreach ($subjects as $subject) {
            // Cari atau buat Grade Level baru jika belum ada
            $gl = \Illuminate\Support\Facades\DB::table('grade_levels')->where('name', $subject->level)->first();
            if (!$gl) {
                $glId = \Illuminate\Support\Facades\DB::table('grade_levels')->insertGetId([
                    'name' => $subject->level,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $glId = $gl->id;
            }
            // Update subject
            \Illuminate\Support\Facades\DB::table('subjects')->where('id', $subject->id)->update(['grade_level_id' => $glId]);
        }

        // 2. Schema Migration: Hapus kolom level
        Schema::table('subjects', function (Blueprint $table) {
            if (Schema::hasColumn('subjects', 'level')) {
                $table->dropColumn('level');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            if (!Schema::hasColumn('subjects', 'level')) {
                $table->string('level')->nullable()->after('grade_level_id');
            }
        });
    }
};
