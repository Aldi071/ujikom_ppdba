<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pengguna extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pengguna';
    
    protected $fillable = [
        'nama',
        'email',
        'hp',
        'password_hash',
        'role',
        'aktif',
        'otp_code',
        'otp_expires_at',
        'is_verified'
    ];

    protected $hidden = [
        'password_hash',
        'remember_token',
        'otp_code'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'otp_expires_at' => 'datetime',
        'email_verified' => 'boolean'
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Check if OTP is valid and not expired
     */
    public function isOtpValid($otp)
    {
        return $this->otp_code === $otp && 
               $this->otp_expires_at && 
               $this->otp_expires_at->isFuture();
    }

    /**
     * Generate OTP
     */
    public function generateOtp()
    {
        $this->otp_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->otp_expires_at = now()->addMinutes(10); // OTP berlaku 10 menit
        $this->email_verified = false;
        $this->save();

        return $this->otp_code;
    }

    /**
     * Verify OTP and mark email as verified
     */
    public function verifyOtp($otp)
    {
        if ($this->isOtpValid($otp)) {
            $this->email_verified = true;
            $this->otp_code = null;
            $this->otp_expires_at = null;
            $this->aktif = true;
            $this->save();
            return true;
        }
        return false;
    }
}