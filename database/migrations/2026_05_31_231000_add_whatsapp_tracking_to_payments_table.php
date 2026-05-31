<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->timestamp('wa_sent_at')->nullable()->after('verified_by');
            $table->foreignId('wa_sent_by')->nullable()->after('wa_sent_at')->constrained('users')->onDelete('set null');
            $table->unsignedInteger('wa_sent_count')->default(0)->after('wa_sent_by');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['wa_sent_by']);
            $table->dropColumn(['wa_sent_at', 'wa_sent_by', 'wa_sent_count']);
        });
    }
};
