# CLEANUP CHECKLIST - ACTIONABLE ITEMS

## Quick Reference untuk Cleanup

### 🔴 CRITICAL - Lakukan Sekarang

- [ ] **Remove Debug Routes** 
  - File: `routes/web.php`
  - Lines: 22-23
  - Action: Hapus atau wrap dengan `if (env('APP_DEBUG'))`
  ```php
  // DELETE OR WRAP WITH ENV CHECK:
  Route::post('/debug/step1', [PendaftaranController::class, 'debugStep1']);
  Route::post('/debug/step6', [PendaftaranController::class, 'debugStep6']);
  Route::post('/test/step1', [PendaftaranController::class, 'testStep1']);
  Route::get('/refresh-csrf', fn() => response()->json(['token' => csrf_token()]));
  ```

- [ ] **Remove Unused Import**
  - File: `app/Http/Controllers/PendaftaranController.php`
  - Line: 6
  - Action: Hapus baris ini
  ```php
  // DELETE THIS LINE:
  use App\Models\User;
  ```

- [ ] **Resolve Users Table Conflict**
  - Option A: Jika menggunakan `pengguna` table
    - Hapus: `database/migrations/2025_11_12_012910_create_users_table.php`
  - Option B: Jika ingin menggunakan `users` table (Laravel standard)
    - Hapus: `database/migrations/2025_11_10_030930_create_pengguna_table.php`
    - Rename: Model dari `Pengguna` menjadi `User`
    - Update: Semua import dan penggunaan model

---

### ⚠️ HIGH PRIORITY - Minggu Depan

- [ ] **Hapus Empty Controller**
  - File: `app/Http/Controllers/Admin/PendaftarController.php`
  - Action: Hapus file sepenuhnya
  ```bash
  # Command untuk hapus:
  rm app/Http/Controllers/Admin/PendaftarController.php
  ```

- [ ] **Konsolidasikan Front Controller**
  - File: `app/Http/Controllers/FrontController.php`
  - Action: Pilih salah satu:
    - Option 1: Hapus FrontController, gunakan DepanController
    - Option 2: Rename FrontController menjadi DepanController
  ```php
  // CURRENT (routes/web.php):
  Route::get('/', [DepanController::class, 'index'])->name('home');
  // FrontController::index() hanya duplicate
  ```

- [ ] **Hapus atau Implementasikan Debug Methods**
  - File: `app/Http/Controllers/PendaftaranController.php`
  - Methods:
    - `debugStep1()` - Jika untuk debug, hapus setelah testing
    - `debugStep6()` - Jika untuk debug, hapus setelah testing
    - `testStep1()` - Jika untuk testing, pindah ke test file

- [ ] **Tambah atau Hapus Route untuk syarat()**
  - File: `app/Http/Controllers/Admin/MasterDataController.php`
  - Method: `syarat()` pada line 430
  - Pilihan:
    - Tambah route: `Route::get('/syarat', [MasterDataController::class, 'syarat'])->name('syarat');`
    - Atau hapus method dan view jika tidak diperlukan

---

### ℹ️ OPTIONAL - Nice to Have

- [ ] **Implementasikan LogAktivitas**
  - Jika audit trail diperlukan, gunakan model ini
  - Migration sudah ada: `2025_11_09_133407_create_log_aktivitas_table.php`
  - Buat accessor/mutator untuk logging

- [ ] **Unused Method Check**
  - Review methods:
    - `AuthController::testEmail()` - Untuk testing email
    - `AuthController::checkEmailConfig()` - Untuk checking config
    - `PendaftaranController::getWilayah()` - Jika ada API yang membutuhkan
    - `PendaftaranController::checkNik()` - Jika ada validasi NIK
  - Jika tidak digunakan, hapus

---

## Code Snippets untuk Perbaikan

