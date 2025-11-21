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
            $siswaDiterima = Pendaftar::with(['dataSiswa', 'jurusan', 'asalSekolah'])
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
        ob_clean();
        try {
            $request->validate([
                'registrationNumber' => 'required|string'
            ]);

            $noPendaftaran = $request->registrationNumber;

            // Cari data pendaftar berdasarkan nomor pendaftaran
            $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'asalSekolah'])
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
                ->where(function($q) {
                    $q->where('jenis', 'BUKTI_BAYAR')
                      ->orWhere('catatan', 'LIKE', '%bukti pembayaran%');
                })
                ->orderBy('created_at', 'desc')
                ->first();

            // Ambil berkas yang ditolak (valid = 0) jika ada —
            // tampilkan ini juga ketika verifikator menolak berkas (agar pemilik bisa reupload)
            $rejectedBerkas = PendaftarBerkas::where('pendaftar_id', $pendaftar->id)
                ->where('valid', 0)
                ->whereNotNull('catatan')
                ->where('catatan', '!=', '')
                ->get();
            $rejectedBerkasIds = $rejectedBerkas->pluck('id')->toArray();

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
                'gelombang_biaya' => $pendaftar->gelombang->biaya_daftar ?? null,
                'jalur' => 'Reguler',
                'nilai' => $pendaftar->asalSekolah->nilai_rata ?? $pendaftar->dataSiswa->nilai_rata ?? 0,
                'status' => $this->mapStatus($pendaftar->status),
                'status_db' => $pendaftar->status,
                'tanggal_daftar' => $pendaftar->tanggal_daftar,
                'has_bukti_pembayaran' => $buktiPembayaran ? true : false,
                'bukti_pembayaran' => $buktiPembayaran,
                'rejected_berkas' => $rejectedBerkas,
                'rejected_berkas_ids' => $rejectedBerkasIds,
                'catatan_verifikasi' => $pendaftar->catatan_verifikasi,
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

    public function reUploadBerkas(Request $request)
    {
        ob_clean();
        try {
            $request->validate([
                'registrationNumber' => 'required|string',
                'berkas_id' => 'required|integer',
                'berkas_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120'
            ]);

            $noPendaftaran = $request->registrationNumber;
            $berkasId = $request->berkas_id;

            $pendaftar = Pendaftar::where('no_pendaftaran', $noPendaftaran)->first();

            if (!$pendaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor pendaftaran tidak ditemukan'
                ], 404);
            }

            // Cek apakah user login
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk mengupload berkas'
                ], 401);
            }

            $currentUserId = Auth::id();
            
            if ($pendaftar->user_id != $currentUserId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya bisa mengupload berkas untuk akun Anda sendiri'
                ], 403);
            }

            // Cek apakah status ADM_REJECT
            if ($pendaftar->status !== 'ADM_REJECT') {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya dapat mengupload ulang berkas untuk status berkas ditolak'
                ], 400);
            }

            // Ambil berkas yang akan di-reupload
            $berkas = PendaftarBerkas::findOrFail($berkasId);

            if ($berkas->pendaftar_id != $pendaftar->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Berkas tidak sesuai dengan pendaftar'
                ], 403);
            }

            // Upload file baru
            $file = $request->file('berkas_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('berkas/' . $pendaftar->id, $fileName, 'public');

            // Cek jika ini adalah BUKTI_BAYAR
            $isBuktiBayar = $berkas->jenis === 'BUKTI_BAYAR';
            
            // Update berkas dengan file baru
            $berkasData = [
                'nama_file' => $fileName,
                'url' => $path,
                'ukuran_kb' => round($file->getSize() / 1024, 2),
                'valid' => 0, // Reset ke menunggu verifikasi
                'catatan' => 'REUPLOAD - Menunggu verifikasi ulang'
            ];

            // Jika ini bukan bukti bayar, berikan keterangan khusus untuk verifikator
            if (!$isBuktiBayar) {
                $berkasData['catatan'] = 'REUPLOAD - Menunggu verifikasi ulang oleh verifikator';
            } else {
                $berkasData['catatan'] = 'REUPLOAD - Menunggu verifikasi ulang oleh keuangan';
            }

            $berkas->update($berkasData);

            // Jika BUKTI_BAYAR di-reupload, ubah status pendaftar kembali ke ADM_PASS
            if ($isBuktiBayar) {
                $pendaftar->update([
                    'status' => 'ADM_PASS',
                    'user_verifikasi_payment' => null,
                    'tgl_verifikasi_payment' => null
                ]);
            } else {
                // Untuk berkas lain, kembalikan status ke SUBMIT agar verifikator memproses ulang
                $pendaftar->update([
                    'status' => 'SUBMIT',
                    'user_verifikasi_adm' => null,
                    'tgl_verifikasi_adm' => null,
                    'catatan_verifikasi' => null
                ]);
            }

            if (config('app.debug')) {
                \Log::info('Berkas berhasil di-reupload untuk: ' . $noPendaftaran, [
                    'berkas_id' => $berkasId,
                    'jenis' => $berkas->jenis,
                    'is_bukti_bayar' => $isBuktiBayar
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => $isBuktiBayar ? 
                    'Bukti pembayaran berhasil di-reupload dan menunggu verifikasi ulang oleh keuangan' :
                    'Berkas berhasil di-reupload dan menunggu verifikasi ulang',
                'file_name' => $fileName,
                'is_bukti_bayar' => $isBuktiBayar
            ]);

        } catch (\Exception $e) {
            if (config('app.debug')) {
                \Log::error('Error reupload berkas: ' . $e->getMessage());
            }
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Re-upload multiple rejected berkas in one request.
     * Expects files as 'berkas_files[<berkasId>]' entries in the form data.
     */
    public function reUploadMultipleBerkas(Request $request)
    {
        ob_clean();
        try {
            $request->validate([
                'registrationNumber' => 'required|string'
            ]);

            $noPendaftaran = $request->registrationNumber;

            $pendaftar = Pendaftar::where('no_pendaftaran', $noPendaftaran)->first();

            if (!$pendaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor pendaftaran tidak ditemukan'
                ], 404);
            }

            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda harus login untuk mengupload berkas'
                ], 401);
            }

            $currentUserId = Auth::id();
            if ($pendaftar->user_id != $currentUserId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda hanya bisa mengupload berkas untuk akun Anda sendiri'
                ], 403);
            }

            // Collect files sent as an associative array: berkas_files[<id>] => file
            $files = $request->file('berkas_files', []);

            if (!$files || count($files) === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada file yang dipilih untuk diupload'
                ], 400);
            }

            $anyBukti = false;
            $anyOther = false;
            $processed = 0;

            foreach ($files as $berkasId => $file) {
                // Skip empty
                if (!$file) continue;

                $berkas = PendaftarBerkas::find($berkasId);
                if (!$berkas) continue;
                if ($berkas->pendaftar_id != $pendaftar->id) continue;

                // store file
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('berkas/' . $pendaftar->id, $fileName, 'public');

                $isBuktiBayar = $berkas->jenis === 'BUKTI_BAYAR';

                $berkasData = [
                    'nama_file' => $fileName,
                    'url' => $path,
                    'ukuran_kb' => round($file->getSize() / 1024, 2),
                    'valid' => 0,
                    'catatan' => $isBuktiBayar ? 'REUPLOAD - Menunggu verifikasi ulang oleh keuangan' : 'REUPLOAD - Menunggu verifikasi ulang oleh verifikator'
                ];

                $berkas->update($berkasData);

                if ($isBuktiBayar) $anyBukti = true; else $anyOther = true;
                $processed++;
            }

            if ($processed === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada berkas valid yang berhasil diproses'
                ], 400);
            }

            // Decide final status: if any bukti bayar uploaded, set ADM_PASS, otherwise set SUBMIT
            if ($anyBukti) {
                $pendaftar->update([
                    'status' => 'ADM_PASS',
                    'user_verifikasi_payment' => null,
                    'tgl_verifikasi_payment' => null
                ]);
            } else {
                $pendaftar->update([
                    'status' => 'SUBMIT',
                    'user_verifikasi_adm' => null,
                    'tgl_verifikasi_adm' => null,
                    'catatan_verifikasi' => null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Semua berkas yang dipilih berhasil diupload ulang dan akan diverifikasi ulang',
                'processed' => $processed,
                'any_bukti' => $anyBukti,
                'any_other' => $anyOther
            ]);

        } catch (\Exception $e) {
            if (config('app.debug')) {
                \Log::error('Error reupload multiple berkas: ' . $e->getMessage());
            }
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadBuktiPembayaran(Request $request)
    {
        ob_clean();
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
        ob_clean();
        try {
            $siswaDiterima = Pendaftar::with(['dataSiswa', 'jurusan', 'asalSekolah'])
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
                        'nilai' => $item->asalSekolah->nilai_rata ?? $item->dataSiswa->nilai_rata ?? 0,
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

    public function dashboard()
    {
        if (!Auth::check()) {
            return redirect()->route('home')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $pendaftar = Pendaftar::where('user_id', $user->id)->first();

        if (!$pendaftar) {
            return redirect()->route('pengumuman')->with('info', 'Anda belum melakukan pendaftaran.');
        }

        // Redirect ke pengumuman dengan parameter auto-check
        return redirect()->route('pengumuman', ['auto_check' => $pendaftar->no_pendaftaran]);
    }

    public function getNotifikasi()
    {
        ob_clean();
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $notifikasi = \App\Models\Notifikasi::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifikasi,
            'unread_count' => $notifikasi->where('dibaca', false)->count()
        ]);
    }

    public function bacaNotifikasi(Request $request)
    {
        ob_clean();
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        if ($request->id) {
            \App\Models\Notifikasi::where('id', $request->id)
                ->where('user_id', Auth::id())
                ->update(['dibaca' => true]);
        } else {
            \App\Models\Notifikasi::where('user_id', Auth::id())
                ->update(['dibaca' => true]);
        }

        return response()->json(['success' => true]);
    }

    public function exportKartuPendaftaran($noPendaftaran)
    {
        try {
            $pendaftar = Pendaftar::with(['dataSiswa', 'jurusan', 'gelombang', 'asalSekolah', 'dataOrtu'])
                ->where('no_pendaftaran', $noPendaftaran)
                ->first();

            if (!$pendaftar) {
                return redirect()->back()->with('error', 'Nomor pendaftaran tidak ditemukan');
            }

            $pdf = \PDF::loadView('exports.kartu-pendaftaran', compact('pendaftar'));
            return $pdf->download('kartu-pendaftaran-' . $noPendaftaran . '.pdf');

        } catch (\Exception $e) {
            Log::error('Error export kartu pendaftaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat export PDF');
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