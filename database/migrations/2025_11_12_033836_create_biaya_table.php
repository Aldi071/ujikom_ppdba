<?php
// database/migrations/2025_11_12_000000_create_biaya_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biaya', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama', 100);
            $table->text('deskripsi')->nullable();
            $table->decimal('jumlah', 12, 2);
            $table->enum('jenis', ['TUNAI', 'TRANSFER'])->default('TUNAI');
            $table->enum('kategori', ['DAFTAR', 'PANGKAL', 'SPP', 'LAINNYA'])->default('LAINNYA');
            $table->boolean('wajib')->default(true);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biaya');
    }
};