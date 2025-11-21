<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pendaftar_berkas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendaftar_id')->constrained('pendaftar')->onDelete('cascade');
            $table->enum('jenis', ['IJAZAH','RAPOR','KIP','KKS','AKTA','KK','BUKTI_BAYAR','LAINNYA']);
            $table->string('nama_file', 255);
            $table->string('url', 255);
            $table->integer('ukuran_kb');
            $table->boolean('valid')->default(false);
            $table->string('catatan', 255)->nullable();
            $table->timestamps();
            
            $table->index(['pendaftar_id', 'jenis']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pendaftar_berkas');
    }
};