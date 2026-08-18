<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('resolution_note')->nullable()->after('description');
            $table->timestamp('resolved_at')->nullable()->after('room_id');
            $table->timestamp('closed_at')->nullable()->after('resolved_at');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['resolution_note', 'resolved_at', 'closed_at']);
        });
    }
};
