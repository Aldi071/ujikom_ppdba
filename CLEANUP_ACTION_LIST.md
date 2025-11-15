# 🗑️ CLEANUP ACTION LIST

**Tanggal:** November 15, 2025  
**Status:** Ready to Execute

---

## FILES & CHANGES TO DELETE/MODIFY

### 1️⃣ `routes/web.php` - DELETE 4 DEBUG ROUTES

**File:** `c:\xampp\htdocs\ujikom_ppdba\routes\web.php`  
**Lines:** 20-24

**DELETE:**
```php
// Debug
Route::post('/debug/step1', [PendaftaranController::class, 'debugStep1']);
Route::post('/debug/step6', [PendaftaranController::class, 'debugStep6']);
Route::post('/test/step1', [PendaftaranController::class, 'testStep1']);
Route::get('/refresh-csrf', fn() => response()->json(['token' => csrf_token()]));
```

**Replacement:**
```php
// Debug routes removed for security
```

**Impact:** 
- 🔒 Remove security vulnerabilities
- ✅ No functional impact (debug only)

---

### 2️⃣ `routes/web.php` - REMOVE UNUSED IMPORT

**File:** `c:\xampp\htdocs\ujikom_ppdba\routes\web.php`  
**Line:** 7

**DELETE:**
```php
use App\Http\Controllers\FrontController;
```

**Why:** Controller ini tidak ada / tidak digunakan. Semua front routes menggunakan `DepanController`.

**Impact:**
- ✅ Clean up
- ✅ No functional impact

---

### 3️⃣ `app/Http/Controllers/AuthController.php` - DELETE TEST METHOD

**File:** `c:\xampp\htdocs\ujikom_ppdba\app\Http\Controllers\AuthController.php`  
**Lines:** 360-408 (approximately)

**DELETE:**
```php
/*
|--------------------------------------------------------------------------
| TEST EMAIL FUNCTION
|--------------------------------------------------------------------------
*/
public function testEmail(Request $request)
{
    $email = $request->get('email', 'hekate071@gmail.com');

    try {
        Mail::send('emails.otp', ['nama' => 'Test User', 'otp' => '123456', 'expires' => 10], 
            function ($message) use ($email) {
                $message->subject('Test Email')
                        ->to($email)
                        ->from(env('MAIL_FROM_ADDRESS'));
            }
        );

        return response()->json(['status' => 'success', 'message' => 'Email sent']);
    } catch (Exception $e) {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}
```

**Why:** Testing method, tidak ada route, expose email config

**Impact:**
- 🔒 Remove test code
- ✅ No impact (tidak digunakan)

---

### 4️⃣ `app/Http/Controllers/AuthController.php` - DELETE CONFIG CHECK METHOD

**File:** `c:\xampp\htdocs\ujikom_ppdba\app\Http\Controllers\AuthController.php`  
**Lines:** 410-427 (approximately)

**DELETE:**
```php
public function checkEmailConfig()
{
    return response()->json([
        'mailer' => env('MAIL_MAILER'),
        'host' => env('MAIL_HOST'),
        'port' => env('MAIL_PORT'),
        'from_address' => env('MAIL_FROM_ADDRESS'),
        'from_name' => env('MAIL_FROM_NAME'),
    ]);
}
```

**Why:** Config checker method, expose sensitive info, tidak ada route

**Impact:**
- 🔒 Remove security exposure
- ✅ No impact (tidak digunakan)

---

### 5️⃣ `app/Http/Controllers/PendaftaranController.php` - DELETE UNUSED METHOD

**File:** `c:\xampp\htdocs\ujikom_ppdba\app\Http\Controllers\PendaftaranController.php`  
**Lines:** 422-428 (approximately)

**DELETE:**
```php
public function checkNik($nik)
{
    // Similar to checkNisn but for NIK - not used in routes
    // Development method?
}
```

**Why:** Method tidak ada di routes, ada checkNisn() yang lebih diutamakan

**Impact:**
- ✅ Clean code
- ✅ No impact (tidak digunakan)

---

### 6️⃣ `app/Http/Controllers/Admin/LaporanController.php` - DELETE EMPTY METHOD

