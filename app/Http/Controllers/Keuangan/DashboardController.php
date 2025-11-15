<?php
// app/Http/Controllers/Keuangan/DashboardController.php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Pembayaran
        $buktiBayarMasuk = DB::table('pendaftar')
            ->where('status', 'ADM_PASS') // Sudah lolos administrasi, menunggu pembayaran
            ->count();

        $pembayaranValid = DB::table('pendaftar')
            ->where('status', 'PAID') // Sudah bayar
            ->count();

        // Total nominal pembayaran yang sudah valid
        $totalNominal = DB::table('pendaftar as p')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->where('p.status', 'PAID')
            ->sum('g.biaya_daftar');

        $pending = DB::table('pendaftar')
            ->where('status', 'ADM_PASS') // Menunggu pembayaran
            ->count();

        // Data untuk chart pembayaran per gelombang
        $pembayaranPerGelombang = DB::table('pendaftar as p')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->where('p.status', 'PAID')
            ->select('g.nama as gelombang', DB::raw('count(*) as total'))
            ->groupBy('g.id', 'g.nama')
            ->get();

        // Data untuk tabel bukti bayar terbaru
        $buktiBayarTerbaru = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->where('p.status', 'ADM_PASS') // Yang menunggu verifikasi pembayaran
            ->select(
                'p.id',
                'p.no_pendaftaran',
                'pds.nama',
                'p.status',
                'g.biaya_daftar',
                'p.tanggal_daftar'
            )
            ->orderBy('p.tanggal_daftar', 'desc')
            ->limit(5)
            ->get();

        // Format total nominal ke Rupiah
        $totalNominalFormatted = 'Rp ' . number_format($totalNominal, 0, ',', '.');

        return view('keuangan.keuangan', compact(
            'buktiBayarMasuk',
            'pembayaranValid',
            'totalNominalFormatted',
            'pending',
            'pembayaranPerGelombang',
            'buktiBayarTerbaru'
        ));
    }
}