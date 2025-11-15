<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_09_create_log_aktivitas_table.php
public function up()
{
    Schema::create('log_aktivitas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('aksi', 100);
        $table->string('objek', 100);
        $table->json('objek_data')->nullable();
        $table->datetime('waktu');
        $table->string('ip', 45);
        $table->timestamps();
        
        $table->index(['user_id', 'waktu']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aktivitas');
    }
};
