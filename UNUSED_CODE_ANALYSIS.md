# Analisis Code & File Tidak Terpakai - UJIKOM PPDB

**Tanggal Analisis:** 15 November 2025  
**Project:** UJIKOM PPDB System (Laravel)

---

## 📋 RINGKASAN TEMUAN

Ditemukan **beberapa potential unused code**, **controllers duplikat**, dan **methods yang mungkin tidak digunakan**.

---

## 🚨 MASALAH KRITIS

### 1. **DashboardController - DUPLIKAT (3 copies)** ⚠️
Ditemukan **3 file dengan nama sama** di lokasi berbeda:
```
1. app/Http/Controllers/DashboardController.php
2. app/Http/Controllers/Verifikator/DashboardController.php
3. app/Http/Controllers/Keuangan/DashboardController.php
```

**Status:** Semuanya digunakan di routes berbeda - OK

---

## 📁 CONTROLLERS TIDAK DIGUNAKAN / TIDAK JELAS PENGGUNAANNYA

### 1. **FrontController.php** ⚠️ SUSPECT
```php
public function index()
```
- **Status:** TIDAK DIGUNAKAN di routes/web.php
- **Catatan:** Diganti dengan `DepanController@index` di route `/`
- **Rekomendasi:** DELETE jika sudah sepenuhnya migrated ke DepanController

---

### 2. **AdminController.php** ⚠️ SUSPECT
```php
public function dashboard()
```
- **Route yang digunakan:**
  ```
  Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
  ```
- **Catatan:** Duplicate dengan banyak dashboard lain (kepsek, verifikator, keuangan)
- **Rekomendasi:** Consolidate semua dashboard atau jelaskan tujuannya

---

### 3. **PendaftarController.php** ❓ UNKNOWN
- **File Path:** `app/Http/Controllers/PendaftarController.php`
- **Status:** File ini TIDAK terlihat di routes
- **Catatan:** Mungkin deprecated, diganti dengan `PendaftaranController`
- **Rekomendasi:** CHECK dan DELETE jika tidak digunakan

---

## 🔍 CONTROLLER METHODS YANG TIDAK DIGUNAKAN

### **AuthController.php**
```php
public function testEmail(Request $request)      // Line 365 - TIDAK DI-ROUTE
public function checkEmailConfig()               // Line 410 - TIDAK DI-ROUTE
```
- **Status:** DEBUG/TESTING METHODS
- **Rekomendasi:** Hapus sebelum production atau pindahkan ke testing route

---

### **PendaftaranController.php**
```php
public function checkNik($nik)                   // Line 422 - DEFINED TAPI TIDAK DI-ROUTE
```
- **Status:** Method ada tapi tidak dipanggil di web.php
- **Catatan:** Mungkin untuk development/testing
- **Rekomendasi:** DELETE atau tambahkan ke routes jika diperlukan

---

### **PendaftaranController.php** - DEBUG ROUTES
```
Route::post('/debug/step1')                      // Line 21
Route::post('/debug/step6')                      // Line 22
Route::post('/test/step1')                       // Line 23
Route::get('/refresh-csrf')                      // Line 24
```
- **Status:** DEBUG ROUTES - HARUS DIHAPUS SEBELUM PRODUCTION
- **Rekomendasi:** ⚠️ CRITICAL - Hapus semua debug routes untuk security

---

### **Admin/LaporanController.php**
```php
public function keuangan()                       // Line 286 - INCOMPLETE METHOD
```
- **Status:** Method kosong (hanya returns void)
- **Catatan:** Tidak ada route untuk ini
- **Rekomendasi:** DELETE atau complete implementation

---

### **InformasiController.php**
```php
public function getKuotaData()                   // Seharusnya named 'info.kuota' di route
```
- **Route:** `/informasi/kuota`
- **Method:** `index()` di InformasiController juga ada
- **Rekomendasi:** Consolidate jika ada redundansi

---

## 📄 VIEWS YANG POTENTIALLY TIDAK DIGUNAKAN

### Daftar Views yang perlu dicheck:
```
resources/views/depan/pages/akademik.blade.php
  - Route: Route::get('/akademik', fn() => view(...))
  - Status: Static view - OK

resources/views/depan/pages/faq.blade.php
  - Route: Route::get('/faq', fn() => view(...))
  - Status: Static view - OK

resources/views/depan/pages/kontak.blade.php
  - Route: Route::get('/kontak', fn() => view(...))
  - Status: Static view - OK

resources/views/depan/pages/informasi.blade.php
  - Route: Route::get('/informasi', fn() => view(...))
  - Status: Static view - OK (tapi ada juga InformasiController@index)
  - ⚠️ POTENTIAL DUPLICATE
```

---

## 🗂️ UNUSED IMPORTS DI ROUTES

Di `routes/web.php` ada beberapa import yang tidak digunakan:

```php
use App\Http\Controllers\FrontController;       // NOT USED
```

**Status:** Import ada tapi controller tidak dipanggil di route manapun.

---

## 🔧 UNUSED/INCOMPLETE MIGRATIONS

Cek migrations yang mungkin tidak diapply atau incomplete:
```
database/migrations/2025_11_14_144707_add_bukti_bayar_to_pendaftar_berkas_table.php
  - Status: Documented di attachment - likely OK
```

---

## 🎨 ASSETS (CSS/JS) YANG TIDAK DIREFERENSIKAN

Perlu dicek di `public/` folder:
- Ada file yang tidak dimuat di layout manapun?
- Assets yang di-register di Vite tapi tidak digunakan?

**File config:** `vite.config.js`

---

## 📊 RINGKASAN ACTION ITEMS

### 🔴 CRITICAL (Delete Immediately - Security Risk)
1. ❌ `/debug/step1` route
2. ❌ `/debug/step6` route
3. ❌ `/test/step1` route
4. ❌ `/refresh-csrf` route
5. ❌ `AuthController::testEmail()` method
6. ❌ `AuthController::checkEmailConfig()` method

### 🟠 IMPORTANT (Check & Clean)
1. ❓ `FrontController.php` - Check if migrated to `DepanController`
2. ❓ `PendaftarController.php` - Check if obsolete
3. ❓ `Admin/LaporanController::keuangan()` - Incomplete method
4. ❓ `PendaftaranController::checkNik()` - Unused method
5. ⚠️ Import unused: `FrontController` di `routes/web.php`

### 🟡 RECOMMENDED (Consolidate/Review)
1. 🔀 Multiple dashboard methods - consider consolidation
2. 🔀 Duplicate views (informasi) - rationalize
3. 📝 Review all `debug` code comments in controllers

---

## 🛠️ NEXT STEPS

### Phase 1: Remove Security Risks
```php
// Hapus dari routes/web.php:
// Route::post('/debug/step1', ...)
// Route::post('/debug/step6', ...)
// Route::post('/test/step1', ...)
// Route::get('/refresh-csrf', ...)

// Hapus methods dari AuthController:
// public function testEmail()
// public function checkEmailConfig()
```

### Phase 2: Clean Controllers
- Delete `FrontController.php`
- Check `PendaftarController.php` - delete if obsolete
- Delete incomplete `Admin/LaporanController::keuangan()` method

### Phase 3: Optimize Code
- Consolidate dashboard routes
- Review view usage
- Remove unused imports

---

## 📝 NOTES

- Beberapa methods hanya ada untuk development/debugging
- Ada beberapa routes yang comment out (OK, bukan issue)
- Beberapa controller methods reference view files yang ada (checked)

---

**Generated by Automated Code Analysis**
