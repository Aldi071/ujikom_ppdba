<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\PendaftarAsalSekolah;
use App\Models\Gelombang;
use App\Models\PendaftarDataSiswa;
use App\Models\Wilayah;

class KepsekController extends Controller
{
     public function dashboard()
    {
        // Cek authentication dan role
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();
        
        if ($user->role !== 'kepsek') {
            abort(403, 'Unauthorized access. Hanya Kepala Sekolah yang dapat mengakses halaman ini.');
        }

        try {
            // Data Statistik Utama
            $totalPendaftar = Pendaftar::count();
            $pendaftarHariIni = Pendaftar::whereDate('tanggal_daftar', today())->count();
            $lulusAdministrasi = Pendaftar::where('status', 'ADM_PASS')->count();
            $sudahBayar = Pendaftar::where('status', 'PAID')->count();
            $lulusSeleksi = Pendaftar::where('status', 'LULUS')->count();
            $tidakLulus = Pendaftar::where('status', 'TIDAK_LULUS')->count();
            
            // Data Kuota
            $totalKuota = Jurusan::sum('kuota');
            $kuotaTersedia = $totalKuota - $lulusSeleksi;
            $keterisianKuota = $totalKuota > 0 ? round(($lulusSeleksi / $totalKuota) * 100, 1) : 0;

            // Rasio Terverifikasi
            $rasioTerverifikasiAdm = $totalPendaftar > 0 ? round(($lulusAdministrasi / $totalPendaftar) * 100, 1) : 0;
            $rasioTerverifikasiBayar = $totalPendaftar > 0 ? round(($sudahBayar / $totalPendaftar) * 100, 1) : 0;

            // Data Tren Pendaftaran (7 hari terakhir)
            $grafikPendaftarPerHari = Pendaftar::select(
                    DB::raw('DATE(tanggal_daftar) as tanggal'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('tanggal_daftar', '>=', now()->subDays(7))
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            // Data Tren Bulanan
            $trenPendaftaran = Pendaftar::select(
                    DB::raw('MONTH(tanggal_daftar) as bulan'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('tanggal_daftar', date('Y'))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get();

            // Isi bulan yang tidak ada data dengan 0
            $trenData = array_fill(1, 12, 0);
            foreach ($trenPendaftaran as $tren) {
                $trenData[$tren->bulan] = $tren->total;
            }

            // Data Peminat per Jurusan
            $peminatPerJurusan = DB::table('jurusan')
                ->select(
                    'jurusan.nama as jurusan',
                    DB::raw('COUNT(pendaftar.id) as total_peminat'),
                    'jurusan.kuota'
                )
                ->leftJoin('pendaftar', 'jurusan.id', '=', 'pendaftar.jurusan_id')
                ->groupBy('jurusan.id', 'jurusan.nama', 'jurusan.kuota')
                ->get();

            // Data Status Verifikasi
            $statusVerifikasi = Pendaftar::select(
                    'status',
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy('status')
                ->get();

            // Data Status Pembayaran
            $statusPembayaran = Pendaftar::select(
                    DB::raw("CASE 
                        WHEN status = 'PAID' THEN 'SUDAH_BAYAR'
                        WHEN status IN ('ADM_PASS', 'SUBMIT') THEN 'BELUM_BAYAR'
                        ELSE 'TIDAK_TERVERIFIKASI'
                    END as status_bayar"),
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy('status_bayar')
                ->get();

            // Data Asal Sekolah
            $rekapAsalSekolah = PendaftarAsalSekolah::select(
                    'nama_sekolah',
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy('nama_sekolah')
                ->orderBy('jumlah', 'desc')
                ->limit(5)
                ->get();

            // Data Komposisi Wilayah
            $komposisiWilayah = DB::table('pendaftar_data_siswa')
                ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
                ->select(
                    'wilayah.kabupaten',
                    DB::raw('COUNT(*) as jumlah')
                )
                ->groupBy('wilayah.kabupaten')
                ->orderBy('jumlah', 'desc')
                ->limit(8)
                ->get();

            // Data untuk peta (jika ada koordinat)
            $dataPeta = PendaftarDataSiswa::whereNotNull('lat')
                ->whereNotNull('lng')
                ->with(['pendaftar.jurusan'])
                ->get();

            return view('kepsek.dashboard', compact(
                'totalPendaftar',
                'pendaftarHariIni',
                'lulusAdministrasi',
                'sudahBayar',
                'lulusSeleksi',
                'tidakLulus',
                'kuotaTersedia',
                'keterisianKuota',
                'rasioTerverifikasiAdm',
                'rasioTerverifikasiBayar',
                'grafikPendaftarPerHari',
                'peminatPerJurusan',
                'statusVerifikasi',
                'statusPembayaran',
                'trenData',
                'rekapAsalSekolah',
                'komposisiWilayah',
                'dataPeta'
            ));

        } catch (\Exception $e) {
            // Fallback data jika ada error
            return view('kepsek.dashboard', [
                'totalPendaftar' => 0,
                'pendaftarHariIni' => 0,
                'lulusAdministrasi' => 0,
                'sudahBayar' => 0,
                'lulusSeleksi' => 0,
                'tidakLulus' => 0,
                'kuotaTersedia' => 0,
                'keterisianKuota' => 0,
                'rasioTerverifikasiAdm' => 0,
                'rasioTerverifikasiBayar' => 0,
                'grafikPendaftarPerHari' => collect(),
                'peminatPerJurusan' => collect(),
                'statusVerifikasi' => collect(),
                'statusPembayaran' => collect(),
                'trenData' => array_fill(1, 12, 0),
                'rekapAsalSekolah' => collect(),
                'komposisiWilayah' => collect(),
                'dataPeta' => collect()
            ]);
        }
    }

    public function hasilSeleksi(Request $request)
{
    // Cek authentication dan role
    if (!Auth::check()) {
        return redirect()->route('admin.login');
    }

    $user = Auth::user();
    
    if ($user->role !== 'kepsek') {
        abort(403, 'Unauthorized access. Hanya Kepala Sekolah yang dapat mengakses halaman ini.');
    }

    try {
        // Query dasar untuk hasil seleksi
        $query = Pendaftar::with([
            'dataSiswa', 
            'asalSekolah', 
            'jurusan',
            'gelombang'
        ]);

        // Filter berdasarkan status
        $status = $request->get('status');
        if ($status && in_array($status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN', 'PAID', 'ADM_PASS'])) {
            $query->where('status', $status);
        } else {
            // Default tampilkan semua status kecuali DRAFT dan SUBMIT
            $query->whereNotIn('status', ['DRAFT', 'SUBMIT']);
        }

        // Filter berdasarkan jurusan
        $jurusan_id = $request->get('jurusan_id');
        if ($jurusan_id) {
            $query->where('jurusan_id', $jurusan_id);
        }

        // Filter berdasarkan gelombang
        $gelombang_id = $request->get('gelombang_id');
        if ($gelombang_id) {
            $query->where('gelombang_id', $gelombang_id);
        }

        // Search
        $search = $request->get('search');
        if ($search) {
            $query->whereHas('dataSiswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_pendaftaran', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        $hasilSeleksi = $query->orderBy('tanggal_daftar', 'desc')->get();

        // Data untuk filter
        $jurusanList = Jurusan::where('aktif', 1)->get();
        $gelombangList = Gelombang::where('aktif', 1)->get();

        // Statistik
        $totalLulus = Pendaftar::where('status', 'LULUS')->count();
        $totalTidakLulus = Pendaftar::where('status', 'TIDAK_LULUS')->count();
        $totalCadangan = Pendaftar::where('status', 'CADANGAN')->count();

        return view('kepsek.hasil-seleksi', compact(
            'hasilSeleksi',
            'jurusanList',
            'gelombangList',
            'totalLulus',
            'totalTidakLulus',
            'totalCadangan',
            'status',
            'jurusan_id',
            'gelombang_id',
            'search'
        ));

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

public function exportHasilSeleksi(Request $request)
{
    try {
        // Query yang sama dengan method hasilSeleksi
        $query = Pendaftar::with([
            'dataSiswa', 
            'asalSekolah', 
            'jurusan',
            'gelombang'
        ])->whereNotIn('status', ['DRAFT', 'SUBMIT']);

        $status = $request->get('status');
        if ($status && in_array($status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN', 'PAID', 'ADM_PASS'])) {
            $query->where('status', $status);
        }

        $hasilSeleksi = $query->orderBy('status', 'desc')
                             ->orderBy('tanggal_daftar', 'asc')
                             ->get();

        // Generate PDF
        $pdf = \PDF::loadView('kepsek.export.hasil-seleksi-pdf', compact('hasilSeleksi'));
        
        return $pdf->download('hasil-seleksi-ppdb-' . date('Y-m-d') . '.pdf');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
    }
}

public function printHasilSeleksi(Request $request)
{
    try {
        // Query yang sama dengan method hasilSeleksi
        $query = Pendaftar::with([
            'dataSiswa', 
            'asalSekolah', 
            'jurusan',
            'gelombang'
        ])->whereNotIn('status', ['DRAFT', 'SUBMIT']);

        $status = $request->get('status');
        if ($status && in_array($status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN', 'PAID', 'ADM_PASS'])) {
            $query->where('status', $status);
        }

        $hasilSeleksi = $query->orderBy('status', 'desc')
                             ->orderBy('tanggal_daftar', 'asc')
                             ->get();

        return view('kepsek.export.hasil-seleksi-print', compact('hasilSeleksi'));

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat print: ' . $e->getMessage());
    }
}

public function petaSebaran(Request $request)
{
    // Cek authentication dan role
    if (!Auth::check()) {
        return redirect()->route('admin.login');
    }

    $user = Auth::user();
    
    if ($user->role !== 'kepsek') {
        abort(403, 'Unauthorized access. Hanya Kepala Sekolah yang dapat mengakses halaman ini.');
    }

    try {
        // Filter berdasarkan jurusan
        $jurusan_id = $request->get('jurusan_id');
        $status = $request->get('status');

        // Query data untuk peta
        $query = PendaftarDataSiswa::with([
            'pendaftar.jurusan',
            'pendaftar.gelombang',
            'wilayah'
        ])->whereNotNull('lat')
          ->whereNotNull('lng');

        // Filter berdasarkan jurusan
        if ($jurusan_id) {
            $query->whereHas('pendaftar', function($q) use ($jurusan_id) {
                $q->where('jurusan_id', $jurusan_id);
            });
        }

        // Filter berdasarkan status
        if ($status && in_array($status, ['LULUS', 'TIDAK_LULUS', 'CADANGAN', 'PAID', 'ADM_PASS'])) {
            $query->whereHas('pendaftar', function($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $dataPeta = $query->get();

        // Data untuk filter
        $jurusanList = Jurusan::where('aktif', 1)->get();
        
        // Statistik untuk sidebar
        $totalDataPeta = $dataPeta->count();
        $totalPendaftar = Pendaftar::count();
        $persentaseDataPeta = $totalPendaftar > 0 ? round(($totalDataPeta / $totalPendaftar) * 100, 1) : 0;

        // Data untuk heatmap/clustering
        $clusterData = $dataPeta->groupBy(function($item) {
            return round($item->lat, 2) . ',' . round($item->lng, 2);
        })->map(function($cluster) {
            return [
                'lat' => $cluster->first()->lat,
                'lng' => $cluster->first()->lng,
                'count' => $cluster->count(),
                'pendaftars' => $cluster->take(3) // Ambil 3 data pertama untuk info window
            ];
        });

        return view('kepsek.peta-sebaran', compact(
            'dataPeta',
            'jurusanList',
            'jurusan_id',
            'status',
            'totalDataPeta',
            'totalPendaftar',
            'persentaseDataPeta',
            'clusterData'
        ));

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
    
}
}