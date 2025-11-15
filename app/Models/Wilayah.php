<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';
    
    protected $fillable = [
        'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kodepos'
    ];

    public function dataSiswa()
    {
        return $this->hasMany(PendaftarDataSiswa::class);
    }
}