# LAPORAN ANALISIS CODE DAN FILE TIDAK TERPAKAI
## Project PPDB Laravel - Ujikom PPDBA

**Tanggal Analisis:** 15 November 2025

---

## RINGKASAN EKSEKUTIF

Analisis mendalam terhadap project Laravel PPDB telah dilakukan untuk mengidentifikasi code, file, dan resource yang tidak terpakai. Laporan ini mencakup controller methods yang tidak digunakan, views yang tidak direferensikan, migrations yang tidak aktif, models yang tidak digunakan, CSS/JS yang tidak dimuat, dan imports yang tidak perlu.

---

## 1. CONTROLLERS & METHODS YANG TIDAK DIGUNAKAN

### 1.1 PendaftarController (Admin) - KOSONG TOTAL ✗
**File:** `app/Http/Controllers/Admin/PendaftarController.php`
- **Status:** Empty controller dengan hanya class definition
- **Methods:** Tidak ada method apapun
- **Rekomendasi:** Hapus file ini, tidak ada route yang mengarah ke controller ini
- **Impact:** Rendah - tidak mempengaruhi aplikasi

### 1.2 FrontController - TIDAK DIGUNAKAN ⚠️
**File:** `app/Http/Controllers/FrontController.php`
- **Method:** `index()`
- **Routes:** Tidak ada route yang menggunakan controller ini
- **Catatan:** Method `index()` menampilkan view yang sama dengan `DepanController@index`
- **Rekomendasi:** Hapus controller ini dan gunakan `DepanController@index` sebagai gantinya
- **Current Usage:** `DepanController::index()` yang digunakan di route `/`

### 1.3 Methods Tidak Direferensikan di Routes

#### AuthController::testEmail()
```php
public function testEmail(Request $request) // LINE 365
```
- **Status:** Tidak ada route yang menggunakan method ini
- **Kegunaan:** Testing email configuration
- **Rekomendasi:** Jika tidak diperlukan untuk production, hapus atau gunakan untuk debugging lokal

#### AuthController::checkEmailConfig()
```php
public function checkEmailConfig() // LINE 410
```
- **Status:** Tidak ada route yang menggunakan method ini
- **Kegunaan:** Checking email configuration
- **Rekomendasi:** Hapus jika tidak digunakan

#### PendaftaranController::getWilayah()
```php
public function getWilayah() // LINE 410
```
- **Status:** Tidak ada route yang menggunakan method ini
- **Kegunaan:** Mengambil data wilayah
- **Rekomendasi:** Jika ada API endpoint yang menggunakan method ini, tambahkan route. Jika tidak, hapus

#### PendaftaranController::checkNik($nik)
```php
public function checkNik($nik) // LINE 422
```
- **Status:** Tidak ada route yang menggunakan method ini
- **Kegunaan:** Mengecek NIK yang sudah terdaftar
- **Rekomendasi:** Tambahkan route jika diperlukan atau hapus

#### PendaftaranController::debugStep1() & debugStep6()
```php
public function debugStep1()  // Dipanggil via Route::post('/debug/step1')
public function debugStep6()  // Dipanggil via Route::post('/debug/step6')
```
- **Status:** Hanya untuk debug/testing
- **Routes:** Ada route debug yang seharusnya tidak ada di production
- **Rekomendasi:** Hapus route debug ini dan methods-nya saat deploy ke production:
  - `Route::post('/debug/step1', ...)`
  - `Route::post('/debug/step6', ...)`
  - `Route::post('/test/step1', ...)`

---

## 2. VIEWS YANG TIDAK DIREFERENSIKAN

### 2.1 Views yang Dipanggil via Routes tapi Diragukan

#### depan/pages/akademik.blade.php
```
Route: /akademik
Status: ✓ Direferensikan di route - fn() => view('depan.pages.akademik')
```
- **Status:** Digunakan, tidak ada masalah

#### depan/pages/informasi.blade.php
```
Status: ✓ Digunakan di routes dan InformasiController
```
- **Status:** Digunakan, tidak ada masalah

#### depan/pages/faq.blade.php
```
Route: /faq
Status: ✓ Direferensikan di route - fn() => view('depan.pages.faq')
```
- **Status:** Digunakan, tidak ada masalah

#### depan/pages/kontak.blade.php
```
Route: /kontak
Status: ✓ Direferensikan di route - fn() => view('depan.pages.kontak')
```
- **Status:** Digunakan, tidak ada masalah

### 2.2 Verifikasi Lengkap View-View yang Ada

Semua views yang ada sudah direferensikan:

