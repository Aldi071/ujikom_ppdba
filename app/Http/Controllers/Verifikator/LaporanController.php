<?php
// app/Http/Controllers/Verifikator/LaporanController.php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Default filter: bulan ini
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $jurusanId = $request->get('jurusan_id', '');
        $status = $request->get('status', '');

        // Query untuk statistik utama
        $totalPendaftar = DB::table('pendaftar')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->count();

        $menungguVerifikasi = DB::table('pendaftar')
            ->where('status', 'SUBMIT')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->count();

        $diterima = DB::table('pendaftar')
            ->where('status', 'ADM_PASS')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->count();

        $ditolak = DB::table('pendaftar')
            ->where('status', 'ADM_REJECT')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->count();

        // Statistik per jurusan
        $statistikJurusan = DB::table('pendaftar as p')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->whereBetween('p.tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('p.jurusan_id', $jurusanId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('p.status', $status);
            })
            ->select('j.nama as jurusan', DB::raw('count(*) as total'))
            ->groupBy('j.nama', 'j.id')
            ->orderBy('total', 'desc')
            ->get();

        // Statistik per status
        $statistikStatus = DB::table('pendaftar')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Statistik per hari (untuk chart)
        $statistikHarian = DB::table('pendaftar')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->select(DB::raw('DATE(tanggal_daftar) as tanggal'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('DATE(tanggal_daftar)'))
            ->orderBy('tanggal')
            ->get();

        // Data untuk filter
        $jurusanList = DB::table('jurusan')->where('aktif', 1)->get();

        $statusList = [
            '' => 'Semua Status',
            'DRAFT' => 'Draft',
            'SUBMIT' => 'Menunggu Verifikasi',
            'ADM_PASS' => 'Berkas Diterima',
            'ADM_REJECT' => 'Berkas Ditolak',
            'PAID' => 'Sudah Bayar',
            'LULUS' => 'Lulus',
            'TIDAK_LULUS' => 'Tidak Lulus',
            'CADANGAN' => 'Cadangan'
        ];

        return view('verifikator.laporan', compact(
            'totalPendaftar',
            'menungguVerifikasi',
            'diterima',
            'ditolak',
            'statistikJurusan',
            'statistikStatus',
            'statistikHarian',
            'jurusanList',
            'statusList',
            'startDate',
            'endDate',
            'jurusanId',
            'status'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $jurusanId = $request->get('jurusan_id', '');
        $status = $request->get('status', '');

        // Data statistik untuk PDF
        $totalPendaftar = DB::table('pendaftar')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->count();

        $menungguVerifikasi = DB::table('pendaftar')
            ->where('status', 'SUBMIT')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->count();

        $diterima = DB::table('pendaftar')
            ->where('status', 'ADM_PASS')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->count();

        $ditolak = DB::table('pendaftar')
            ->where('status', 'ADM_REJECT')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('jurusan_id', $jurusanId);
            })
            ->count();

        // Data detail untuk tabel
        $data = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->leftJoin('pendaftar_asal_sekolah as pas', 'p.id', '=', 'pas.pendaftar_id')
            ->whereBetween('p.tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('p.jurusan_id', $jurusanId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('p.status', $status);
            })
            ->select(
                'p.no_pendaftaran',
                'pds.nama',
                'pds.jk',
                'j.nama as jurusan',
                'pas.nama_sekolah',
                'p.status',
                'p.tanggal_daftar',
                'p.user_verifikasi_adm',
                'p.tgl_verifikasi_adm'
            )
            ->orderBy('p.tanggal_daftar', 'desc')
            ->get();

        // Statistik per jurusan untuk PDF
        $statistikJurusan = DB::table('pendaftar as p')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->whereBetween('p.tanggal_daftar', [$startDate, $endDate])
            ->when($jurusanId, function ($query, $jurusanId) {
                return $query->where('p.jurusan_id', $jurusanId);
            })
            ->when($status, function ($query, $status) {
                return $query->where('p.status', $status);
            })
            ->select('j.nama as jurusan', DB::raw('count(*) as total'))
            ->groupBy('j.nama', 'j.id')
            ->orderBy('total', 'desc')
            ->get();

        $pdf = PDF::loadView('verifikator.export-pdf', compact(
            'data',
            'statistikJurusan',
            'totalPendaftar',
            'menungguVerifikasi',
            'diterima',
            'ditolak',
            'startDate',
            'endDate'
        ));

        // Set paper size and orientation
        $pdf->setPaper('A4', 'landscape');

        // Download PDF
        return $pdf->download('laporan-pendaftaran-' . date('Y-m-d') . '.pdf');
    }

    // Method untuk preview PDF (opsional)
    public function previewPdf(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $jurusanId = $request->get('jurusan_id', '');
        $status = $request->get('status', '');

        // ... sama seperti method export di atas ...

        $pdf = PDF::loadView('verifikator.export-pdf', compact(
            'data',
            'statistikJurusan',
            'totalPendaftar',
            'menungguVerifikasi',
            'diterima',
            'ditolak',
            'startDate',
            'endDate'
        ));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('laporan-pendaftaran-preview.pdf');
    }
}
