<?php
// database/seeders/DummyDataSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\Pengguna;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // Pastikan user dengan ID 15 ada
        $user = Pengguna::find(15);
        
        if (!$user) {
            // Buat user dummy jika tidak ada
            $user = Pengguna::create([
                'nama' => 'Siswa Test',
                'email' => 'siswa@example.com',
                'hp' => '08123456789',
                'password_hash' => bcrypt('password123'),
                'role' => 'pendaftar',
                'aktif' => 1,
                'is_verified' => 1,
            ]);
        }

        $pendaftarData = [
            [
                'user_id' => $user->id,
                'tanggal_daftar' => Carbon::now()->subDays(5),
                'no_pendaftaran' => 'PDF2025001',
                'gelombang_id' => 1,
                'jurusan_id' => 1, // TKJ
                'status' => 'SUBMIT'
            ],
            [
                'user_id' => $user->id,
                'tanggal_daftar' => Carbon::now()->subDays(4),
                'no_pendaftaran' => 'PDF2025002',
                'gelombang_id' => 1,
                'jurusan_id' => 2, // RPL
                'status' => 'ADM_PASS'
            ],
            [
                'user_id' => $user->id,
                'tanggal_daftar' => Carbon::now()->subDays(3),
                'no_pendaftaran' => 'PDF2025003',
                'gelombang_id' => 1,
                'jurusan_id' => 1, // TKJ
                'status' => 'PAID'
            ],
            [
                'user_id' => $user->id,
                'tanggal_daftar' => Carbon::now()->subDays(2),
                'no_pendaftaran' => 'PDF2025004',
                'gelombang_id' => 1,
                'jurusan_id' => 3, // TEI
                'status' => 'LULUS'
            ],
            [
                'user_id' => $user->id,
                'tanggal_daftar' => Carbon::now()->subDays(1),
                'no_pendaftaran' => 'PDF2025005',
                'gelombang_id' => 2,
                'jurusan_id' => 4, // TKR
                'status' => 'SUBMIT'
            ],
        ];

        foreach ($pendaftarData as $data) {
            $pendaftar = Pendaftar::create($data);
            
            // Buat data siswa untuk setiap pendaftar
            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nik' => '123456789012345' . $pendaftar->id,
                'nisn' => '112233445' . $pendaftar->id,
                'nama' => $this->getRandomName(),
                'jk' => $pendaftar->id % 2 == 0 ? 'P' : 'L',
                'tmp_lahir' => $this->getRandomCity(),
                'tgl_lahir' => Carbon::create(2008, rand(1, 12), rand(1, 28)),
                'alamat' => 'Jl. Contoh No. ' . $pendaftar->id,
                'wilayah_id' => rand(37, 45)
            ]);
        }
    }

    private function getRandomName()
    {
        $firstNames = ['Ahmad', 'Budi', 'Rizky', 'Dewi', 'Siti', 'Nur', 'Maya', 'Fajar', 'Indra', 'Lina'];
        $lastNames = ['Fauzan', 'Santoso', 'Pratama', 'Lestari', 'Nurhaliza', 'Sari', 'Wati', 'Kusuma', 'Putra', 'Handayani'];
        
        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    private function getRandomCity()
    {
        $cities = ['Jakarta', 'Bandung', 'Semarang', 'Tangerang', 'Bekasi', 'Depok', 'Bogor', 'Surabaya', 'Malang'];
        return $cities[array_rand($cities)];
    }
}