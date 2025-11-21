<?php
// app/Http/Controllers/Verifikator/DataPendaftarController.php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pendaftar;
use App\Services\WhatsAppService;

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
            'ADM_PASS' => 'Berkas Diterima',
            'ADM_REJECT' => 'Berkas Ditolak'
        ];

        return view('verifikator.detail-pendaftar', compact('pendaftar', 'berkas', 'statusList'));
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            // Validasi status - verifikator hanya bisa set ADM_PASS/ADM_REJECT
            $allowedStatus = ['ADM_PASS', 'ADM_REJECT'];
            if (!in_array($request->status, $allowedStatus)) {
                return redirect()->back()->with('error', 'Status tidak valid');
            }

            // Update langsung tanpa transaction dulu untuk test
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
                // Jika status di-set ke ADM_REJECT, update record berkas yang dipilih
                if ($request->status === 'ADM_REJECT') {
                    $rejected = $request->input('rejected_berkas', []);
                    $berkasNotes = $request->input('berkas_catatan', []);

                    if (is_array($rejected) && count($rejected) > 0) {
                        foreach ($rejected as $berkasId) {
                            $note = isset($berkasNotes[$berkasId]) ? trim($berkasNotes[$berkasId]) : '';
                            if ($note === '') {
                                $note = 'Ditolak oleh verifikator';
                            }

                            // Update tabel pendafar_berkas: set valid = 0 dan catatan
                            DB::table('pendaftar_berkas')
                                ->where('id', $berkasId)
                                ->where('pendaftar_id', $id)
                                ->update([
                                    'valid' => 0,
                                    'catatan' => $note,
                                    'updated_at' => now()
                                ]);
                        }
                    }
                }

                // Jika status di-set ke ADM_PASS, tandai semua berkas sebagai valid (diterima oleh verifikator)
                if ($request->status === 'ADM_PASS') {
                    DB::table('pendaftar_berkas')
                        ->where('pendaftar_id', $id)
                        ->update([
                            'valid' => 1,
                            'catatan' => 'Diterima oleh verifikator',
                            'updated_at' => now()
                        ]);
                }
                // Kirim WhatsApp ke pendaftar
                $pendaftar = DB::table('pendaftar as p')
                    ->join('pendaftar_data_siswa as pds', 'p.id', '=', 'pds.pendaftar_id')
                    ->join('pengguna as pg', 'p.user_id', '=', 'pg.id')
                    ->where('p.id', $id)
                    ->select('p.no_pendaftaran', 'pds.nama', 'pg.hp')
                    ->first();
                    
                if ($pendaftar && $pendaftar->hp) {
                    $statusMessages = [
                        'ADM_PASS' => '✅ BERKAS DITERIMA',
                        'ADM_REJECT' => '❌ BERKAS DITOLAK', 
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
                
                return redirect()->route('verifikator.detail-pendaftar', $id)
                    ->with('success', 'Status berhasil diupdate ke: ' . $request->status);
            } else {
                return redirect()->back()->with('error', 'Gagal update status - data tidak ditemukan');
            }
            
        } catch (\Exception $e) {
            \Log::error('Error updating status: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
