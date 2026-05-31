<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicateScheduleIds = DB::table('session_reports')
            ->select('schedule_id')
            ->groupBy('schedule_id')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('schedule_id');

        foreach ($duplicateScheduleIds as $scheduleId) {
            $keepId = DB::table('session_reports')
                ->where('schedule_id', $scheduleId)
                ->orderBy('created_at')
                ->orderBy('id')
                ->value('id');

            DB::table('session_reports')
                ->where('schedule_id', $scheduleId)
                ->where('id', '!=', $keepId)
                ->delete();
        }

        Schema::table('session_reports', function (Blueprint $table) {
            $table->unique('schedule_id', 'session_reports_schedule_id_unique');
        });
    }

    public function down(): void
    {
        Schema::table('session_reports', function (Blueprint $table) {
            $table->dropUnique('session_reports_schedule_id_unique');
        });
    }
};
