<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus kolom hourly_rate dari tabel tutors.
     * Harga per sesi kini dipukul rata dan diatur via config,
     * tidak lagi di-set per tutor.
     */
    public function up(): void
    {
        Schema::table('tutors', function (Blueprint $table) {
            if (Schema::hasColumn('tutors', 'hourly_rate')) {
                $table->dropColumn('hourly_rate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {
            $table->decimal('hourly_rate', 12, 2)->default(0)->after('session_rate');
        });
    }
};
