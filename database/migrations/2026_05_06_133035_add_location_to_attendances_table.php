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
        Schema::table('attendances', function (Blueprint $table) {
            $table->decimal('tutor_lat', 10, 8)->nullable()->after('photo_path');
            $table->decimal('tutor_lng', 11, 8)->nullable()->after('tutor_lat');
            $table->string('tutor_subdistrict')->nullable()->after('tutor_lng'); // Kecamatan dari Nominatim
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['tutor_lat', 'tutor_lng', 'tutor_subdistrict']);
        });
    }
};
