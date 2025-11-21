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
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function showForm()
    {
        try {
            // Cek status gelombang aktif
            $gelombangAktif = Gelombang::isActive();
            
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
            $provinsiList = Wilayah::getProvinsi();
            
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
                $provinsiList = collect(['Jawa Barat']);
            }

            // Inisialisasi variabel $pendaftar untuk menghindari error
            $pendaftar = null;

            // Jika user sudah login, coba ambil data pendaftar jika ada
            if (auth()->check()) {
                $user = auth()->user();
                $pendaftar = Pendaftar::where('user_id', $user->id)->first();
            }

            Log::info('ShowForm - Jurusan: ' . $jurusan->count() . ', Gelombang: ' . $gelombang->count() . ', Wilayah: ' . $wilayah->count());

            return view('depan.pages.pendaftaran', compact('jurusan', 'gelombang', 'pendaftar', 'wilayah', 'provinsiList', 'gelombangAktif'));
        } catch (\Exception $e) {
            Log::error('Error in showForm: ' . $e->getMessage());

            // Fallback data dengan semua variabel yang diperlukan
            $jurusan = collect([(object) ['id' => 1, 'kode' => 'TKJ', 'nama' => 'Teknik Komputer dan Jaringan', 'kuota' => 100, 'aktif' => true]]);
            $gelombang = collect([(object) ['id' => 1, 'nama' => 'Gelombang 1', 'tahun' => 2025, 'tgl_mulai' => now(), 'tgl_selesai' => now()->addMonth(), 'biaya_daftar' => 250000, 'aktif' => true]]);
            $wilayah = collect([(object) ['id' => 1, 'provinsi' => 'Jawa Barat', 'kabupaten' => 'Bandung', 'kecamatan' => 'Coblong', 'kelurahan' => 'Dago', 'kodepos' => '40135']]);
            $pendaftar = null;

            $gelombangAktif = false;
            return view('depan.pages.pendaftaran', compact('jurusan', 'gelombang', 'pendaftar', 'wilayah', 'provinsiList', 'gelombangAktif'))
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
        ob_clean();
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
                'provinsi' => 'required|string|max:100',
                'kabupaten' => 'required|string|max:100', 
                'kecamatan' => 'required|string|max:100',
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

            // Cek apakah NIK atau NISN sudah pernah digunakan
            $existingByNik = PendaftarDataSiswa::where('nik', $request->nik)->first();
            $existingByNisn = PendaftarDataSiswa::where('nisn', $request->nisn)->first();
            
            if ($existingByNik) {
                return response()->json([
                    'success' => false,
                    'message' => 'NIK sudah pernah digunakan untuk pendaftaran.'
                ], 422);
            }
            
            if ($existingByNisn) {
                return response()->json([
                    'success' => false,
                    'message' => 'NISN sudah pernah digunakan untuk pendaftaran.'
                ], 422);
            }
            
            // Cek apakah user sudah pernah mendaftar
            $existingPendaftar = Pendaftar::where('user_id', $userId)->first();
            if ($existingPendaftar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akun ini sudah melakukan pendaftaran sebelumnya.'
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
                'nama' => $request->fullName,
                'hp' => $request->phone,
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

            // Log aktivitas - Pendaftaran Selesai
            LogAktivitas::create([
                'user_id' => $userId,
                'aksi' => 'CREATE',
                'objek' => 'Pendaftar: ' . $request->studentName,
                'objek_data' => ['no_pendaftaran' => $noPendaftaran, 'jurusan_id' => $request->major],
                'waktu' => now(),
                'ip' => $request->ip()
            ]);

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
            'certificateFile' => 'LAINNYA'
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

                // Pastikan jenis sesuai enum di database. Jika tidak, gunakan 'LAINNYA' sebagai fallback.
                $allowedJenis = ['IJAZAH','RAPOR','KIP','KKS','AKTA','KK','BUKTI_BAYAR','LAINNYA'];
                if (!in_array($jenis, $allowedJenis)) {
                    Log::warning("Unknown berkas jenis '{$jenis}' provided. Falling back to 'LAINNYA'.");
                    $jenis = 'LAINNYA';
                }

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

    // API Methods untuk Dropdown Wilayah
    public function getProvinsi()
    {
        $provinsi = Wilayah::getProvinsi()->toArray();
        return response()->json($provinsi, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getKabupaten($provinsi)
    {
        ob_clean();
        $kabupaten = Wilayah::getKabupaten($provinsi)->toArray();
        return response()->json($kabupaten);
    }

    public function getKecamatan($provinsi, $kabupaten)
    {
        ob_clean();
        $kecamatan = Wilayah::getKecamatan($provinsi, $kabupaten)->toArray();
        return response()->json($kecamatan);
    }

    public function getKelurahan($provinsi, $kabupaten, $kecamatan)
    {
        ob_clean();
        $kelurahan = Wilayah::getKelurahan($provinsi, $kabupaten, $kecamatan)->toArray();
        return response()->json($kelurahan);
    }

    /**
     * Return coordinates based on kecamatan.
     * Fallback order:
     * 1) wilayah record with lat/lng for the exact provinsi/kabupaten/kecamatan
     * 2) any wilayah record that matches kecamatan with lat/lng
     * 3) default coordinates based on kabupaten (fallback to Jawa Barat default)
     */
    public function getKoordinatKecamatan($provinsi, $kabupaten, $kecamatan)
    {
        ob_clean();

        // Try exact match for wilayah
        $wilayah = Wilayah::where('provinsi', $provinsi)
            ->where('kabupaten', $kabupaten)
            ->where('kecamatan', $kecamatan)
            ->first();

        if ($wilayah && isset($wilayah->lat) && isset($wilayah->lng) && $wilayah->lat && $wilayah->lng) {
            return response()->json(['lat' => (float)$wilayah->lat, 'lng' => (float)$wilayah->lng]);
        }

        // Try any wilayah with same kecamatan that has coordinates
        $wilayahAny = Wilayah::where('kecamatan', $kecamatan)
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->first();

        if ($wilayahAny) {
            return response()->json(['lat' => (float)$wilayahAny->lat, 'lng' => (float)$wilayahAny->lng]);
        }

        // Fallback to default coordinates based on kabupaten (reuse mapping similar to PetaController)
        $kabupatenCoordinates = [
            'Kota Bandung' => ['lat' => -6.9175, 'lng' => 107.6191],
            'Kota Cirebon' => ['lat' => -6.7320, 'lng' => 108.5523],
            'Kota Bekasi' => ['lat' => -6.2383, 'lng' => 106.9756],
            'Kota Depok' => ['lat' => -6.4025, 'lng' => 106.7942],
            'Kota Bogor' => ['lat' => -6.5971, 'lng' => 106.8060],
            'Kota Tasikmalaya' => ['lat' => -7.3257, 'lng' => 108.2148],
            'Kabupaten Bandung' => ['lat' => -7.1950, 'lng' => 107.5450],
            'Kabupaten Bandung Barat' => ['lat' => -6.8652, 'lng' => 107.4912],
            'Kabupaten Sumedang' => ['lat' => -6.8500, 'lng' => 107.9167],
            'Kabupaten Garut' => ['lat' => -7.2279, 'lng' => 107.9087],
            'Kabupaten Tasikmalaya' => ['lat' => -7.3274, 'lng' => 108.2207],
            'Kabupaten Ciamis' => ['lat' => -7.3331, 'lng' => 108.3493],
            'Kabupaten Kuningan' => ['lat' => -6.9828, 'lng' => 108.4832],
            'Kabupaten Cirebon' => ['lat' => -6.7710, 'lng' => 108.4821],
            'Kabupaten Majalengka' => ['lat' => -6.8364, 'lng' => 108.2279],
            'Kabupaten Indramayu' => ['lat' => -6.3373, 'lng' => 108.3258],
            'Kabupaten Subang' => ['lat' => -6.5700, 'lng' => 107.7630],
            'Kabupaten Purwakarta' => ['lat' => -6.5560, 'lng' => 107.4430],
            'Kabupaten Karawang' => ['lat' => -6.3227, 'lng' => 107.3376],
            'Kabupaten Bekasi' => ['lat' => -6.2474, 'lng' => 107.1485],
            'Kabupaten Bogor' => ['lat' => -6.5518, 'lng' => 106.6291],
            'Kabupaten Sukabumi' => ['lat' => -7.0598, 'lng' => 106.6899],
            'Kabupaten Cianjur' => ['lat' => -6.8170, 'lng' => 107.1390],
            'default' => ['lat' => -6.9175, 'lng' => 107.6191]
        ];

        foreach ($kabupatenCoordinates as $key => $coords) {
            if (stripos($kabupaten, $key) !== false) {
                return response()->json($coords);
            }
        }

        return response()->json($kabupatenCoordinates['default']);
    }
}