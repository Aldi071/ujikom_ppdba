<?php
// app/Models/Gelombang.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gelombang extends Model
{
    use HasFactory;

    protected $table = 'gelombang';
    
    protected $fillable = [
        'nama',
        'tahun',
        'tgl_mulai',
        'tgl_selesai',
        'biaya_daftar',
        'aktif'
    ];

    protected $casts = [
        'tgl_mulai' => 'date',
        'tgl_selesai' => 'date',
        'biaya_daftar' => 'decimal:2',
        'tahun' => 'integer',
        'aktif' => 'boolean'
    ];

    public function pendaftars()
    {
        return $this->hasMany(Pendaftar::class);
    }

    // Scope untuk gelombang aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Method untuk cek apakah ada gelombang aktif
    public static function isActive()
    {
        return self::where('aktif', true)
                   ->where('tgl_mulai', '<=', now())
                   ->where('tgl_selesai', '>=', now())
                   ->exists();
    }
}