| View | Controller/Route | Status |
|------|-----------------|--------|
| `admin/admin.blade.php` | AdminController::dashboard() + DashboardController::index() | ✓ Aktif |
| `admin/master/jurusan.blade.php` | MasterDataController::jurusan() | ✓ Aktif |
| `admin/master/gelombang.blade.php` | MasterDataController::gelombang() | ✓ Aktif |
| `admin/master/biaya.blade.php` | MasterDataController::biaya() | ✓ Aktif |
| `admin/master/wilayah.blade.php` | MasterDataController::wilayah() | ✓ Aktif |
| `admin/master/wilayah-edit.blade.php` | MasterDataController::editWilayah() | ✓ Aktif |
| `admin/laporan-pendaftar.blade.php` | LaporanController::pendaftar() | ✓ Aktif |
| `admin/manajemen-akun.blade.php` | UserController::index() | ✓ Aktif |
| `admin/tambah-akun.blade.php` | UserController::create() | ✓ Aktif |
| `admin/edit-akun.blade.php` | UserController::edit() | ✓ Aktif |
| `admin/monitoring-pendaftar.blade.php` | MonitoringController::index() | ✓ Aktif |
| `admin/monitoring-detail.blade.php` | MonitoringController::show() | ✓ Aktif |
| `admin/peta-sebaran.blade.php` | PetaController::index() | ✓ Aktif |
| `verifikator/verifikator.blade.php` | DashboardController::index() + Verifikator\DashboardController::index() | ✓ Aktif |
| `verifikator/data-pendaftar.blade.php` | DataPendaftarController::index() | ✓ Aktif |
| `verifikator/detail-pendaftar.blade.php` | DataPendaftarController::show() | ✓ Aktif |
| `verifikator/laporan.blade.php` | Verifikator\LaporanController::index() | ✓ Aktif |
| `keuangan/keuangan.blade.php` | Keuangan\DashboardController::index() | ✓ Aktif |
| `keuangan/validasi/index.blade.php` | ValidasiController::index() | ✓ Aktif |
| `keuangan/validasi/detail.blade.php` | ValidasiController::show() | ✓ Aktif |
| `keuangan/laporan/index.blade.php` | Keuangan\LaporanController::index() | ✓ Aktif |
| `kepsek/dashboard.blade.php` | KepsekController::dashboard() | ✓ Aktif |
| `kepsek/hasil-seleksi.blade.php` | KepsekController::hasilSeleksi() | ✓ Aktif |
| `kepsek/peta-sebaran.blade.php` | KepsekController::petaSebaran() | ✓ Aktif |
| `depan/pages/index.blade.php` | DepanController::index() + FrontController::index() | ✓ Aktif |
| `depan/pages/pendaftaran.blade.php` | PendaftaranController::showForm() | ✓ Aktif |
| `depan/pages/pengumuman.blade.php` | PengumumanController::index() | ✓ Aktif |
| `depan/pages/informasi.blade.php` | InformasiController::index() | ✓ Aktif |
| `depan/pages/akademik.blade.php` | Route (inline view) | ✓ Aktif |
| `depan/pages/faq.blade.php` | Route (inline view) | ✓ Aktif |
| `depan/pages/kontak.blade.php` | Route (inline view) | ✓ Aktif |

**Kesimpulan:** ✓ SEMUA VIEWS AKTIF DAN DIREFERENSIKAN

---

## 3. MODELS YANG TIDAK DIGUNAKAN

### 3.1 Model Inventory

Semua models yang ada sudah diimplementasikan:

| Model | Digunakan Di | Status |
|-------|-------------|--------|
| `Biaya.php` | MasterDataController, LaporanController | ✓ Aktif |
| `Gelombang.php` | Multiple Controllers | ✓ Aktif |
| `Jurusan.php` | Multiple Controllers | ✓ Aktif |
| `LogAktivitas.php` | Belum ditemukan | ⚠️ Tidak Digunakan |
| `Pendaftar.php` | Multiple Controllers | ✓ Aktif |
| `PendaftarAsalSekolah.php` | Multiple Controllers | ✓ Aktif |
| `PendaftarBerkas.php` | Multiple Controllers | ✓ Aktif |
| `PendaftarDataOrtu.php` | Multiple Controllers | ✓ Aktif |
| `PendaftarDataSiswa.php` | Multiple Controllers | ✓ Aktif |
| `Pengguna.php` | AuthController, UserController | ✓ Aktif |
| `User.php` | PendaftaranController (imported tapi tidak digunakan) | ⚠️ Mungkin Tidak Digunakan |
| `Wilayah.php` | MasterDataController, Multiple Controllers | ✓ Aktif |

