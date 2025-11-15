<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2024_01_05_create_pendaftar_data_siswa_table.php
public function up()
{
    Schema::create('pendaftar_data_siswa', function (Blueprint $table) {
        $table->foreignId('pendaftar_id')->primary()->constrained('pendaftar')->onDelete('cascade');
        $table->string('nik', 20)->nullable();
        $table->string('nisn', 20)->nullable();
        $table->string('nama', 120);
        $table->enum('jk', ['L','P']);
        $table->string('tmp_lahir', 60);
        $table->date('tgl_lahir');
        $table->text('alamat');
        $table->foreignId('wilayah_id')->constrained('wilayah');
        $table->decimal('lat', 10, 7)->nullable();
        $table->decimal('lng', 10, 7)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftar_data_siswa');
    }
};
