<?php

namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Log;

class ActivityLog
{
    /**
     * Record user activity
     */
    public static function record($aksi, $objek, $objek_data = null)
    {
        try {
            if (!Auth::check()) {
                return false;
            }

            LogAktivitas::create([
                'user_id' => Auth::user()->id,
                'aksi' => $aksi,
                'objek' => $objek,
                'objek_data' => $objek_data,
                'waktu' => now(),
                'ip' => Request::ip()
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('Error recording activity: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Log LOGIN activity
     */
    public static function logLogin($user_name)
    {
        self::record('LOGIN', 'User: ' . $user_name);
    }

    /**
     * Log LOGOUT activity
     */
    public static function logLogout($user_name)
    {
        self::record('LOGOUT', 'User: ' . $user_name);
    }

    /**
     * Log CREATE activity
     */
    public static function logCreate($objek, $data = null)
    {
        self::record('CREATE', $objek, $data);
    }

    /**
     * Log UPDATE activity
     */
    public static function logUpdate($objek, $data = null)
    {
        self::record('UPDATE', $objek, $data);
    }

    /**
     * Log DELETE activity
     */
    public static function logDelete($objek, $data = null)
    {
        self::record('DELETE', $objek, $data);
    }

    /**
     * Log VIEW activity
     */
    public static function logView($objek)
    {
        self::record('VIEW', $objek);
    }

    /**
     * Log EXPORT activity
     */
    public static function logExport($objek)
    {
        self::record('EXPORT', $objek);
    }

    /**
     * Log VERIFY activity
     */
    public static function logVerify($objek, $status, $data = null)
    {
        self::record('VERIFY', $objek . ' (' . $status . ')', $data);
    }

    /**
     * Log REJECT activity
     */
    public static function logReject($objek, $alasan = null)
    {
        self::record('REJECT', $objek, ['alasan' => $alasan]);
    }
}
