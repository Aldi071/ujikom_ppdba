<?php
// app/Models/PendaftarBerkas.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarBerkas extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_berkas';
    
    protected $fillable = [
        'pendaftar_id',
        'jenis',
        'nama_file',
        'url',
        'ukuran_kb',
        'valid',
        'catatan'
    ];

    protected $casts = [
        'valid' => 'boolean'
    ];

    // Relationships
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class);
    }
}