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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            
            // Check-in data
            $table->timestamp('check_in_time')->nullable();
            $table->decimal('check_in_lat', 10, 8)->nullable();
            $table->decimal('check_in_lng', 11, 8)->nullable();
            $table->string('check_in_photo')->nullable();
            
            // Check-out data
            $table->timestamp('check_out_time')->nullable();
            $table->decimal('check_out_lat', 10, 8)->nullable();
            $table->decimal('check_out_lng', 11, 8)->nullable();
            
            // Verification
            $table->boolean('location_verified')->default(false);
            $table->decimal('distance_from_target', 10, 2)->nullable(); // in meters
            $table->boolean('is_mock_location')->default(false);
            
            // Status & notes
            $table->enum('status', ['present', 'late', 'absent', 'pending'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('late_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
