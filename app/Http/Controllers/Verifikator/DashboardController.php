<?php
// app/Http/Controllers/Verifikator/DashboardController.php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk card statistics
        $menungguVerifikasi = DB::table('pendaftar')
            ->where('status', 'SUBMIT')
            ->count();

        $berkasDiterima = DB::table('pendaftar')
            ->whereIn('status', ['ADM_PASS', 'PAID', 'LULUS'])
            ->count();

        $berkasDitolak = DB::table('pendaftar')
            ->where('status', 'ADM_REJECT')
            ->count();

        // Data untuk chart - semua status
        $statusData = DB::table('pendaftar')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Format data untuk chart
        $statusLabels = [];
        $statusCounts = [];
        $statusColors = [];

        $colorMap = [
            'DRAFT' => '#6c757d',
            'SUBMIT' => '#ffc107', 
            'ADM_PASS' => '#28a745',
            'ADM_REJECT' => '#dc3545',
            'PAID' => '#17a2b8',
            'LULUS' => '#20c997',
            'TIDAK_LULUS' => '#e83e8c',
            'CADANGAN' => '#fd7e14'
        ];

        foreach ($statusData as $item) {
            $statusLabels[] = $item->status;
            $statusCounts[] = $item->total;
            $statusColors[] = $colorMap[$item->status] ?? '#6c757d';
        }

        // Data untuk tabel pendaftar menunggu verifikasi - PERBAIKI JOIN INI
        $pendaftarMenunggu = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->where('p.status', 'SUBMIT')
            ->select('p.id', 'p.no_pendaftaran', 'pds.nama', 'j.nama as jurusan')
            ->orderBy('p.tanggal_daftar', 'asc')
            ->limit(5)
            ->get();

        return view('verifikator.verifikator', compact(
            'menungguVerifikasi',
            'berkasDiterima',
            'berkasDitolak',
            'statusLabels',
            'statusCounts',
            'statusColors',
            'pendaftarMenunggu'
        ));
    }
}