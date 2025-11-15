<?php
// database/migrations/2014_10_12_000000_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 120)->unique();
            $table->string('hp', 20)->nullable();
            $table->string('password_hash');
            $table->enum('role', ['pendaftar','admin','verifikator_adm','keuangan','kepsek'])->default('pendaftar');
            $table->boolean('aktif')->default(true);
            $table->string('otp_code', 6)->nullable();
            $table->timestamp('otp_expires_at')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->rememberToken();
            $table->timestamps();
            
            $table->index(['role']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengguna');
    }
};