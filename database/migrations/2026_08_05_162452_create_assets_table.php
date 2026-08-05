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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('asset_code', 50)->unique();
            $table->foreignId('asset_category_id')->constrained('asset_categories');
            $table->foreignId('room_id')->constrained('rooms');
            $table->enum('status', ['active', 'broken', 'maintenance', 'disposed'])->default('active');
            $table->date('purchase_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
