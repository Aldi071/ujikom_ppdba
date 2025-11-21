<?php
// app/Http/Controllers/Keuangan/LaporanController.php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Filter default: bulan ini
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $status = $request->get('status', '');

        // Statistik keuangan
        $totalPendapatan = DB::table('pendaftar as p')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereIn('p.status', ['PAID', 'LULUS'])
            ->whereBetween('p.tgl_verifikasi_payment', [$startDate, $endDate])
            ->sum('g.biaya_daftar');

        $totalPembayaranValid = DB::table('pendaftar')
            ->whereIn('status', ['PAID', 'LULUS'])
            ->whereBetween('tgl_verifikasi_payment', [$startDate, $endDate])
            ->count();

        $menungguVerifikasi = DB::table('pendaftar')
            ->where('status', 'ADM_PASS')
            ->whereBetween('tanggal_daftar', [$startDate, $endDate])
            ->count();

        // Data untuk chart pembayaran per gelombang
        $pembayaranPerGelombang = DB::table('pendaftar as p')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereIn('p.status', ['PAID', 'LULUS'])
            ->whereBetween('p.tgl_verifikasi_payment', [$startDate, $endDate])
            ->select('g.nama as gelombang', DB::raw('count(*) as total'), DB::raw('sum(g.biaya_daftar) as nominal'))
            ->groupBy('g.id', 'g.nama')
            ->get();

        // Data untuk tabel laporan
        $data = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereBetween('p.tanggal_daftar', [$startDate, $endDate])
            ->when($status, function ($query, $status) {
                return $query->where('p.status', $status);
            })
            ->select(
                'p.no_pendaftaran',
                'pds.nama',
                'j.nama as jurusan',
                'g.nama as gelombang',
                'g.biaya_daftar',
                'p.status',
                'p.tanggal_daftar',
                'p.tgl_verifikasi_payment',
                'p.user_verifikasi_payment'
            )
            ->orderBy('p.tanggal_daftar', 'desc')
            ->get();

        $statusList = [
            '' => 'Semua Status',
            'ADM_PASS' => 'Menunggu Pembayaran',
            'PAID' => 'Sudah Bayar',
            'ADM_REJECT' => 'Ditolak'
        ];

        return view('keuangan.laporan.index', compact(
            'totalPendapatan',
            'totalPembayaranValid',
            'menungguVerifikasi',
            'pembayaranPerGelombang',
            'data',
            'statusList',
            'startDate',
            'endDate',
            'status'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $status = $request->get('status', '');

        // Data untuk PDF
        $totalPendapatan = DB::table('pendaftar as p')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereIn('p.status', ['PAID', 'LULUS'])
            ->whereBetween('p.tgl_verifikasi_payment', [$startDate, $endDate])
            ->sum('g.biaya_daftar');

        $data = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereBetween('p.tanggal_daftar', [$startDate, $endDate])
            ->when($status, function ($query, $status) {
                return $query->where('p.status', $status);
            })
            ->select(
                'p.no_pendaftaran',
                'pds.nama',
                'j.nama as jurusan',
                'g.nama as gelombang',
                'g.biaya_daftar',
                'p.status',
                'p.tanggal_daftar',
                'p.tgl_verifikasi_payment',
                'p.user_verifikasi_payment'
            )
            ->orderBy('p.tanggal_daftar', 'desc')
            ->get();

        $totalPembayaranValid = DB::table('pendaftar')
            ->whereIn('status', ['PAID', 'LULUS'])
            ->whereBetween('tgl_verifikasi_payment', [$startDate, $endDate])
            ->count();

        $pdf = PDF::loadView('keuangan.laporan.export-pdf', compact(
            'data',
            'totalPendapatan',
            'totalPembayaranValid',
            'startDate',
            'endDate'
        ));

        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('laporan-keuangan-' . date('Y-m-d') . '.pdf');
    }

    public function previewPdf(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $status = $request->get('status', '');

        // Data untuk PDF (sama seperti method export)
        $totalPendapatan = DB::table('pendaftar as p')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereIn('p.status', ['PAID', 'LULUS'])
            ->whereBetween('p.tgl_verifikasi_payment', [$startDate, $endDate])
            ->sum('g.biaya_daftar');

        $data = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->whereBetween('p.tanggal_daftar', [$startDate, $endDate])
            ->when($status, function ($query, $status) {
                return $query->where('p.status', $status);
            })
            ->select(
                'p.no_pendaftaran',
                'pds.nama',
                'j.nama as jurusan',
                'g.nama as gelombang',
                'g.biaya_daftar',
                'p.status',
                'p.tanggal_daftar',
                'p.tgl_verifikasi_payment',
                'p.user_verifikasi_payment'
            )
            ->orderBy('p.tanggal_daftar', 'desc')
            ->get();

        $totalPembayaranValid = DB::table('pendaftar')
            ->whereIn('status', ['PAID', 'LULUS'])
            ->whereBetween('tgl_verifikasi_payment', [$startDate, $endDate])
            ->count();

        $pdf = PDF::loadView('keuangan.laporan.export-pdf', compact(
            'data',
            'totalPendapatan',
            'totalPembayaranValid',
            'startDate',
            'endDate'
        ));

        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('laporan-keuangan-preview.pdf');
    }
}