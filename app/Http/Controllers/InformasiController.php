<?php
// app/Http/Controllers/InformasiController.php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class InformasiController extends Controller
{
    public function index()
    {
        try {
            // Ambil data jurusan dengan kuota
            $jurusan = Jurusan::where('aktif', true)->get();
            
            // Hitung jumlah pendaftar per jurusan
            $pendaftarPerJurusan = Pendaftar::select('jurusan_id', DB::raw('COUNT(*) as total'))
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
            $totalData = [
                'nama' => 'TOTAL',
                'kode' => 'TOTAL',
                'kelas' => $this->hitungJumlahKelas($totalKuota),
                'kuota_total' => $totalKuota,
                'terisi' => $totalTerisi,
                'sisa' => $totalKuota - $totalTerisi,
                'persentase' => $totalKuota > 0 ? round(($totalTerisi / $totalKuota) * 100, 2) : 0,
                'is_total' => true
            ];

            // Ambil gelombang aktif yang paling relevan
            $now = now();
            $gelombang = Gelombang::where('aktif', true)
                ->where(function($query) use ($now) {
                    $query->where('tgl_mulai', '<=', $now)
                          ->where('tgl_selesai', '>=', $now);
                })
                ->orWhere(function($query) use ($now) {
                    $query->where('aktif', true)
                          ->where('tgl_mulai', '>', $now);
                })
                ->orderBy('tgl_mulai', 'asc')
                ->first();
            
            // Tentukan status gelombang
            $waveStatus = $this->getWaveStatus($gelombang);

            return view('depan.pages.informasi', compact('kuotaData', 'totalData', 'gelombang', 'waveStatus'));
            
        } catch (\Exception $e) {
            Log::error('Error in InformasiController: ' . $e->getMessage());
            
            // Fallback data yang sesuai dengan database
            $kuotaData = $this->getFallbackKuotaData();
            $totalData = [
                'kuota_total' => 360,
                'terisi' => 10,
                'sisa' => 350,
                'persentase' => 2.78
            ];
            $gelombang = null;
            $waveStatus = 'not_started';
            
            return view('depan.pages.informasi', compact('kuotaData', 'totalData', 'gelombang', 'waveStatus'))
                ->with('error', 'Data sedang dalam proses penyiapan.');
        }
    }
    
    private function hitungJumlahKelas($kuota)
    {
        // Asumsi 1 kelas = 36 siswa
        return ceil($kuota / 36);
    }
    
    private function getWaveStatus($gelombang)
    {
        if (!$gelombang) {
            return 'not_started';
        }
        
        $now = now();
        $startDate = $gelombang->tgl_mulai;
        $endDate = $gelombang->tgl_selesai;
        
        if ($now < $startDate) {
            return 'countdown';
        } elseif ($now >= $startDate && $now <= $endDate) {
            return 'active';
        } else {
            return 'ended';
        }
    }
    
    private function getFallbackKuotaData()
    {
        // Data fallback sesuai dengan database aktual
        return [
            [
                'nama' => 'Teknik Komputer dan Jaringan',
                'kode' => 'TKJ',
                'kelas' => 3,
                'kuota_total' => 100,
                'terisi' => 3,
                'sisa' => 97,
                'persentase' => 3.0
            ],
            [
                'nama' => 'Rekayasa Perangkat Lunak',
                'kode' => 'RPL',
                'kelas' => 3,
                'kuota_total' => 80,
                'terisi' => 5,
                'sisa' => 75,
                'persentase' => 6.25
            ],
            [
                'nama' => 'Teknik Elektronika Industri',
                'kode' => 'TEI',
                'kelas' => 2,
                'kuota_total' => 60,
                'terisi' => 1,
                'sisa' => 59,
                'persentase' => 1.67
            ],
            [
                'nama' => 'Teknik Kendaraan Ringan',
                'kode' => 'TKR',
                'kelas' => 2,
                'kuota_total' => 70,
                'terisi' => 1,
                'sisa' => 69,
                'persentase' => 1.43
            ],
            [
                'nama' => 'Teknik Bisnis Sepeda Motor',
                'kode' => 'TBSM',
                'kelas' => 2,
                'kuota_total' => 50,
                'terisi' => 0,
                'sisa' => 50,
                'persentase' => 0
            ]
        ];
    }
    
    public function getKuotaData()
{
    try {
        Log::info('Memulai pengambilan data kuota');
        
        $jurusan = Jurusan::where('aktif', true)->get();
        Log::info('Jurusan ditemukan: ' . $jurusan->count());
        
        // Hitung jumlah pendaftar per jurusan
        $pendaftarPerJurusan = Pendaftar::select('jurusan_id', DB::raw('COUNT(*) as total'))
            ->whereIn('status', ['SUBMIT', 'ADM_PASS', 'PAID', 'LULUS'])
            ->groupBy('jurusan_id')
            ->get()
            ->keyBy('jurusan_id');
            
        Log::info('Data pendaftar:', $pendaftarPerJurusan->toArray());
        
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
            
            Log::info("Jurusan {$item->nama}: Kuota={$item->kuota}, Terisi={$terisi}");
        }
        
        Log::info("Total: Kuota={$totalKuota}, Terisi={$totalTerisi}");
        
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
        Log::error('Stack trace: ' . $e->getTraceAsString());
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal mengambil data kuota: ' . $e->getMessage()
        ], 500);
    }
}

    public function testWave()
    {
        $now = now();
        $gelombang = Gelombang::where('aktif', true)
            ->where(function($query) use ($now) {
                $query->where('tgl_mulai', '<=', $now)
                      ->where('tgl_selesai', '>=', $now);
            })
            ->orWhere(function($query) use ($now) {
                $query->where('aktif', true)
                      ->where('tgl_mulai', '>', $now);
            })
            ->orderBy('tgl_mulai', 'asc')
            ->first();
            
        $waveStatus = $this->getWaveStatus($gelombang);
        
        return response()->json([
            'current_time' => $now->format('Y-m-d H:i:s'),
            'gelombang' => $gelombang,
            'wave_status' => $waveStatus,
            'all_waves' => Gelombang::all()
        ]);
    }
    
    public function setTestMode($mode)
    {
        $now = now();
        
        switch($mode) {
            case 'countdown':
                // Set wave to start in future
                Gelombang::query()->update(['aktif' => false]);
                Gelombang::updateOrCreate(
                    ['nama' => 'Test Countdown Wave'],
                    [
                        'tahun' => 2025,
                        'tgl_mulai' => $now->copy()->addDays(30),
                        'tgl_selesai' => $now->copy()->addDays(60),
                        'biaya_daftar' => 200000,
                        'aktif' => true
                    ]
                );
                break;
                
            case 'active':
                // Set wave to be active now
                Gelombang::query()->update(['aktif' => false]);
                Gelombang::updateOrCreate(
                    ['nama' => 'Test Active Wave'],
                    [
                        'tahun' => 2025,
                        'tgl_mulai' => $now->copy()->subDays(5),
                        'tgl_selesai' => $now->copy()->addDays(25),
                        'biaya_daftar' => 200000,
                        'aktif' => true
                    ]
                );
                break;
                
            case 'none':
                // No active waves
                Gelombang::query()->update(['aktif' => false]);
                break;
        }
        
        return redirect()->route('informasi')->with('success', "Test mode set to: {$mode}");
    }
}