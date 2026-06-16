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
        Schema::table('tutors', function (Blueprint $table) {
            $table->boolean('is_featured_on_landing')->default(false)->after('status');
            $table->unsignedTinyInteger('landing_feature_order')->nullable()->after('is_featured_on_landing');
            $table->unsignedTinyInteger('teaching_experience_years')->nullable()->after('education');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tutors', function (Blueprint $table) {
            $table->dropColumn([
                'is_featured_on_landing',
                'landing_feature_order',
                'teaching_experience_years',
            ]);
        });
    }
};
