<?php
// app/Http/Controllers/InformasiController.php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InformasiController extends Controller
{
    public function index()
    {
        try {
            // Ambil data jurusan dengan kuota
            $jurusan = Jurusan::where('aktif', true)->get();
            
            // Ambil gelombang aktif
            $gelombang = Gelombang::where('aktif', true)->get();
            
            // Hitung jumlah pendaftar per jurusan
            $pendaftarPerJurusan = Pendaftar::select('jurusan_id', \DB::raw('COUNT(*) as total'))
                ->whereIn('status', ['SUBMIT', 'ADM_PASS', 'PAID', 'LULUS'])
                ->groupBy('jurusan_id')
                ->get()
                ->keyBy('jurusan_id');
            
            // Format data kuota
            $kuotaData = [];
            $totalKuota = 0;
            $totalTerisi = 0;
            
            foreach ($jurusan as $item) {
                $terisi = $pendaftarPerJurusan->has($item->id) ? $pendaftarPerJurusan[$item->id]->total : 0;
                $sisa = $item->kuota - $terisi;
                
                $kuotaData[] = [
                    'nama' => $item->nama,
                    'kode' => $item->kode,
                    'kelas' => $this->hitungJumlahKelas($item->kuota),
                    'kuota_total' => $item->kuota,
                    'terisi' => $terisi,
                    'sisa' => $sisa,
                    'persentase' => $item->kuota > 0 ? round(($terisi / $item->kuota) * 100, 2) : 0
                ];
                
                $totalKuota += $item->kuota;
                $totalTerisi += $terisi;
            }
            
            // Tambahkan total
            $kuotaData[] = [
                'nama' => 'TOTAL',
                'kode' => 'TOTAL',
                'kelas' => $this->hitungJumlahKelas($totalKuota),
                'kuota_total' => $totalKuota,
                'terisi' => $totalTerisi,
                'sisa' => $totalKuota - $totalTerisi,
                'persentase' => $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 2) : 0,
                'is_total' => true
            ];

            return view('depan.pages.informasi', compact('kuotaData', 'gelombang'));
            
        } catch (\Exception $e) {
            Log::error('Error in InformasiController: ' . $e->getMessage());
            
            // Fallback data
            $kuotaData = $this->getFallbackKuotaData();
            $gelombang = collect();
            
            return view('depan.pages.informasi', compact('kuotaData', 'gelombang'))
                ->with('error', 'Data sedang dalam proses penyiapan.');
        }
    }
    
    private function hitungJumlahKelas($kuota)
    {
        // Asumsi 1 kelas = 36 siswa
        return ceil($kuota / 36);
    }
    
    private function getFallbackKuotaData()
    {
        return [
            [
                'nama' => 'Teknik Komputer dan Jaringan',
                'kode' => 'TKJ',
                'kelas' => 3,
                'kuota_total' => 100,
                'terisi' => 45,
                'sisa' => 55,
                'persentase' => 45
            ],
            [
                'nama' => 'Rekayasa Perangkat Lunak',
                'kode' => 'RPL',
                'kelas' => 2,
                'kuota_total' => 80,
                'terisi' => 32,
                'sisa' => 48,
                'persentase' => 40
            ],
            [
                'nama' => 'Teknik Elektronika Industri',
                'kode' => 'TEI',
                'kelas' => 1,
                'kuota_total' => 40,
                'terisi' => 18,
                'sisa' => 22,
                'persentase' => 45
            ],
            [
                'nama' => 'TOTAL',
                'kode' => 'TOTAL',
                'kelas' => 6,
                'kuota_total' => 220,
                'terisi' => 95,
                'sisa' => 125,
                'persentase' => 43.18,
                'is_total' => true
            ]
        ];
    }
    
    public function getKuotaData()
    {
        try {
            $jurusan = Jurusan::where('aktif', true)->get();
            
            $pendaftarPerJurusan = Pendaftar::select('jurusan_id', \DB::raw('COUNT(*) as total'))
                ->whereIn('status', ['SUBMIT', 'ADM_PASS', 'PAID', 'LULUS'])
                ->groupBy('jurusan_id')
                ->get()
                ->keyBy('jurusan_id');
            
            $kuotaData = [];
            $totalKuota = 0;
            $totalTerisi = 0;
            
            foreach ($jurusan as $item) {
                $terisi = $pendaftarPerJurusan->has($item->id) ? $pendaftarPerJurusan[$item->id]->total : 0;
                $sisa = $item->kuota - $terisi;
                
                $kuotaData[] = [
                    'nama' => $item->nama,
                    'kode' => $item->kode,
                    'kelas' => $this->hitungJumlahKelas($item->kuota),
                    'kuota_total' => $item->kuota,
                    'terisi' => $terisi,
                    'sisa' => $sisa,
                    'persentase' => $item->kuota > 0 ? round(($terisi / $item->kuota) * 100, 2) : 0
                ];
                
                $totalKuota += $item->kuota;
                $totalTerisi += $terisi;
            }
            
            return response()->json([
                'success' => true,
                'data' => $kuotaData,
                'total' => [
                    'kuota_total' => $totalKuota,
                    'terisi' => $totalTerisi,
                    'sisa' => $totalKuota - $totalTerisi,
                    'persentase' => $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 2) : 0
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error getting kuota data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data kuota'
            ], 500);
        }
    }
}