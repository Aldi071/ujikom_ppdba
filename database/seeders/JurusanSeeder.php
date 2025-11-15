<?php
// database/seeders/JurusanSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JurusanSeeder extends Seeder
{
    public function run()
    {
        $jurusan = [
            [
                'kode' => 'TKJ',
                'nama' => 'Teknik Komputer dan Jaringan',
                'kuota' => 100,
                'deskripsi' => 'Jurusan yang mempelajari tentang jaringan komputer, server, dan sistem keamanan jaringan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
                'kuota' => 80,
                'deskripsi' => 'Jurusan yang mempelajari tentang pengembangan software dan pemrograman',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TEI',
                'nama' => 'Teknik Elektronika Industri',
                'kuota' => 60,
                'deskripsi' => 'Jurusan yang mempelajari tentang sistem kontrol dan elektronika industri',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TKR',
                'nama' => 'Teknik Kendaraan Ringan',
                'kuota' => 70,
                'deskripsi' => 'Jurusan yang mempelajari tentang perbaikan dan perawatan kendaraan ringan',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kode' => 'TBSM',
                'nama' => 'Teknik Bisnis Sepeda Motor',
                'kuota' => 50,
                'deskripsi' => 'Jurusan yang mempelajari tentang bisnis dan perbaikan sepeda motor',
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jurusan')->insert($jurusan);
    }
}