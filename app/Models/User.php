<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    // Relationships
    public function pendaftar()
    {
        return $this->hasOne(Pendaftar::class);
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class);
    }
}