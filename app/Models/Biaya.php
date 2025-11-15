<?php
// app/Models/Biaya.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Biaya extends Model
{
    use HasFactory;

    protected $table = 'biaya';
    
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'jumlah',
        'jenis',
        'kategori',
        'wajib',
        'aktif',
    ];

    protected $casts = [
        'jumlah' => 'decimal:2',
        'wajib' => 'boolean',
        'aktif' => 'boolean',
    ];

    // Scope untuk biaya aktif
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    // Scope untuk biaya wajib
    public function scopeWajib($query)
    {
        return $query->where('wajib', true);
    }

    // Accessor untuk format jumlah
    public function getJumlahFormattedAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    // Accessor untuk status
    public function getStatusAttribute()
    {
        return $this->aktif ? 'Aktif' : 'Non-Aktif';
    }
}