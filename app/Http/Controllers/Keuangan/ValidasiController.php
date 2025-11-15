<?php
// app/Http/Controllers/Keuangan/ValidasiController.php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ValidasiController extends Controller
{
    public function index(Request $request)
    {
        // Data pendaftar yang menunggu verifikasi pembayaran (status ADM_PASS)
        $query = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->where('p.status', 'ADM_PASS')
            ->select(
                'p.id',
                'p.no_pendaftaran',
                'pds.nama',
                'pds.jk',
                'j.nama as jurusan',
                'g.nama as gelombang',
                'g.biaya_daftar',
                'p.tanggal_daftar'
            );

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pds.nama', 'like', "%{$search}%")
                  ->orWhere('p.no_pendaftaran', 'like', "%{$search}%");
            });
        }

        // Filter jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('p.jurusan_id', $request->jurusan);
        }

        // Filter gelombang
        if ($request->has('gelombang') && $request->gelombang != '') {
            $query->where('p.gelombang_id', $request->gelombang);
        }

        $pendaftars = $query->orderBy('p.tanggal_daftar', 'desc')->paginate(10);

        // Data untuk filter
        $jurusanList = DB::table('jurusan')->where('aktif', 1)->get();
        $gelombangList = DB::table('gelombang')->where('aktif', 1)->get();

        return view('keuangan.validasi.index', compact('pendaftars', 'jurusanList', 'gelombangList'));
    }

    public function show($id)
    {
        // Detail pendaftar untuk validasi
        $pendaftar = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->leftJoin('pendaftar_berkas as pb', function($join) {
                $join->on('p.id', '=', 'pb.pendaftar_id')
                     ->where('pb.jenis', 'BUKTI_BAYAR');
            })
            ->where('p.id', $id)
            ->select(
                'p.*',
                'pds.*',
                'j.nama as jurusan',
                'g.nama as gelombang',
                'g.biaya_daftar',
                'pb.nama_file as bukti_bayar_file',
                'pb.url as bukti_bayar_url',
                'pb.ukuran_kb as bukti_bayar_size'
            )
            ->first();

        if (!$pendaftar) {
            return redirect()->route('keuangan.validasi.index')
                ->with('error', 'Data pendaftar tidak ditemukan.');
        }

        return view('keuangan.validasi.detail', compact('pendaftar'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:PAID,ADM_REJECT',
            'catatan' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $updateData = [
                'status' => $request->status,
                'user_verifikasi_payment' => auth()->user()->name ?? 'System',
                'tgl_verifikasi_payment' => now(),
                'updated_at' => now()
            ];

            DB::table('pendaftar')->where('id', $id)->update($updateData);

            // Jika ditolak, tambahkan catatan ke berkas bukti bayar
            if ($request->status == 'ADM_REJECT' && $request->catatan) {
                DB::table('pendaftar_berkas')
                    ->where('pendaftar_id', $id)
                    ->where('jenis', 'BUKTI_BAYAR')
                    ->update([
                        'valid' => 0,
                        'catatan' => $request->catatan,
                        'updated_at' => now()
                    ]);
            }

            // Jika diterima, tandai berkas sebagai valid
            if ($request->status == 'PAID') {
                DB::table('pendaftar_berkas')
                    ->where('pendaftar_id', $id)
                    ->where('jenis', 'BUKTI_BAYAR')
                    ->update([
                        'valid' => 1,
                        'catatan' => 'Pembayaran telah diverifikasi',
                        'updated_at' => now()
                    ]);
            }

            DB::commit();

            $statusText = $request->status == 'PAID' ? 'diterima' : 'ditolak';
            return redirect()->route('keuangan.validasi.index')
                ->with('success', "Pembayaran berhasil di{$statusText}.");

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengupdate status: ' . $e->getMessage());
        }
    }
}