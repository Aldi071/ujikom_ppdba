<?php
// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Gunakan DB facade untuk semua query
        $totalPendaftar = DB::table('pendaftar')->count();
        $verifikasiAdm = DB::table('pendaftar')->where('status', 'ADM_PASS')->count();
        $sudahBayar = DB::table('pendaftar')->where('status', 'PAID')->count();
        $lulusSeleksi = DB::table('pendaftar')->where('status', 'LULUS')->count();
        $totalKuota = DB::table('jurusan')->where('aktif', 1)->sum('kuota');

        // 5 Pendaftar Terbaru dengan join
        $pendaftarTerbaru = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->select('p.*', 'pds.nama as nama_siswa', 'j.nama as nama_jurusan')
            ->orderBy('p.created_at', 'desc')
            ->take(5)
            ->get();

        // Data untuk charts
        $pendaftarPerJurusan = DB::table('pendaftar as p')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->select('j.nama', DB::raw('COUNT(p.id) as total'))
            ->groupBy('j.id', 'j.nama')
            ->get();

        $pendaftarPerStatus = DB::table('pendaftar')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->get();

        // Data per bulan tahun ini
        $currentYear = date('Y');
        $pendaftarPerBulan = DB::table('pendaftar')
            ->select(DB::raw('MONTH(created_at) as month, COUNT(*) as total'))
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Format data untuk chart
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $found = $pendaftarPerBulan->firstWhere('month', $i);
            $chartData[] = $found ? $found->total : 0;
        }

        return view('admin.admin', compact(
            'totalPendaftar',
            'verifikasiAdm',
            'sudahBayar',
            'lulusSeleksi',
            'totalKuota',
            'pendaftarTerbaru',
            'pendaftarPerJurusan',
            'pendaftarPerStatus',
            'chartData'
        ));
    }
}