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
        Schema::create('student_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            
            $table->date('assessment_date');
            $table->json('skill_areas'); // {algebra: 75, geometry: 80, calculus: 65}
            $table->integer('overall_score')->default(0); // 0-100
            $table->text('improvement_notes')->nullable();
            $table->text('recommendations')->nullable();
            $table->enum('level_achieved', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_progress');
    }
};