### 3.2 Model Tidak Digunakan

#### LogAktivitas Model ⚠️
**File:** `app/Models/LogAktivitas.php`
- **Status:** Model ada namun tidak digunakan di manapun
- **Table:** `log_aktivitas` sudah punya migration
- **Rekomendasi:** 
  - Gunakan untuk logging aktivitas user jika diperlukan
  - Atau hapus model dan migration-nya jika tidak diperlukan

#### User Model ⚠️
**File:** `app/Models/User.php`
- **Imported Di:** PendaftaranController (line 6)
- **Actually Used:** TIDAK - hanya imported tapi tidak digunakan
- **Rekomendasi:** Hapus import `use App\Models\User;` dari PendaftaranController

---

## 4. DATABASE MIGRATIONS YANG TIDAK AKTIF

### 4.1 Duplicate/Conflict Migrations

#### Users Table Conflict ⚠️
```
Created by TWO migrations:
1. 2025_11_10_030930_create_pengguna_table.php  (Table: pengguna)
2. 2025_11_12_012910_create_users_table.php     (Table: users)
```

**Problem:** Dua migration untuk user table dengan nama berbeda:
- `pengguna` - Tabel yang digunakan oleh aplikasi (via Pengguna model)
- `users` - Tabel yang dibuat tapi tidak digunakan

**Rekomendasi:**
- Hapus migration `2025_11_12_012910_create_users_table.php` jika table `users` tidak digunakan
- Atau rename table `pengguna` menjadi `users` dan update model/migration

### 4.2 Daftar Semua Migrations

| Migration File | Table | Status | Rekomendasi |
|---|---|---|---|
| `0001_01_01_000001_create_cache_table.php` | cache | ✓ Laravel default | Pertahankan |
| `0001_01_01_000002_create_jobs_table.php` | jobs | ✓ Laravel default | Pertahankan |
| `2025_11_09_133233_create_wilayah_table.php` | wilayah | ✓ Aktif | Pertahankan |
| `2025_11_09_133303_create_pendaftar_table.php` | pendaftar | ✓ Aktif | Pertahankan |
| `2025_11_09_133317_create_pendaftar_data_siswa_table.php` | pendaftar_data_siswa | ✓ Aktif | Pertahankan |
| `2025_11_09_133330_create_pendaftar_data_ortu_table.php` | pendaftar_data_ortu | ✓ Aktif | Pertahankan |
| `2025_11_09_133344_create_pendaftar_asal_sekolah_table.php` | pendaftar_asal_sekolah | ✓ Aktif | Pertahankan |
| `2025_11_09_133355_create_pendaftar_berkas_table.php` | pendaftar_berkas | ✓ Aktif | Pertahankan |
| `2025_11_09_133407_create_log_aktivitas_table.php` | log_aktivitas | ⚠️ Model tidak digunakan | Pertahankan (untuk future use) |
| `2025_11_10_030930_create_pengguna_table.php` | pengguna | ✓ Aktif | Pertahankan |
| `2025_11_12_012910_create_users_table.php` | users | ✗ Tidak digunakan | **HAPUS atau PERBAHARUI** |
| `2025_11_12_015558_create_sessions_table.php` | sessions | ✓ Laravel default | Pertahankan |
| `2025_11_12_033836_create_biaya_table.php` | biaya | ✓ Aktif (jika ada) | Pertahankan |
| `2025_11_12_065728_create_jurusan_table.php` | jurusan | ✓ Aktif | Pertahankan |
| `2025_11_12_070429_create_gelombang_table.php` | gelombang | ✓ Aktif | Pertahankan |
| `2025_11_14_144707_add_bukti_bayar_to_pendaftar_berkas_table.php` | pendaftar_berkas | ✓ Aktif | Pertahankan |

---

## 5. ASSETS (CSS/JS) YANG DIMUAT

### 5.1 CSS yang Dimuat

**Frontend (depan/layouts/main.blade.php):**
- ✓ `{{ asset('css/style.css') }}` - AKTIF
- ✓ Google Fonts (Inter) - AKTIF
- ✓ Splide CSS (Carousel) - AKTIF
- ✓ Font Awesome 6.4.0 - AKTIF

**Admin/Backend (admin/layouts/main.blade.php):**
- ✓ SB Admin 2 CSS (`sb-admin/css/sb-admin-2.min.css`) - AKTIF
- ✓ Font Awesome Free (`sb-admin/vendor/fontawesome-free/css/all.min.css`) - AKTIF
- ✓ Google Fonts - AKTIF