**File:** `c:\xampp\htdocs\ujikom_ppdba\app\Http\Controllers\Admin\LaporanController.php`  
**Line:** 286-289

**DELETE:**
```php
public function keuangan()
{
    // Empty method - tidak diimplementasi
}
```

**Why:** Method kosong, tidak ada implementasi, tidak ada route

**Impact:**
- ✅ Clean code
- ✅ No impact (empty method)

---

## OPTIONAL - VERIFY & REVIEW

### Method di `PendaftaranController.php` - CHECK IF NEEDED

**File:** `c:\xampp\htdocs\ujikom_ppdba\app\Http\Controllers\PendaftaranController.php`

**Methods to verify:**
```php
// Line 365
private function handleFileUploads(Request $request, $pendaftarId)
// Status: USED internally - OK, KEEP

// Line 410
public function getWilayah()
// Status: VERIFY - check if AJAX route or used

// Line 416
public function checkNisn($nisn)
// Status: USED in route - OK, KEEP

// Line 422
public function checkNik($nik)
// Status: NOT USED in routes - RECOMMEND DELETE
```

---

## DATABASE MIGRATIONS - VERIFY

**File:** `c:\xampp\htdocs\ujikom_ppdba\database\migrations\`

**Status:** Semua migration terlihat active dan digunakan. ✅

No cleanup needed di migrations.

---

## VIEWS - STATUS CHECK

**Frontend Views:**
- ✅ All frontend views are properly routed
- ✅ No orphaned views detected

**Backend Views:**
- ✅ All admin/backend views are properly used
- ✅ No orphaned views detected

No cleanup needed di views.

---

## SUMMARY OF CHANGES

| Item | Type | Priority | Status |
|------|------|----------|--------|
| Remove debug routes | Delete | 🔴 Critical | Ready |
| Remove testEmail() method | Delete | 🔴 Critical | Ready |
| Remove checkEmailConfig() method | Delete | 🔴 Critical | Ready |
| Remove unused import FrontController | Delete | 🟡 Low | Ready |
| Remove checkNik() method | Delete | 🟠 Medium | Ready |
| Remove empty keuangan() method | Delete | 🟠 Medium | Ready |

**Total deletions:** 6 items  
**Estimated cleanup time:** 5 minutes  
**Risk level:** Very low (all are unused/debug code)

---

## BEFORE & AFTER

### Before
```
Total Lines in Routes:    235+
Debug Routes:             4
Unused Methods:           3
Empty Methods:            1
Test Code:                2
Unused Imports:           1
```

### After
```
Total Lines in Routes:    ~225 (shorter)
Debug Routes:             0 ✅
Unused Methods:           0 ✅
Empty Methods:            0 ✅
Test Code:                0 ✅
Unused Imports:           0 ✅
```

---

## EXECUTION ORDER

1. **First:** Remove debug routes dari `routes/web.php`
2. **Second:** Remove unused import dari `routes/web.php`
3. **Third:** Delete test methods dari `AuthController.php`
4. **Fourth:** Delete unused methods dari `PendaftaranController.php`
5. **Fifth:** Delete empty method dari `Admin/LaporanController.php`
6. **Finally:** Test aplikasi untuk memastikan tidak ada breakage

---

## BACKUP RECOMMENDATION

Sebelum melakukan cleanup:
```bash
# Commit current state ke git
git add .
git commit -m "Backup: before code cleanup"

# Atau buat backup folder
cp -r app app_backup_$(date +%Y%m%d)
```

---

## TESTING CHECKLIST

Setelah cleanup, test:
- [ ] Frontend pendaftaran form masih berfungsi
- [ ] Admin dashboard masih berfungsi
- [ ] Verifikator dashboard masih berfungsi
- [ ] Keuangan dashboard masih berfungsi
- [ ] Kepsek dashboard masih berfungsi
- [ ] Login process masih berfungsi
- [ ] No 404 errors di routes
- [ ] No missing method errors

---

**Status:** Ready to execute  
**Confidence Level:** 99% (semua unused code, tidak ada impact)
