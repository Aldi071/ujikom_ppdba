<?php
// app/Http/Controllers/PengumumanController.php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\Jurusan;
use App\Models\PendaftarBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        try {
            // Ambil data siswa yang sudah lulus untuk ditampilkan di tabel
            $siswaDiterima = Pendaftar::with(['dataSiswa', 'jurusan'])
                ->whereIn('status', ['LULUS', 'SUBMIT'])
                ->orderBy('id', 'desc')
                ->limit(100)
                ->get();

            return view('depan.pages.pengumuman', compact('siswaDiterima'));
        } catch (\Exception $e) {
            Log::error('Error in PengumumanController index: ' . $e->getMessage());
            return view('depan.pages.pengumuman')->with('error', 'Terjadi kesalahan saat memuat data pengumuman.');
        }
    }

    public function checkStatus(Request $request)
    {
        try {
            $request->validate([
                'registrationNumber' => 'required|string'
            ]);

            $noPendaftaran = $request->registrationNumber;

            // Cari data pendaftar berdasarkan nomor pendaftaran
            $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang'])
                ->where('no_pendaftaran', $noPendaftaran)
                ->first();

            if (!$pendaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor pendaftaran tidak ditemukan'
                ], 404);
            }

            // Cek apakah sudah ada bukti pembayaran
            $buktiPembayaran = PendaftarBerkas::where('pendaftar_id', $pendaftar->id)
                ->where('jenis', 'BUKTI_BAYAR')
                ->where('catatan', 'LIKE', '%bukti pembayaran%')
                ->first();

            // Cek apakah user yang login adalah pemilik data
            $isOwner = false;
            $currentUserId = null;
            
            // Gunakan Auth::check() dan Auth::id() dari sistem Laravel default
            if (Auth::check()) {
                $currentUserId = Auth::id();
                $isOwner = $pendaftar->user_id == $currentUserId;
            }

            // Debug log (only when APP_DEBUG=true)
            if (config('app.debug')) {
                \Log::info('Check Status Debug:', [
                    'registration_number' => $noPendaftaran,
                    'pendaftar_user_id' => $pendaftar->user_id,
                    'current_user_id' => $currentUserId,
                    'auth_check' => Auth::check(),
                    'is_owner' => $isOwner,
                    'user_email' => Auth::check() ? Auth::user()->email : 'Not logged in'
                ]);
            }

            // Format data untuk response
            $data = [
                'id' => $pendaftar->id,
                'registrationNumber' => $pendaftar->no_pendaftaran,
                'name' => $pendaftar->dataSiswa->nama,
                'jurusan' => $pendaftar->jurusan->nama,
                'jurusan_kode' => $pendaftar->jurusan->kode,
                'jalur' => 'Reguler',
                'nilai' => $pendaftar->dataSiswa->nilai_rata ?? 0,
                'status' => $this->mapStatus($pendaftar->status),
                'status_db' => $pendaftar->status,
                'tanggal_daftar' => $pendaftar->tanggal_daftar,
                'has_bukti_pembayaran' => $buktiPembayaran ? true : false,
                'bukti_pembayaran' => $buktiPembayaran,
                'is_owner' => $isOwner,
                'user_id' => $pendaftar->user_id,
                'current_user_id' => $currentUserId,
                'is_logged_in' => Auth::check()
            ];

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function uploadBuktiPembayaran(Request $request)
    {
        try {
            if (config('app.debug')) {
                \Log::info('Upload bukti pembayaran dimulai', $request->all());
            }
            
            $request->validate([
                'registrationNumber' => 'required|string',
                'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
            ]);

            $noPendaftaran = $request->registrationNumber;

            $pendaftar = Pendaftar::where('no_pendaftaran', $noPendaftaran)->first();

            if (!$pendaftar) {
                if (config('app.debug')) {
                    \Log::error('Nomor pendaftaran tidak ditemukan: ' . $noPendaftaran);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor pendaftaran tidak ditemukan'
                ], 404);
            }

            // Cek apakah user login
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk mengupload bukti pembayaran'
                ], 401);
            }

            $currentUserId = Auth::id();
            
            if ($pendaftar->user_id != $currentUserId) {
                if (config('app.debug')) {
                    \Log::error('User tidak memiliki akses:', [
                        'pendaftar_user_id' => $pendaftar->user_id,
                        'current_user_id' => $currentUserId,
                        'current_user_email' => Auth::user()->email
                    ]);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya bisa mengupload bukti pembayaran untuk akun Anda sendiri'
                ], 403);
            }

            // Hanya boleh upload jika status ADM_PASS
            if ($pendaftar->status !== 'ADM_PASS') {
                if (config('app.debug')) {
                    \Log::error('Status tidak sesuai untuk upload: ' . $pendaftar->status);
                }
                return response()->json([
                    'success' => false,
                    'message' => 'Upload bukti pembayaran hanya untuk status lolos administrasi'
                ], 400);
            }

            // Upload file
            $file = $request->file('bukti_pembayaran');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('berkas/' . $pendaftar->id, $fileName, 'public');

            // Simpan ke database - gunakan LAINNYA dengan catatan khusus
            $berkas = new PendaftarBerkas();
            $berkas->pendaftar_id = $pendaftar->id;
            $berkas->jenis = 'BUKTI_BAYAR';
            $berkas->nama_file = $fileName;
            $berkas->url = $path;
            $berkas->ukuran_kb = round($file->getSize() / 1024, 2);
            $berkas->valid = 0; // Menunggu verifikasi
            $berkas->catatan = 'Bukti pembayaran diupload via pengumuman';
            $berkas->save();

            if (config('app.debug')) {
                \Log::info('Bukti pembayaran berhasil diupload untuk: ' . $noPendaftaran);
            }

            return response()->json([
                'success' => true,
                'message' => 'Bukti pembayaran berhasil diupload dan menunggu verifikasi',
                'file_name' => $fileName
            ]);

        } catch (\Exception $e) {
            if (config('app.debug')) {
                \Log::error('Error uploading bukti pembayaran: ' . $e->getMessage());
            }
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getSiswaDiterima()
    {
        try {
            $siswaDiterima = Pendaftar::with(['dataSiswa', 'jurusan'])
                ->whereIn('status', ['LULUS', 'SUBMIT'])
                ->orderBy('id', 'desc')
                ->get()
                ->map(function($item) {
                    return [
                        'id' => $item->id,
                        'registrationNumber' => $item->no_pendaftaran,
                        'name' => $item->dataSiswa->nama,
                        'jurusan' => $item->jurusan->kode,
                        'jurusan_nama' => $item->jurusan->nama,
                        'jalur' => 'Reguler',
                        'nilai' => $item->dataSiswa->nilai_rata ?? 0,
                        'status' => $this->mapStatus($item->status)
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $siswaDiterima
            ]);

        } catch (\Exception $e) {
            Log::error('Error getting siswa diterima: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    private function mapStatus($status)
    {
        $statusMap = [
            'DRAFT' => 'Dalam Proses',
            'SUBMIT' => 'Terverifikasi',
            'ADM_PASS' => 'Lolos Administrasi',
            'ADM_REJECT' => 'Tidak Lolos Administrasi',
            'PAID' => 'Sudah Bayar',
            'LULUS' => 'DITERIMA',
            'TIDAK_LULUS' => 'TIDAK DITERIMA',
            'CADANGAN' => 'Cadangan'
        ];

        return $statusMap[$status] ?? $status;
    }
}