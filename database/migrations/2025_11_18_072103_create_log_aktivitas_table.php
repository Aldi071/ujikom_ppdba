<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_aktivitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('pengguna')->onDelete('cascade');
            $table->string('aksi', 100);
            $table->string('objek', 100);
            $table->json('objek_data')->nullable();
            $table->dateTime('waktu');
            $table->string('ip', 45);
            $table->timestamps();
            
            $table->index(['user_id', 'waktu']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_aktivitas');
    }
};