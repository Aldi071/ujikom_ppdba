<?php
// app/Models/PendaftarDataSiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftarDataSiswa extends Model
{
    use HasFactory;

    protected $table = 'pendaftar_data_siswa';
    
    protected $primaryKey = 'pendaftar_id';
    
    public $incrementing = false;

    protected $fillable = [
        'pendaftar_id',
        'nik',
        'nisn',
        'nama',
        'jk',
        'tmp_lahir',
        'tgl_lahir', 
        'alamat',
        'wilayah_id',
        'lat',
        'lng'
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'lat' => 'decimal:7',
        'lng' => 'decimal:7'
    ];

    // Relationships
    public function pendaftar()
    {
        return $this->belongsTo(Pendaftar::class, 'pendaftar_id');
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }
}