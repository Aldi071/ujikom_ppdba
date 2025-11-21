<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wilayah;

class WilayahIndonesiaSeeder extends Seeder
{
    public function run()
    {
        $wilayahData = [
            // Jawa Barat
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Bandung', 'kecamatan' => 'Coblong', 'kelurahan' => 'Dago', 'kodepos' => '40135'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Bandung', 'kecamatan' => 'Coblong', 'kelurahan' => 'Lebak Gede', 'kodepos' => '40132'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Bandung', 'kecamatan' => 'Cidadap', 'kelurahan' => 'Hegarmanah', 'kodepos' => '40141'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Sumedang', 'kecamatan' => 'Sumedang Utara', 'kelurahan' => 'Kotakaler', 'kodepos' => '45311'],
            ['provinsi' => 'Jawa Barat', 'kabupaten' => 'Sumedang', 'kecamatan' => 'Sumedang Selatan', 'kelurahan' => 'Regol Wetan', 'kodepos' => '45326'],
            
            // DKI Jakarta
            ['provinsi' => 'DKI Jakarta', 'kabupaten' => 'Jakarta Pusat', 'kecamatan' => 'Menteng', 'kelurahan' => 'Gondangdia', 'kodepos' => '10350'],
            ['provinsi' => 'DKI Jakarta', 'kabupaten' => 'Jakarta Pusat', 'kecamatan' => 'Gambir', 'kelurahan' => 'Kebon Kelapa', 'kodepos' => '10120'],
            ['provinsi' => 'DKI Jakarta', 'kabupaten' => 'Jakarta Selatan', 'kecamatan' => 'Kebayoran Baru', 'kelurahan' => 'Senayan', 'kodepos' => '12190'],
            
            // Jawa Tengah
            ['provinsi' => 'Jawa Tengah', 'kabupaten' => 'Semarang', 'kecamatan' => 'Semarang Tengah', 'kelurahan' => 'Kauman', 'kodepos' => '50241'],
            ['provinsi' => 'Jawa Tengah', 'kabupaten' => 'Solo', 'kecamatan' => 'Laweyan', 'kelurahan' => 'Bumi', 'kodepos' => '57142'],
            
            // Banten
            ['provinsi' => 'Banten', 'kabupaten' => 'Tangerang', 'kecamatan' => 'Tangerang', 'kelurahan' => 'Sukasari', 'kodepos' => '15118'],
            ['provinsi' => 'Banten', 'kabupaten' => 'Serang', 'kecamatan' => 'Serang', 'kelurahan' => 'Serang Kota', 'kodepos' => '42111'],
        ];

        foreach ($wilayahData as $data) {
            Wilayah::create($data);
        }
    }
}