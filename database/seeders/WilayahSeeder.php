<?php
// database/seeders/WilayahSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run()
    {
        $wilayah = [
            // Jakarta
            [
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => 'Jakarta Pusat',
                'kecamatan' => 'Gambir',
                'kelurahan' => 'Gambir',
                'kodepos' => '10110',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => 'Jakarta Pusat',
                'kecamatan' => 'Gambir',
                'kelurahan' => 'Kebon Kelapa',
                'kodepos' => '10120',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provinsi' => 'DKI Jakarta',
                'kabupaten' => 'Jakarta Pusat', 
                'kecamatan' => 'Senen',
                'kelurahan' => 'Senen',
                'kodepos' => '10410',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jawa Barat
            [
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Coblong',
                'kelurahan' => 'Dago',
                'kodepos' => '40135',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Coblong', 
                'kelurahan' => 'Lebak Siliwangi',
                'kodepos' => '40132',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provinsi' => 'Jawa Barat',
                'kabupaten' => 'Kota Bandung',
                'kecamatan' => 'Bandung Wetan',
                'kelurahan' => 'Cihapit',
                'kodepos' => '40114',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Banten
            [
                'provinsi' => 'Banten',
                'kabupaten' => 'Kota Tangerang',
                'kecamatan' => 'Tangerang',
                'kelurahan' => 'Sukarasa',
                'kodepos' => '15111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'provinsi' => 'Banten',
                'kabupaten' => 'Kota Tangerang',
                'kecamatan' => 'Ciledug',
                'kelurahan' => 'Parung Serab',
                'kodepos' => '15152',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Jawa Tengah
            [
                'provinsi' => 'Jawa Tengah',
                'kabupaten' => 'Kota Semarang',
                'kecamatan' => 'Semarang Tengah',
                'kelurahan' => 'Pekunden',
                'kodepos' => '50134',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('wilayah')->insert($wilayah);
    }
}