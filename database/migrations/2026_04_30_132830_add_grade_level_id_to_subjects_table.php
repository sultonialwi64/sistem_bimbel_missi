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
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('grade_level_id')->nullable()->after('description')->constrained('grade_levels')->onDelete('cascade');
        });
        
        // Catatan: Kolom 'level' lama akan dihapus setelah kita memindahkan datanya via seeder/script
        // Untuk sekarang kita biarkan dulu agar tidak kehilangan data saat migrate
    }

    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('grade_level_id');
        });
    }
};