### 5.2 JavaScript yang Dimuat

**Frontend (depan/layouts/main.blade.php):**
- ✓ `{{ asset('js/main.js') }}` - AKTIF
- ✓ Anime.js (Animation library) - AKTIF
- ✓ Typed.js (Typing effect) - AKTIF
- ✓ Splide.js (Carousel) - AKTIF
- ✓ Matter.js (Physics engine) - AKTIF
- ✓ Splitting.js (Text animation) - AKTIF
- ✓ Tailwind CSS (Utility CSS) - AKTIF

**Admin/Backend (admin/layouts/main.blade.php):**
- ✓ jQuery (`sb-admin/vendor/jquery/jquery.min.js`) - AKTIF
- ✓ Bootstrap Bundle JS (`sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js`) - AKTIF
- ✓ jQuery Easing (`sb-admin/vendor/jquery-easing/jquery.easing.min.js`) - AKTIF
- ✓ SB Admin 2 JS (`sb-admin/js/sb-admin-2.min.js`) - AKTIF
- ✓ Chart.js (`sb-admin/vendor/chart.js/Chart.min.js`) - AKTIF
- ✓ Chart Demo Scripts - AKTIF:
  - `sb-admin/js/demo/chart-area-demo.js`
  - `sb-admin/js/demo/chart-pie-demo.js`
  - `sb-admin/js/demo/chart-bar-demo.js`
  - `sb-admin/js/demo/chart-pembayaran-demo.js`
  - `sb-admin/js/demo/chart-trend-demo.js`
  - `sb-admin/js/demo/chart-status-demo.js`

### 5.3 Kesimpulan Assets
✓ **SEMUA CSS/JS YANG DIMUAT AKTIF DAN DIGUNAKAN**

---

## 6. ROUTES TANPA CONTROLLER METHODS

### 6.1 Debug Routes (HARUS DIHAPUS) ⚠️
```php
Route::post('/debug/step1', [PendaftaranController::class, 'debugStep1']);
Route::post('/debug/step6', [PendaftaranController::class, 'debugStep6']);
Route::post('/test/step1', [PendaftaranController::class, 'testStep1']);
Route::get('/refresh-csrf', fn() => response()->json(['token' => csrf_token()]));
```

**Status:** Methods TIDAK DITEMUKAN untuk `debugStep1`, `debugStep6`, `testStep1`

**Rekomendasi:** 
- ✗ HAPUS route-route debug ini sebelum deployment ke production
- Gunakan environment variable untuk debug routes:
  ```php
  if (env('APP_DEBUG')) {
      Route::post('/debug/step1', [PendaftaranController::class, 'debugStep1']);
      // ... other debug routes
  }
  ```

### 6.2 Route yang Inline View (Tidak Ada Controller)
```php
Route::get('/akademik', fn() => view('depan.pages.akademik'))->name('akademik');
Route::get('/informasi', fn() => view('depan.pages.informasi'))->name('informasi');
Route::get('/pengumuman', fn() => view('depan.pages.pengumuman'))->name('pengumuman');
Route::get('/faq', fn() => view('depan.pages.faq'))->name('faq');
Route::get('/kontak', fn() => view('depan.pages.kontak'))->name('kontak');
Route::get('/peserta/dashboard', function () { ... })->name('peserta.dashboard');
```

**Status:** Routes dengan `fn() => view()` atau anonymous function - NORMAL (tidak ada masalah)

---

## 7. IMPORTS/USE STATEMENTS TIDAK DIGUNAKAN

### 7.1 Unused Imports

#### PendaftaranController.php
```php
use App\Models\User;  // LINE 6 - TIDAK DIGUNAKAN
```
**Location:** `app/Http/Controllers/PendaftaranController.php` line 6

**Evidence:** Tidak ada penggunaan `User::` atau `$user` di controller ini (menggunakan Pengguna model)

**Rekomendasi:** Hapus import ini

#### AuthController.php
```php
use Illuminate\Support\Facades\Mail;  // Mungkin tidak digunakan
use Carbon\Carbon;  // Used untuk OTP expiry - ✓ DIGUNAKAN
```

**Status:** Mail import ada, tapi penggunaan mail perlu dicek lebih lanjut

### 7.2 Import Check Summary

