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
        // Clear existing data
        DB::table('gelombang')->truncate();
        
        $gelombang = [
            [
                'nama' => 'Gelombang 1 - SPMB 2025',
                'tahun' => 2025,
                'tgl_mulai' => '2025-06-15', // Future date for countdown
                'tgl_selesai' => '2025-07-15',
                'biaya_daftar' => 200000,
                'aktif' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Gelombang 2 - SPMB 2025',
                'tahun' => 2025,
                'tgl_mulai' => '2025-08-01',
                'tgl_selesai' => '2025-09-01',
                'biaya_daftar' => 250000,
                'aktif' => false, // Not active yet
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('gelombang')->insert($gelombang);
    }
}