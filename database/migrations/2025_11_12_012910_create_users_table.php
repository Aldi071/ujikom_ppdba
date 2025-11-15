<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Data dasar user
            $table->string('name');
            $table->string('email')->unique();

            // Verifikasi email
            $table->timestamp('email_verified_at')->nullable();

            // Password hash
            $table->string('password');

            // Optional: nomor HP (kalau mau)
            $table->string('phone')->nullable();

            // Role / level pengguna (admin, user, dll)
            $table->string('role')->default('user');

            // Status aktif
            $table->boolean('is_active')->default(true);

            // Token untuk "remember me"
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
