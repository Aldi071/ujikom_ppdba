<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\Admin\MasterDataController;
use App\Http\Controllers\Admin\MonitoringController;
use App\Http\Controllers\Admin\PetaController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\DepanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Kepsek\KepsekController;

// Debug routes were removed for security

/*
|--------------------------------------------------------------------------
| AUTH ROUTES - PESERTA
|--------------------------------------------------------------------------
*/

// Auth Peserta
Route::post('/peserta/login', [AuthController::class, 'loginPeserta'])->name('peserta.login');
Route::post('/peserta/register', [AuthController::class, 'registerPeserta'])->name('peserta.register');
Route::post('/peserta/logout', [AuthController::class, 'logoutPeserta'])->name('peserta.logout');

// OTP Routes
Route::post('/peserta/verify-otp', [AuthController::class, 'verifyOtp'])->name('peserta.verifyOtp');
Route::post('/peserta/resend-otp', [AuthController::class, 'resendOtp'])->name('peserta.resendOtp');

// Admin Auth
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'loginAdmin'])->name('admin.login.post');
Route::post('/admin/logout', [AuthController::class, 'logoutAdmin'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| FRONTEND (PESERTA)
|--------------------------------------------------------------------------
*/

Route::get('/peserta/dashboard', function () {
    return redirect('/')->with('success', 'Selamat datang di dashboard peserta!');
})->name('peserta.dashboard')->middleware('auth');

Route::get('/', [DepanController::class, 'index'])->name('home');
Route::get('/akademik', fn() => view('depan.pages.akademik'))->name('akademik');
Route::get('/informasi', fn() => view('depan.pages.informasi'))->name('informasi');
Route::get('/pendaftaran', [PendaftaranController::class, 'showForm'])->name('pendaftaran');
Route::get('/pengumuman', fn() => view('depan.pages.pengumuman'))->name('pengumuman');
Route::get('/faq', fn() => view('depan.pages.faq'))->name('faq');
Route::get('/kontak', fn() => view('depan.pages.kontak'))->name('kontak');

// Pendaftaran
Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {
    Route::post('/step1', [PendaftaranController::class, 'submitStep1'])->name('step1');
    Route::post('/step2', [PendaftaranController::class, 'submitStep2'])->name('step2');
    Route::post('/step3', [PendaftaranController::class, 'submitStep3'])->name('step3');
    Route::post('/step4', [PendaftaranController::class, 'submitStep4'])->name('step4');
    Route::post('/step5', [PendaftaranController::class, 'submitStep5'])->name('step5');
    Route::post('/step6', [PendaftaranController::class, 'submitStep6'])->name('step6');
    Route::post('/complete', [PendaftaranController::class, 'submitComplete'])->name('complete');
    Route::get('/check-nisn/{nisn}', [PendaftaranController::class, 'checkNisn'])->name('checkNisn');
    Route::get('/check-email/{email}', [PendaftaranController::class, 'checkEmail'])->name('checkEmail');
    Route::get('/check-pending', [PendaftaranController::class, 'checkPendingRegistration'])->name('check-pending');
});

// Pengumuman
Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman');
Route::post('/pengumuman/check', [PengumumanController::class, 'checkStatus'])->name('pengumuman.check');
Route::post('/pengumuman/upload-bukti', [PengumumanController::class, 'uploadBuktiPembayaran'])->name('pengumuman.upload-bukti');
Route::get('/pengumuman/siswa-diterima', [PengumumanController::class, 'getSiswaDiterima'])->name('pengumuman.siswa-diterima');

// Informasi
Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');
Route::get('/informasi/kuota', [InformasiController::class, 'getKuotaData'])->name('informasi.kuota');

/*
|--------------------------------------------------------------------------
| BACKEND (ADMIN, VERIFIKATOR, KEPSEK)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Role Dashboard
    Route::get('/verifikator/dashboard', [DashboardController::class, 'index'])->name('verifikator.dashboard');
    Route::get('/keuangan/dashboard', [DashboardController::class, 'index'])->name('keuangan.dashboard');
    Route::get('/kepsek/dashboard', [DashboardController::class, 'index'])->name('kepsek.dashboard');

    // Admin Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | VERIFIKATOR
    |--------------------------------------------------------------------------
    */
    Route::prefix('verifikator')->name('verifikator.')->group(function () {

        Route::get('/dashboard', [App\Http\Controllers\Verifikator\DashboardController::class, 'index'])->name('dashboard');

        // Data Pendaftar
        Route::get('/data-pendaftar', [App\Http\Controllers\Verifikator\DataPendaftarController::class, 'index'])->name('data-pendaftar');
        Route::get('/data-pendaftar/{id}', [App\Http\Controllers\Verifikator\DataPendaftarController::class, 'show'])->name('detail-pendaftar');
        Route::put('/pendaftar/{id}/status', [App\Http\Controllers\Verifikator\DataPendaftarController::class, 'updateStatus'])->name('update-status');

        // Shortcut Detail
        Route::get('/pendaftar/{id}/detail', [App\Http\Controllers\Verifikator\DataPendaftarController::class, 'show'])->name('detail');

        // Laporan
        Route::get('/laporan', [App\Http\Controllers\Verifikator\LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export', [App\Http\Controllers\Verifikator\LaporanController::class, 'export'])->name('laporan.export');
        Route::get('/laporan/preview', [App\Http\Controllers\Verifikator\LaporanController::class, 'previewPdf'])->name('laporan.preview');
    });

    /*
    |--------------------------------------------------------------------------
    | KEUANGAN
    |--------------------------------------------------------------------------
    */
    Route::prefix('keuangan')->name('keuangan.')->group(function () {

        // Dashboard Keuangan
        Route::get('/dashboard', [App\Http\Controllers\Keuangan\DashboardController::class, 'index'])->name('dashboard');

        // Validasi Bukti Bayar
        Route::get('/validasi', [App\Http\Controllers\Keuangan\ValidasiController::class, 'index'])->name('validasi.index');
        Route::get('/validasi/{id}', [App\Http\Controllers\Keuangan\ValidasiController::class, 'show'])->name('validasi.detail');
        Route::put('/validasi/{id}/status', [App\Http\Controllers\Keuangan\ValidasiController::class, 'updateStatus'])->name('validasi.update-status');

        // Laporan Keuangan
        Route::get('/laporan', [App\Http\Controllers\Keuangan\LaporanController::class, 'index'])->name('laporan');
        Route::get('/laporan/export', [App\Http\Controllers\Keuangan\LaporanController::class, 'export'])->name('laporan.export');
        Route::get('/laporan/preview', [App\Http\Controllers\Keuangan\LaporanController::class, 'previewPdf'])->name('laporan.preview');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        // MASTER DATA
        Route::prefix('master')->name('master.')->group(function () {
            Route::get('/jurusan', [MasterDataController::class, 'jurusan'])->name('jurusan');
            Route::post('/jurusan', [MasterDataController::class, 'storeJurusan'])->name('jurusan.store');
            Route::get('/jurusan/{id}/edit', [MasterDataController::class, 'editJurusan'])->name('jurusan.edit');
            Route::put('/jurusan/{id}', [MasterDataController::class, 'updateJurusan'])->name('jurusan.update');
            Route::delete('/jurusan/{id}', [MasterDataController::class, 'destroyJurusan'])->name('jurusan.destroy');

            Route::get('/gelombang', [MasterDataController::class, 'gelombang'])->name('gelombang');
            Route::post('/gelombang', [MasterDataController::class, 'storeGelombang'])->name('gelombang.store');
            Route::get('/gelombang/{id}/edit', [MasterDataController::class, 'editGelombang'])->name('gelombang.edit');
            Route::put('/gelombang/{id}', [MasterDataController::class, 'updateGelombang'])->name('gelombang.update');
            Route::delete('/gelombang/{id}', [MasterDataController::class, 'destroyGelombang'])->name('gelombang.destroy');

            Route::get('/biaya', [MasterDataController::class, 'biaya'])->name('biaya');
            Route::post('/biaya', [MasterDataController::class, 'storeBiaya'])->name('biaya.store');
            Route::get('/biaya/{id}/edit', [MasterDataController::class, 'editBiaya'])->name('biaya.edit');
            Route::put('/biaya/{id}', [MasterDataController::class, 'updateBiaya'])->name('biaya.update');
            Route::delete('/biaya/{id}', [MasterDataController::class, 'destroyBiaya'])->name('biaya.destroy');

            Route::get('/wilayah', [MasterDataController::class, 'wilayah'])->name('wilayah');
            Route::post('/wilayah', [MasterDataController::class, 'storeWilayah'])->name('wilayah.store');
            Route::post('/wilayah/quick-add', [MasterDataController::class, 'quickAddWilayah'])->name('wilayah.quick-add');
            Route::get('/wilayah/{id}/edit', [MasterDataController::class, 'editWilayah'])->name('wilayah.edit');
            Route::put('/wilayah/{id}', [MasterDataController::class, 'updateWilayah'])->name('wilayah.update');
            Route::delete('/wilayah/{id}', [MasterDataController::class, 'destroyWilayah'])->name('wilayah.destroy');

            Route::get('/syarat', [MasterDataController::class, 'syarat'])->name('syarat');
            Route::get('/wilayah/get-kabupaten', [MasterDataController::class, 'getKabupatenByProvinsi'])->name('wilayah.get-kabupaten');
            Route::get('/wilayah/get-kecamatan', [MasterDataController::class, 'getKecamatanByKabupaten'])->name('wilayah.get-kecamatan');
            Route::get('/wilayah/get-kelurahan', [MasterDataController::class, 'getKelurahanByKecamatan'])->name('wilayah.get-kelurahan');
        });

        // MONITORING
        Route::prefix('monitoring-pendaftar')->name('monitoring.pendaftar.')->group(function () {
            Route::get('/', [MonitoringController::class, 'index'])->name('index');
            Route::get('/detail/{id}', [MonitoringController::class, 'show'])->name('detail');
            Route::put('/update-status/{id}', [MonitoringController::class, 'updateStatus'])->name('update-status');
        });

        // PETA
        Route::prefix('peta-sebaran')->name('peta.sebaran.')->group(function () {
            Route::get('/', [PetaController::class, 'index'])->name('index');
            Route::get('/data', [PetaController::class, 'getData'])->name('data');
        });

        // LAPORAN
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/pendaftar', [LaporanController::class, 'pendaftar'])->name('pendaftar');
            Route::get('/pendaftar/export', [LaporanController::class, 'exportPendaftar'])->name('pendaftar.export');
            Route::get('/pendaftar/export-manual', [LaporanController::class, 'exportPendaftarManual'])->name('pendaftar.export-manual');
            Route::get('/keuangan', [LaporanController::class, 'keuangan'])->name('keuangan');
        });

        // USER MANAGEMENT
        Route::prefix('akun')->name('akun.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::put('/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | KEPALA SEKOLAH
    |--------------------------------------------------------------------------
    */
    Route::prefix('kepsek')->name('kepsek.')->group(function () {
        Route::get('/dashboard', [KepsekController::class, 'dashboard'])->name('dashboard');
        Route::get('/hasil-seleksi', [KepsekController::class, 'hasilSeleksi'])->name('hasil-seleksi');
        Route::get('/hasil-seleksi/export', [KepsekController::class, 'exportHasilSeleksi'])->name('hasil-seleksi.export');
        Route::get('/hasil-seleksi/print', [KepsekController::class, 'printHasilSeleksi'])->name('hasil-seleksi.print');
        Route::get('/peta-sebaran', [KepsekController::class, 'petaSebaran'])->name('peta-sebaran');
    });

}); // ⬅️ MENUTUP middleware(['auth'])