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
        Schema::create('quality_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            
            // Criteria scores (1-5)
            $table->json('criteria_scores'); // {punctuality: 5, clarity: 4, engagement: 5, professionalism: 5}
            $table->integer('overall_score')->default(0); // 0-100 or 1-5
            $table->text('feedback_text')->nullable();
            $table->enum('assessed_by', ['client', 'admin', 'student'])->default('client');
            $table->foreignId('assessor_id')->constrained('users')->onDelete('cascade');
            
            // Flags
            $table->boolean('is_positive')->default(true);
            $table->boolean('requires_followup')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_assessments');
    }
};
