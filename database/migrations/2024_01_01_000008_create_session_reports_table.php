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
        Schema::create('session_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            
            $table->text('material_covered');
            $table->integer('student_understanding')->default(3); // 1-5 scale
            $table->text('homework_assigned')->nullable();
            $table->text('notes_for_parent')->nullable();
            $table->integer('tutor_rating_by_student')->nullable(); // 1-5, optional
            $table->json('skills_assessed')->nullable(); // {algebra: 75, geometry: 80}
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_reports');
    }
};
