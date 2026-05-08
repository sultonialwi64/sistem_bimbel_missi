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
            $table->dropColumn([
                'check_in_time',
                'check_in_lat',
                'check_in_lng',
                'check_in_photo',
                'check_out_time',
                'check_out_lat',
                'check_out_lng',
                'location_verified',
                'distance_from_target',
                'is_mock_location',
                'late_reason',
                'status'
            ]);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->string('status')->default('hadir'); // hadir, libur_sakit, pindah_lokasi, batal
            $table->string('photo_path')->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->string('verification_status')->default('verified'); // verified, manual_review
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'photo_path',
                'captured_at',
                'verification_status'
            ]);
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->timestamp('check_in_time')->nullable();
            $table->decimal('check_in_lat', 10, 8)->nullable();
            $table->decimal('check_in_lng', 11, 8)->nullable();
            $table->string('check_in_photo')->nullable();
            $table->timestamp('check_out_time')->nullable();
            $table->decimal('check_out_lat', 10, 8)->nullable();
            $table->decimal('check_out_lng', 11, 8)->nullable();
            $table->boolean('location_verified')->default(false);
            $table->decimal('distance_from_target', 10, 2)->nullable();
            $table->boolean('is_mock_location')->default(false);
            $table->enum('status', ['present', 'late', 'absent', 'pending'])->default('pending');
            $table->string('late_reason')->nullable();
        });
    }
};
