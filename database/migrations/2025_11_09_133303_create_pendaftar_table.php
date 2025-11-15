<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_04_create_pendaftar_table.php
public function up()
{
    Schema::create('pendaftar', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->datetime('tanggal_daftar');
        $table->string('no_pendaftaran', 20)->unique();
        $table->foreignId('gelombang_id')->constrained('gelombang');
        $table->foreignId('jurusan_id')->constrained('jurusan');
        $table->enum('status', ['DRAFT','SUBMIT','ADM_PASS','ADM_REJECT','PAID','LULUS','TIDAK_LULUS','CADANGAN'])->default('DRAFT');
        $table->string('user_verifikasi_adm', 100)->nullable();
        $table->datetime('tgl_verifikasi_adm')->nullable();
        $table->string('user_verifikasi_payment', 100)->nullable();
        $table->datetime('tgl_verifikasi_payment')->nullable();
        $table->timestamps();
        
        $table->index(['status']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar');
    }
};
