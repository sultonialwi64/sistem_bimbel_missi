<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus kolom-kolom dan tabel yang sudah tidak dipakai
     * dalam sistem bimbel.
     */
    public function up(): void
    {
        // 1. Drop tabel quality_assessments jika masih ada
        Schema::dropIfExists('quality_assessments');

        // 2. Hapus kolom tidak terpakai di session_reports
        //    (homework_assigned sudah dihapus dari semua view, skills_assessed tidak pernah diimplementasikan)
        Schema::table('session_reports', function (Blueprint $table) {
            if (Schema::hasColumn('session_reports', 'homework_assigned')) {
                $table->dropColumn('homework_assigned');
            }
            if (Schema::hasColumn('session_reports', 'skills_assessed')) {
                $table->dropColumn('skills_assessed');
            }
        });

        // CATATAN: kolom tutors.hourly_rate, rating_avg, total_sessions TIDAK dihapus
        // karena masih aktif dipakai oleh TutorController, DashboardController, dan berbagai views.
    }

    /**
     * Rollback — kembalikan semua kolom jika migration di-reverse.
     */
    public function down(): void
    {
        // Buat ulang tabel quality_assessments
        Schema::create('quality_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->json('criteria_scores');
            $table->integer('overall_score')->default(0);
            $table->text('feedback_text')->nullable();
            $table->enum('assessed_by', ['client', 'admin', 'student'])->default('client');
            $table->foreignId('assessor_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_positive')->default(true);
            $table->boolean('requires_followup')->default(false);
            $table->timestamps();
        });

        // Kembalikan kolom session_reports
        Schema::table('session_reports', function (Blueprint $table) {
            $table->text('homework_assigned')->nullable();
            $table->json('skills_assessed')->nullable();
        });

        // Kembalikan kolom GPS attendances
        Schema::table('attendances', function (Blueprint $table) {
            $table->decimal('check_in_lat', 10, 8)->nullable();
            $table->decimal('check_in_lng', 11, 8)->nullable();
            $table->decimal('check_out_lat', 10, 8)->nullable();
            $table->decimal('check_out_lng', 11, 8)->nullable();
            $table->boolean('location_verified')->default(false);
            $table->decimal('distance_from_target', 10, 2)->nullable();
            $table->boolean('is_mock_location')->default(false);
        });

        // Kembalikan kolom tutors
        Schema::table('tutors', function (Blueprint $table) {
            $table->decimal('hourly_rate', 12, 2)->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('total_sessions')->default(0);
        });
    }
};