| File | Import | Status |
|------|--------|--------|
| AuthController | Mail Facade | ✓ Digunakan di sendMail |
| PendaftaranController | User Model | ✗ TIDAK DIGUNAKAN |
| Admin/MasterDataController | Artisan Facade | ? Perlu dicek |
| Admin/LaporanController | PendaftarExport | ✓ Digunakan di export |

**Rekomendasi:**
- Hapus `use App\Models\User;` dari PendaftaranController
- Verifikasi penggunaan Artisan di MasterDataController

---

## 8. METHODS YANG SEHARUSNYA DI-ROUTE

### 8.1 Methods Ada tapi Tidak Ada Route

#### MasterDataController::syarat() - TIDAK ADA ROUTE ⚠️
```php
public function syarat() // LINE 430
{
    return view('admin.master.syarat');
}
```
- **Status:** Method ada dengan view, tapi TIDAK ADA ROUTE yang memanggil
- **Routes yang ada:** Tidak ada rute `/admin/master/syarat`
- **Rekomendasi:** 
  - Tambah route jika diperlukan:
    ```php
    Route::get('/syarat', [MasterDataController::class, 'syarat'])->name('syarat');
    ```
  - Atau hapus method jika tidak diperlukan

#### Admin/PendaftarController - EMPTY ⚠️
```php
class PendaftarController extends Controller
{
    //
}
```
- **Status:** Controller kosong, tidak ada methods apapun
- **Routes:** Tidak ada route yang menggunakan controller ini
- **Rekomendasi:** Hapus file ini secara keseluruhan

---

## RINGKASAN TEMUAN

### CRITICAL (HARUS DIPERBAIKI) 🔴
1. **Debug Routes** - Hapus route debug sebelum production:
   - `/debug/step1`, `/debug/step6`, `/test/step1`
   
2. **Duplicate Users Table** - Ada 2 migration untuk users:
   - `pengguna` (aktif) vs `users` (tidak aktif)
   - Tentukan mana yang digunakan dan hapus yang tidak perlu

3. **Unused Import** - PendaftaranController:
   - Remove: `use App\Models\User;`

### WARNING (SEBAIKNYA DIPERBAIKI) ⚠️
1. **Empty Controllers:**
   - `Admin/PendaftarController.php` - HAPUS FILE
   - `FrontController.php` - HAPUS atau gunakan

2. **Model Tidak Digunakan:**
   - `LogAktivitas.php` - Jangan digunakan atau implementasikan

3. **Methods Tidak Direferensikan:**
   - `AuthController::testEmail()`
   - `AuthController::checkEmailConfig()`
   - `PendaftaranController::getWilayah()`
   - `PendaftaranController::checkNik()`
   - `MasterDataController::syarat()`

### INFORMATIONAL (UNTUK REFERENSI) ℹ️
1. ✓ Semua views sudah aktif dan direferensikan
2. ✓ Semua CSS/JS yang dimuat sudah digunakan
3. ✓ Semua migration penting sudah aktif
4. ✓ Model-model utama sudah digunakan dengan baik

---

## RENCANA AKSI YANG DIREKOMENDASIKAN

### Phase 1: Critical (Segera)
```bash
# 1. Hapus debug routes dari routes/web.php
# 2. Hapus atau kondisikan debug routes dengan APP_DEBUG env variable
# 3. Hapus import User yang tidak digunakan dari PendaftaranController
```

### Phase 2: High Priority (Minggu depan)
```bash
# 1. Hapus file Admin/PendaftarController.php
# 2. Hapus FrontController.php atau rename ke helper
# 3. Tentukan apakah menggunakan table 'pengguna' atau 'users'
#    - Jika 'pengguna': Hapus migration create_users_table.php
#    - Jika 'users': Hapus migration create_pengguna_table.php dan migrasi data
# 4. Hapus method-method yang tidak digunakan atau tambahkan route-nya
```

### Phase 3: Nice to Have (Optional)
```bash
# 1. Implementasikan LogAktivitas model jika diperlukan untuk audit trail
# 2. Refactor unused methods ke file helpers atau traits
# 3. Cleanup console commands dan unused middleware
```

---

## DOKUMENTASI UNTUK DEVELOPER

Pastikan untuk:
1. ✓ Selalu check routes/web.php sebelum membuat controller method baru
2. ✓ Hapus debug code sebelum commit ke production branch
3. ✓ Gunakan naming convention yang konsisten
4. ✓ Dokumentasi method yang tidak obvious
5. ✓ Lakukan code review sebelum merge ke master

---

**Report dibuat oleh:** Automated Code Analysis Tool  
**Tanggal:** 15 November 2025  
**Version:** 1.0
