<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_07_create_pendaftar_asal_sekolah_table.php
public function up()
{
    Schema::create('pendaftar_asal_sekolah', function (Blueprint $table) {
        $table->foreignId('pendaftar_id')->primary()->constrained('pendaftar')->onDelete('cascade');
        $table->string('npsn', 20)->nullable();
        $table->string('nama_sekolah', 150);
        $table->string('kabupaten', 100);
        $table->decimal('nilai_rata', 5, 2)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_asal_sekolah');
    }
};
