<?php
// database/seeders/GelombangSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GelombangSeeder extends Seeder
{
    public function run()
    {
        $gelombang = [
            [
                'nama' => 'Gelombang 1',
                'tahun' => 2025,
                'tgl_mulai' => '2025-01-01',
                'tgl_selesai' => '2025-06-30',
                'biaya_daftar' => 200000,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gelombang 2',
                'tahun' => 2025,
                'tgl_mulai' => '2025-07-01',
                'tgl_selesai' => '2025-12-31',
                'biaya_daftar' => 250000,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('gelombang')->insert($gelombang);
    }
}