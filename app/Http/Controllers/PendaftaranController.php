<?php
// app/Http/Controllers/PendaftaranController.php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pendaftar;
use App\Models\PendaftarDataSiswa;
use App\Models\PendaftarAsalSekolah;
use App\Models\PendaftarDataOrtu;
use App\Models\PendaftarBerkas;
use App\Models\Jurusan;
use App\Models\Gelombang;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PendaftaranController extends Controller
{
    public function showForm()
    {
        try {
            // Ambil data jurusan yang aktif
            $jurusan = Jurusan::where('aktif', true)->get();

            // Jika tidak ada jurusan, buat data dummy untuk testing
            if ($jurusan->isEmpty()) {
                Log::warning('Tabel jurusan kosong, menggunakan data dummy');
                $jurusan = collect([
                    (object) [
                        'id' => 1,
                        'kode' => 'TKJ',
                        'nama' => 'Teknik Komputer dan Jaringan',
                        'kuota' => 100,
                        'aktif' => true
                    ],
                    (object) [
                        'id' => 2,
                        'kode' => 'RPL',
                        'nama' => 'Rekayasa Perangkat Lunak',
                        'kuota' => 80,
                        'aktif' => true
                    ]
                ]);
            }

            // Ambil gelombang yang sedang aktif
            $gelombang = Gelombang::where('tgl_mulai', '<=', now())
                ->where('tgl_selesai', '>=', now())
                ->where('aktif', true)
                ->get();

            // Jika tidak ada gelombang aktif, ambil semua gelombang untuk debugging
            if ($gelombang->isEmpty()) {
                $gelombang = Gelombang::where('aktif', true)->get();

                // Jika masih kosong, buat data dummy
                if ($gelombang->isEmpty()) {
                    Log::warning('Tabel gelombang kosong, menggunakan data dummy');
                    $gelombang = collect([
                        (object) [
                            'id' => 1,
                            'nama' => 'Gelombang 1',
                            'tahun' => 2025,
                            'tgl_mulai' => now(),
                            'tgl_selesai' => now()->addMonth(),
                            'biaya_daftar' => 250000,
                            'aktif' => true
                        ]
                    ]);
                }
            }

            // AMBIL DATA WILAYAH
            $wilayah = Wilayah::all();
            
            // Jika tidak ada wilayah, buat data dummy
            if ($wilayah->isEmpty()) {
                Log::warning('Tabel wilayah kosong, menggunakan data dummy');
                $wilayah = collect([
                    (object) [
                        'id' => 1,
                        'provinsi' => 'Jawa Barat',
                        'kabupaten' => 'Bandung',
                        'kecamatan' => 'Coblong',
                        'kelurahan' => 'Dago',
                        'kodepos' => '40135'
                    ]
                ]);
            }

            // Inisialisasi variabel $pendaftar untuk menghindari error
            $pendaftar = null;

            // Jika user sudah login, coba ambil data pendaftar jika ada
            if (auth()->check()) {
                $user = auth()->user();
                $pendaftar = Pendaftar::where('user_id', $user->id)->first();
            }

            Log::info('ShowForm - Jurusan: ' . $jurusan->count() . ', Gelombang: ' . $gelombang->count() . ', Wilayah: ' . $wilayah->count());

            return view('depan.pages.pendaftaran', compact('jurusan', 'gelombang', 'pendaftar', 'wilayah'));
        } catch (\Exception $e) {
            Log::error('Error in showForm: ' . $e->getMessage());

            // Fallback data dengan semua variabel yang diperlukan
            $jurusan = collect([(object) ['id' => 1, 'kode' => 'TKJ', 'nama' => 'Teknik Komputer dan Jaringan', 'kuota' => 100, 'aktif' => true]]);
            $gelombang = collect([(object) ['id' => 1, 'nama' => 'Gelombang 1', 'tahun' => 2025, 'tgl_mulai' => now(), 'tgl_selesai' => now()->addMonth(), 'biaya_daftar' => 250000, 'aktif' => true]]);
            $wilayah = collect([(object) ['id' => 1, 'provinsi' => 'Jawa Barat', 'kabupaten' => 'Bandung', 'kecamatan' => 'Coblong', 'kelurahan' => 'Dago', 'kodepos' => '40135']]);
            $pendaftar = null;

            return view('depan.pages.pendaftaran', compact('jurusan', 'gelombang', 'pendaftar', 'wilayah'))
                ->with('warning', 'Data sedang dalam proses penyiapan. Silakan lanjutkan pendaftaran.');
        }
    }

    /**
     * Method untuk recover pendaftar dari database jika session hilang
     */
    private function recoverPendaftar(Request $request)
    {
        if (config('app.debug')) {
            \Log::info('=== ATTEMPTING SESSION RECOVERY ===');
        }

        // Coba dari session pertama
        $pendaftarId = $request->session()->get('pendaftar_id');
        $userId = $request->session()->get('user_id');

        if ($pendaftarId && $userId) {
            if (config('app.debug')) {
                \Log::info('Session found - pendaftar_id: ' . $pendaftarId . ', user_id: ' . $userId);
            }
            return [$pendaftarId, $userId];
        }

        // Fallback: cari pendaftar yang masih DRAFT untuk user yang login
        if (auth()->check()) {
            $user = auth()->user();
            $pendaftar = Pendaftar::where('user_id', $user->id)
                ->where('status', 'DRAFT')
                ->orderBy('id', 'desc')
                ->first();

            if ($pendaftar) {
                if (config('app.debug')) {
                    \Log::info('Recovered from database - pendaftar_id: ' . $pendaftar->id . ', user_id: ' . $user->id);
                }

                // Set session kembali
                $request->session()->put('pendaftar_id', $pendaftar->id);
                $request->session()->put('user_id', $user->id);
                $request->session()->save();

                return [$pendaftar->id, $user->id];
            }
        }

        \Log::error('Session recovery failed');
        throw new \Exception('Session data tidak ditemukan. Silakan mulai pendaftaran dari awal.');
    }

    /**
     * Helper method untuk check session pendaftaran dengan recovery
     */
    private function checkPendaftaranSession(Request $request)
    {
        try {
            return $this->recoverPendaftar($request);
        } catch (\Exception $e) {
            \Log::error('Session check failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Method untuk check status pendaftaran yang sedang berjalan
     */
    public function checkPendingRegistration(Request $request)
    {
        try {
            list($pendaftarId, $userId) = $this->recoverPendaftar($request);

            $pendaftar = Pendaftar::with(['dataSiswa', 'asalSekolah', 'dataOrtu', 'berkas'])
                ->find($pendaftarId);

            return response()->json([
                'success' => true,
                'has_pending' => true,
                'current_step' => $request->session()->get('current_step', 1),
                'pendaftar' => $pendaftar,
                'no_pendaftaran' => $pendaftar->no_pendaftaran
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'has_pending' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    // Tambahkan method ini di PendaftaranController
    public function getCsrfToken()
    {
        return response()->json(['token' => csrf_token()]);
    }

    public function submitComplete(Request $request)
    {
        Log::info('=== COMPLETE REGISTRATION SUBMISSION ===');
        Log::info('Request Data:', $request->except(['password', 'password_confirmation']));

        // Pastikan user sudah login
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu.'
            ], 401);
        }

        DB::beginTransaction();
        try {
            // Validasi semua data (tanpa validasi email dan password)
            $validator = Validator::make($request->all(), [
                // Data Diri
                'fullName' => 'required|max:120',
                'nik' => 'required|digits:16|unique:pendaftar_data_siswa,nik',
                'nisn' => 'required|digits:10|unique:pendaftar_data_siswa,nisn',
                'gender' => 'required|in:L,P',
                'birthPlace' => 'required|max:60',
                'birthDate' => 'required|date',
                'address' => 'required',
                'phone' => 'required|max:20',
                'wilayah_id' => 'required|exists:wilayah,id',

                // Sekolah Asal
                'schoolName' => 'required|max:150',
                'schoolNpsn' => 'required|max:20',
                'schoolAddress' => 'required|max:100',
                'averageGrade' => 'required|numeric|min:0|max:100',

                // Orang Tua
                'fatherName' => 'required|max:120',
                'fatherJob' => 'required|max:100',
                'motherName' => 'required|max:120',
                'motherJob' => 'required|max:100',
                'parentPhone' => 'required|max:20',

                // Jurusan
                'gelombang_id' => 'required|exists:gelombang,id',
                'jurusan_id' => 'required|exists:jurusan,id',
                'agreement' => 'required|accepted',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = auth()->user();
            $userId = $user->id;

            // Generate registration number
            $noPendaftaran = 'BN666' . date('Y') . str_pad($userId, 6, '0', STR_PAD_LEFT);

            // Cek apakah user sudah pernah mendaftar
            $existingPendaftar = Pendaftar::where('user_id', $userId)->first();
            if ($existingPendaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan pendaftaran sebelumnya.'
                ], 422);
            }

            // Create pendaftar record - GUNAKAN user_id DARI USER YANG LOGIN
            $pendaftar = Pendaftar::create([
                'user_id' => $userId,
                'tanggal_daftar' => now(),
                'no_pendaftaran' => $noPendaftaran,
                'gelombang_id' => $request->gelombang_id,
                'jurusan_id' => $request->jurusan_id,
                'status' => 'SUBMIT',
            ]);

            // Update user name and phone
            $user->update([
                'name' => $request->fullName,
                'phone' => $request->phone,
            ]);

            // Create data siswa
            PendaftarDataSiswa::create([
                'pendaftar_id' => $pendaftar->id,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'nama' => $request->fullName,
                'jk' => $request->gender,
                'tmp_lahir' => $request->birthPlace,
                'tgl_lahir' => $request->birthDate,
                'agama' => $request->religion,
                'alamat' => $request->address,
                'wilayah_id' => $request->wilayah_id,
                'lat' => $request->latitude,
                'lng' => $request->longitude,
                'hp' => $request->phone,
            ]);

            // Create asal sekolah
            PendaftarAsalSekolah::create([
                'pendaftar_id' => $pendaftar->id,
                'npsn' => $request->schoolNpsn,
                'nama_sekolah' => $request->schoolName,
                'kabupaten' => $request->schoolAddress,
                'nilai_rata' => $request->averageGrade,
                'nilai_matematika' => $request->mathGrade,
                'nilai_ipa' => $request->scienceGrade,
                'nilai_inggris' => $request->englishGrade,
                'nilai_indonesia' => $request->indonesianGrade,
            ]);

            // Create data orang tua
            PendaftarDataOrtu::create([
                'pendaftar_id' => $pendaftar->id,
                'nama_ayah' => $request->fatherName,
                'pekerjaan_ayah' => $request->fatherJob,
                'hp_ayah' => $request->parentPhone,
                'nama_ibu' => $request->motherName,
                'pekerjaan_ibu' => $request->motherJob,
                'hp_ibu' => $request->parentPhone,
                'penghasilan_ortu' => $request->parentIncome,
                'wali_nama' => $request->waliName,
                'wali_hp' => $request->waliPhone,
                'alamat_ortu' => $request->parentAddress,
            ]);

            // Handle file uploads
            if ($request->hasAny(['kkFile', 'aktaFile', 'ijazahFile', 'raporFile', 'photoFile'])) {
                $this->handleFileUploads($request, $pendaftar->id);
            }

            DB::commit();

            Log::info('=== COMPLETE REGISTRATION SUCCESS ===');
            Log::info('Pendaftar created with user_id: ' . $userId . ' for user: ' . $user->email);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran berhasil',
                'no_pendaftaran' => $noPendaftaran
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('COMPLETE REGISTRATION ERROR: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function handleFileUploads(Request $request, $pendaftarId)
    {
        $fileTypes = [
            'kkFile' => 'KK',
            'aktaFile' => 'AKTA',
            'ijazahFile' => 'IJAZAH',
            'kipFile' => 'KIP',
            'kksFile' => 'KKS',
            'raporFile' => 'RAPOR',
            'photoFile' => 'LAINNYA',
            'certificateFile' => 'SERTIFIKAT'
        ];

        foreach ($fileTypes as $field => $jenis) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                
                // Validasi file size (max 2MB untuk umum, 1MB untuk foto)
                $maxSize = ($field === 'photoFile') ? 1024 : 2048; // dalam KB
                if ($file->getSize() > $maxSize * 1024) {
                    throw new \Exception("File {$field} terlalu besar. Maksimal " . $maxSize . "KB");
                }

                // Validasi file type
                $allowedExtensions = ($field === 'photoFile') ? ['jpg', 'jpeg', 'png'] : ['pdf', 'jpg', 'jpeg', 'png'];
                $extension = $file->getClientOriginalExtension();
                if (!in_array(strtolower($extension), $allowedExtensions)) {
                    throw new \Exception("File {$field} harus berformat: " . implode(', ', $allowedExtensions));
                }

                $filename = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('berkas/' . $pendaftarId, $filename, 'public');

                PendaftarBerkas::create([
                    'pendaftar_id' => $pendaftarId,
                    'jenis' => $jenis,
                    'nama_file' => $filename,
                    'url' => $path,
                    'ukuran_kb' => $file->getSize() / 1024,
                    'valid' => false,
                ]);
            }
        }
    }

    public function getWilayah()
    {
        $wilayah = Wilayah::all();
        return response()->json($wilayah);
    }

    public function checkNisn($nisn)
    {
        $exists = PendaftarDataSiswa::where('nisn', $nisn)->exists();
        return response()->json(['exists' => $exists]);
    }
}