### 1. Conditional Debug Routes
```php
// routes/web.php
if (env('APP_DEBUG', false)) {
    Route::post('/debug/step1', [PendaftaranController::class, 'debugStep1']);
    Route::post('/debug/step6', [PendaftaranController::class, 'debugStep6']);
    Route::post('/test/step1', [PendaftaranController::class, 'testStep1']);
    Route::get('/refresh-csrf', fn() => response()->json(['token' => csrf_token()]));
}
```

### 2. Fix PendaftaranController Imports
```php
// BEFORE:
use App\Models\User;
use App\Models\Pendaftar;
// ... other imports

// AFTER (remove User):
use App\Models\Pendaftar;
// ... other imports
```

### 3. Consolidate FrontController
```php
// OPTION: Delete FrontController entirely
// And make sure route uses DepanController:
Route::get('/', [DepanController::class, 'index'])->name('home');

// Or use same logic in DepanController::index()
```

### 4. Add Missing Route (if needed)
```php
// In routes/web.php, under admin master prefix:
Route::get('/syarat', [MasterDataController::class, 'syarat'])->name('syarat');
```

---

## Verification Checklist After Cleanup

- [ ] Run `php artisan migrate` - Pastikan tidak ada error migration
- [ ] Run `php artisan route:list` - Verify tidak ada route orphan
- [ ] Check routes file - Pastikan tidak ada undefined controller methods
- [ ] Test application:
  - [ ] Frontend routes working
  - [ ] Admin dashboard working
  - [ ] Verifikator dashboard working
  - [ ] Keuangan dashboard working
  - [ ] Kepsek dashboard working
- [ ] Test API endpoints (jika ada)
- [ ] Check Laravel logs - Pastikan tidak ada error atau warning

---

## Files Status Report

### Empty/Unused Files
```
app/Http/Controllers/Admin/PendaftarController.php ................... EMPTY - DELETE
app/Http/Controllers/FrontController.php ............................ DUPLICATE - DELETE or RENAME
```

### Controllers with Unused Methods
```
app/Http/Controllers/AuthController.php
  - testEmail() ..................................................... NOT USED
  - checkEmailConfig() .............................................. NOT USED
  
app/Http/Controllers/PendaftaranController.php
  - debugStep1() .................................................... DEBUG ONLY
  - debugStep6() .................................................... DEBUG ONLY
  - testStep1() ..................................................... TEST ONLY
  - getWilayah() .................................................... NOT USED
  - checkNik() ...................................................... NOT USED
  
app/Http/Controllers/Admin/MasterDataController.php
  - syarat() ........................................................ NO ROUTE
```

### Models Status
```
✓ Biaya.php - Used
✓ Gelombang.php - Used
✓ Jurusan.php - Used
✗ LogAktivitas.php - NOT USED (optional to keep)
✓ Pendaftar.php - Used
✓ PendaftarAsalSekolah.php - Used
✓ PendaftarBerkas.php - Used
✓ PendaftarDataOrtu.php - Used
✓ PendaftarDataSiswa.php - Used
✓ Pengguna.php - Used
✗ User.php - Table created but not used (MIGRATION CONFLICT)
✓ Wilayah.php - Used
```

### Database Tables
```
✓ wilayah - Used
✓ pendaftar - Used
✓ pendaftar_data_siswa - Used
✓ pendaftar_data_ortu - Used
✓ pendaftar_asal_sekolah - Used
✓ pendaftar_berkas - Used
✓ pengguna - Used (PRIMARY USER TABLE)
✗ users - Created but not used (CONFLICT)
○ log_aktivitas - Created but not used (optional)
```

---

## Estimated Time for Cleanup

- **Critical Phase:** 30 minutes
  - Remove debug routes
  - Remove unused import
  - Resolve users table

- **High Priority Phase:** 1-2 hours
  - Delete empty controller
  - Consolidate controllers
  - Clean up methods
  
- **Optional Phase:** 2-4 hours
  - Implement LogAktivitas
  - Full refactor unused methods
  - Comprehensive testing

**Total Estimated Time:** 3-6 hours

---

Generated: November 15, 2025
