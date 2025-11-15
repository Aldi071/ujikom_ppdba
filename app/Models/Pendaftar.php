<?php
// app/Models/Pendaftar.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendaftar extends Model
{
    use HasFactory;

    protected $table = 'pendaftar';
    
    protected $fillable = [
        'user_id',
        'tanggal_daftar',
        'no_pendaftaran',
        'gelombang_id',
        'jurusan_id',
        'status',
        'user_verifikasi_adm',
        'tgl_verifikasi_adm',
        'user_verifikasi_payment', 
        'tgl_verifikasi_payment'
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'tgl_verifikasi_adm' => 'datetime',
        'tgl_verifikasi_payment' => 'datetime'
    ];

    // Relationships
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    public function gelombang()
    {
        return $this->belongsTo(Gelombang::class, 'gelombang_id');
    }

    public function dataSiswa()
    {
        return $this->hasOne(PendaftarDataSiswa::class, 'pendaftar_id');
    }

    public function dataOrtu()
    {
        return $this->hasOne(PendaftarDataOrtu::class, 'pendaftar_id');
    }

    public function asalSekolah()
    {
        return $this->hasOne(PendaftarAsalSekolah::class, 'pendaftar_id');
    }

    public function berkas()
    {
        return $this->hasMany(PendaftarBerkas::class, 'pendaftar_id');
    }

    public function user()
    {
        return $this->belongsTo(Pengguna::class, 'user_id');
    }

    public function scopeSubmitted($query)
    {
        return $query->whereIn('status', ['SUBMIT', 'ADM_PASS', 'PAID', 'LULUS']);
    }
}