<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\Pengguna;
use Carbon\Carbon;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LOGIN PESERTA (Email / NISN)
    |--------------------------------------------------------------------------
    */
    public function loginPeserta(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = Pengguna::where(function ($q) use ($request) {
            $q->where('email', $request->input('email'))
              ->orWhere('hp', $request->input('email'));
        })
        ->where('role', 'pendaftar')
        ->first();

        if (!$user) {
            return back()->with('error', 'Email/NISN tidak ditemukan.')->withInput();
        }

        if (!Hash::check($request->input('password'), $user->password_hash)) {
            return back()->with('error', 'Password salah.')->withInput();
        }

        if (!$user->aktif) {
            return back()->with('error', 'Akun tidak aktif. Silakan hubungi administrator.');
        }

        if (!$user->is_verified) {
            return back()
                ->with('error', 'Akun belum diverifikasi. Silakan cek email kamu untuk kode OTP.')
                ->with('showOtpModal', true)
                ->withInput();
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER PESERTA (Dengan OTP) - OTP HANYA DI EMAIL
    |--------------------------------------------------------------------------
    */
    public function registerPeserta(Request $request)
    {
        if (config('app.debug')) {
            \Log::info('=== REGISTER PROCESS STARTED ===');
            \Log::info('Request Data:', $request->all());
        }

        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|size:10|unique:pengguna,hp',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            if (config('app.debug')) {
                \Log::error('Validation Failed:', $validator->errors()->toArray());
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan validasi',
                'errors' => $validator->errors()
            ], 422);
        }

        $otp = rand(100000, 999999);
        if (config('app.debug')) {
            \Log::info('Generated OTP: ' . $otp);
        }

        try {
            $user = Pengguna::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'hp' => $request->nisn,
                'password_hash' => Hash::make($request->password),
                'role' => 'pendaftar',
                'aktif' => 1,
                'is_verified' => 0,
                'otp_code' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(30),
            ]);

            if (config('app.debug')) {
                \Log::info('User created successfully: ' . $user->email);
            }

            // KIRIM EMAIL OTP
            $emailSent = false;
            $emailError = null;

            try {
                Mail::send('emails.otp', [
                    'nama' => $user->nama,
                    'otp' => $otp,
                    'expires' => 30
                ], function ($message) use ($user) {
                    $message->to($user->email)
                           ->subject('Verifikasi Akun - Kode OTP SPMB SMK Bakti Nusantara 666');
                });
                
                $emailSent = true;
                if (config('app.debug')) {
                    \Log::info('Email OTP berhasil dikirim ke: ' . $user->email);
                }
                
            } catch (\Exception $emailException) {
                $emailSent = false;
                $emailError = $emailException->getMessage();
                if (config('app.debug')) {
                    \Log::error('GAGAL KIRIM EMAIL: ' . $emailError);
                }
            }

            // PESAN RESPONSE TANPA OTP
            if ($emailSent) {
                $message = 'Pendaftaran berhasil! Silakan cek email Anda untuk kode OTP.';
            } else {
                $message = 'Pendaftaran berhasil! Namun kami mengalami kendala mengirim email OTP. Silakan klik "Kirim Ulang OTP" atau hubungi administrator.';
                if (config('app.debug')) {
                    \Log::warning('Email gagal dikirim untuk: ' . $user->email);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => $message,
                'showOtpModal' => true,
                'email' => $user->email,
                'email_sent' => $emailSent
                // OTP TIDAK DIMASUKKAN DALAM RESPONSE
            ], 201);

        } catch (\Exception $e) {
            if (config('app.debug')) {
                \Log::error('REGISTER PROCESS FAILED: ' . $e->getMessage());
            }
            
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI OTP
    |--------------------------------------------------------------------------
    */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data OTP tidak valid'
            ], 422);
        }

        try {
            $user = Pengguna::where('email', $request->email)
                ->where('otp_code', $request->otp)
                ->where('otp_expires_at', '>', Carbon::now())
                ->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Kode OTP tidak valid atau sudah kadaluarsa.'
                ], 400);
            }

            $user->update([
                'is_verified' => 1,
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            Auth::login($user);
            $request->session()->regenerate();

            return response()->json([
                'status' => 'success',
                'message' => 'Verifikasi berhasil! Anda akan diarahkan ke dashboard.',
                'redirect' => route('peserta.dashboard')
            ]);

        } catch (\Exception $e) {
            \Log::error('OTP Verification Error: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESEND OTP - OTP HANYA DI EMAIL
    |--------------------------------------------------------------------------
    */
    public function resendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak valid'
            ], 422);
        }

        $user = Pengguna::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak ditemukan.'
            ], 404);
        }

        if ($user->is_verified) {
            return response()->json([
                'status' => 'info',
                'message' => 'Akun sudah diverifikasi.'
            ]);
        }

        $otp = rand(100000, 999999);
        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(30)
        ]);

        // KIRIM OTP KE EMAIL
        $emailSent = false;
        
        try {
            Mail::send('emails.otp', [
                'nama' => $user->nama,
                'otp' => $otp,
                'expires' => 30
            ], function ($message) use ($user) {
                $message->to($user->email)
                       ->subject('Kode OTP Baru - SPMB SMK Bakti Nusantara 666');
            });
            
            $emailSent = true;
            if (config('app.debug')) {
                \Log::info("Email OTP baru berhasil dikirim ke: {$user->email}");
            }
            
        } catch (\Exception $e) {
            $emailSent = false;
            if (config('app.debug')) {
                \Log::error('Gagal mengirim email OTP: ' . $e->getMessage());
            }
        }

        // PESAN RESPONSE TANPA OTP
        if ($emailSent) {
            $message = 'Kode OTP baru telah dikirim ke email Anda.';
        } else {
            $message = 'Gagal mengirim OTP. Silakan coba lagi atau hubungi administrator.';
        }
        
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'showOtpModal' => true,
            'email' => $user->email,
            'email_sent' => $emailSent
            // OTP TIDAK DIMASUKKAN DALAM RESPONSE
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN ADMIN
    |--------------------------------------------------------------------------
    */
    public function showAdminLogin()
    {
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'verifikator_adm', 'keuangan', 'kepsek'])) {
            return $this->redirectToBackendDashboard(Auth::user()->role);
        }

        return view('auth.admin_login');
    }

    public function loginAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = Pengguna::where('email', $request->email)
            ->whereIn('role', ['admin', 'verifikator_adm', 'keuangan', 'kepsek'])
            ->first();

        if (!$user || !Hash::check($request->password, $user->password_hash)) {
            return back()->with('error', 'Email atau password salah.');
        }

        if (!$user->aktif) {
            return back()->with('error', 'Akun tidak aktif. Silakan hubungi administrator.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectToBackendDashboard($user->role);
    }

    private function redirectToBackendDashboard($role)
    {
        return match ($role) {
            'admin' => redirect('/admin/dashboard'),
            'verifikator_adm' => redirect('/verifikator/dashboard'),
            'keuangan' => redirect('/keuangan/dashboard'),
            'kepsek' => redirect('/kepsek/dashboard'),
            default => redirect('/')->with('error', 'Role tidak dikenali.'),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logoutPeserta(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
    // Removed development/test methods: testEmail() and checkEmailConfig()
}