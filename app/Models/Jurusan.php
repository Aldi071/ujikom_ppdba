<?php
// app/Models/Jurusan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';
    
    protected $fillable = [
        'kode',
        'nama', 
        'kuota',
        'deskripsi',
        'aktif'
    ];

    protected $casts = [
        'kuota' => 'integer',
        'aktif' => 'boolean'
    ];

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class, 'jurusan_id');
    }

    // Scope untuk jurusan aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }
}