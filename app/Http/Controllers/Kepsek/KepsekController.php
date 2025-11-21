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
use App\Services\WhatsAppService;

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
            
            // Data Kuota (hanya jurusan aktif)
            $totalKuota = Jurusan::where('aktif', 1)->sum('kuota');
            // Kuota terisi = yang sudah lulus seleksi final (status LULUS)
            $kuotaTerisi = Pendaftar::where('status', 'LULUS')->count();
            $kuotaTersedia = max(0, $totalKuota - $kuotaTerisi);
            $keterisianKuota = $totalKuota > 0 ? round(($kuotaTerisi / $totalKuota) * 100, 1) : 0;

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
                'totalKuota',
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
                'totalKuota' => 0,
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

/**
 * Show form untuk final selection (LULUS/TIDAK_LULUS/CADANGAN)
 */
public function showSeleksi($id)
{
    if (!Auth::check() || Auth::user()->role !== 'kepsek') {
        abort(403, 'Unauthorized access');
    }

    $pendaftar = DB::table('pendaftar as p')
        ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
        ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
        ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
        ->leftJoin('pendaftar_data_ortu as pdo', 'p.id', '=', 'pdo.pendaftar_id')
        ->leftJoin('pendaftar_asal_sekolah as pas', 'p.id', '=', 'pas.pendaftar_id')
        ->select(
            'p.*',
            'pds.*',
            'j.nama as jurusan',
            'g.nama as gelombang',
            'pdo.*',
            'pas.*'
        )
        ->where('p.id', $id)
        ->first();

    if (!$pendaftar) {
        return redirect()->route('kepsek.hasil-seleksi')->with('error', 'Data pendaftar tidak ditemukan');
    }

    // Hanya bisa di-seleksi jika sudah ADM_PASS dan PAID
    if (!in_array($pendaftar->status, ['PAID', 'ADM_PASS'])) {
        return redirect()->route('kepsek.hasil-seleksi')
            ->with('error', 'Pendaftar harus sudah terverifikasi dan membayar untuk diseleksi');
    }

    $statusList = [
        'DRAFT' => 'Draft',
        'SUBMIT' => 'Menunggu Verifikasi',
        'ADM_PASS' => 'Berkas Diterima',
        'ADM_REJECT' => 'Berkas Ditolak',
        'PAID' => 'Sudah Bayar',
        'LULUS' => 'Lulus',
        'TIDAK_LULUS' => 'Tidak Lulus',
        'CADANGAN' => 'Cadangan'
    ];

    return view('kepsek.seleksi-pendaftar', compact('pendaftar', 'statusList'));
}

/**
 * Update final selection status (LULUS/TIDAK_LULUS/CADANGAN)
 */
public function updateSeleksi(Request $request, $id)
{
    if (!Auth::check() || Auth::user()->role !== 'kepsek') {
        abort(403, 'Unauthorized access');
    }

    try {
        // Validasi status - kepsek hanya bisa set LULUS/TIDAK_LULUS/CADANGAN
        $allowedStatus = ['LULUS', 'TIDAK_LULUS', 'CADANGAN'];
        if (!in_array($request->status, $allowedStatus)) {
            return redirect()->back()->with('error', 'Status tidak valid');
        }

        $updated = DB::table('pendaftar')
            ->where('id', $id)
            ->update([
                'status' => $request->status,
                'user_verifikasi_adm' => auth()->user()->name ?? 'System',
                'tgl_verifikasi_adm' => now(),
                'catatan_verifikasi' => $request->catatan,
                'updated_at' => now()
            ]);

        if ($updated) {
            // Kirim WhatsApp ke pendaftar
            $pendaftar = DB::table('pendaftar as p')
                ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
                ->join('pengguna as pg', 'p.user_id', '=', 'pg.id')
                ->where('p.id', $id)
                ->select('p.no_pendaftaran', 'pds.nama', 'pg.hp')
                ->first();
                
            if ($pendaftar && $pendaftar->hp) {
                $statusMessages = [
                    'LULUS' => '🎉 SELAMAT! ANDA DITERIMA',
                    'TIDAK_LULUS' => '😔 MOHON MAAF, ANDA TIDAK DITERIMA',
                    'CADANGAN' => '⏳ ANDA MASUK DAFTAR CADANGAN'
                ];
                
                if (isset($statusMessages[$request->status])) {
                    $message = "Halo {$pendaftar->nama},\n\n";
                    $message .= "{$statusMessages[$request->status]}\n\n";
                    $message .= "No. Pendaftaran: {$pendaftar->no_pendaftaran}\n";
                    
                    if ($request->catatan) {
                        $message .= "Catatan: {$request->catatan}\n\n";
                    }
                    
                    $message .= "Silakan cek detail di website SPMB BAKNUS 666.\n\n";
                    $message .= "Terima kasih.";
                    
                    $whatsapp = new WhatsAppService();
                    $whatsapp->sendMessage($pendaftar->hp, $message);
                }
            }
            
            return redirect()->route('kepsek.hasil-seleksi')
                ->with('success', 'Status seleksi berhasil diupdate ke: ' . $request->status);
        } else {
            return redirect()->back()->with('error', 'Gagal update status - data tidak ditemukan');
        }
        
    } catch (\Exception $e) {
        \Log::error('Error updating seleksi status: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}


}