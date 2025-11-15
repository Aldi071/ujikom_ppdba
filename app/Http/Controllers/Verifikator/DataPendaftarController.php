<?php
// app/Http/Controllers/Verifikator/DataPendaftarController.php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataPendaftarController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk data pendaftar
        $query = DB::table('pendaftar as p')
            ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
            ->join('jurusan as j', 'p.jurusan_id', '=', 'j.id')
            ->join('gelombang as g', 'p.gelombang_id', '=', 'g.id')
            ->select(
                'p.id',
                'p.no_pendaftaran',
                'pds.nama',
                'pds.jk',
                'j.nama as jurusan',
                'g.nama as gelombang',
                'p.tanggal_daftar',
                'p.status',
                'p.user_verifikasi_adm',
                'p.tgl_verifikasi_adm'
            );

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('p.status', $request->status);
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan') && $request->jurusan != '') {
            $query->where('p.jurusan_id', $request->jurusan);
        }

        // Filter berdasarkan gelombang
        if ($request->has('gelombang') && $request->gelombang != '') {
            $query->where('p.gelombang_id', $request->gelombang);
        }

        // Filter pencarian nama
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('pds.nama', 'like', "%{$search}%")
                    ->orWhere('p.no_pendaftaran', 'like', "%{$search}%");
            });
        }

        $pendaftars = $query->orderBy('p.tanggal_daftar', 'desc')->paginate(10);

        // Data untuk filter
        $jurusanList = DB::table('jurusan')->where('aktif', 1)->get();
        $gelombangList = DB::table('gelombang')->where('aktif', 1)->get();

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

        return view('verifikator.data-pendaftar', compact(
            'pendaftars',
            'jurusanList',
            'gelombangList',
            'statusList'
        ));
    }

    public function show($id)
    {
        // Ambil detail pendaftar
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
            return redirect()->route('verifikator.dashboard')
                ->with('error', 'Data pendaftar tidak ditemukan.');
        }

        // Ambil semua berkas
        $berkas = DB::table('pendaftar_berkas')
            ->where('pendaftar_id', $id)
            ->get();

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

        return view('verifikator.detail-pendaftar', compact('pendaftar', 'berkas', 'statusList'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:ADM_PASS,ADM_REJECT',
            'catatan' => 'nullable|string|max:255'
        ]);

        $updateData = [
            'status' => $request->status,
            'user_verifikasi_adm' => auth()->user()->name,
            'tgl_verifikasi_adm' => now(),
            'updated_at' => now()
        ];

        DB::table('pendaftar')->where('id', $id)->update($updateData);

        // Log aktivitas
        DB::table('log_aktivitas')->insert([
            'user_id' => auth()->id(),
            'aksi' => 'UPDATE_STATUS',
            'objek' => 'PENDAFTAR',
            'objek_data' => json_encode([
                'pendaftar_id' => $id,
                'status_sebelum' => DB::table('pendaftar')->where('id', $id)->value('status'),
                'status_sesudah' => $request->status,
                'catatan' => $request->catatan
            ]),
            'waktu' => now(),
            'ip' => $request->ip(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('verifikator.data-pendaftar')
            ->with('success', 'Status pendaftar berhasil diupdate.');
    }
}
