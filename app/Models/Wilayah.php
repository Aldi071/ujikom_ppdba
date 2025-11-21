<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';
    
    protected $fillable = [
        'provinsi', 'kabupaten', 'kecamatan', 'kelurahan', 'kodepos'
    ];

    public function dataSiswa()
    {
        return $this->hasMany(PendaftarDataSiswa::class);
    }

    public static function getProvinsi()
    {
        return self::select('provinsi')->distinct()->orderBy('provinsi')->pluck('provinsi');
    }

    public static function getKabupaten($provinsi)
    {
        return self::where('provinsi', $provinsi)->select('kabupaten')->distinct()->orderBy('kabupaten')->pluck('kabupaten');
    }

    /**
     * Get kecamatan list.
     *
     * Flexible signature to preserve backward compatibility:
     * - getKecamatan($provinsi, $kabupaten)
     * - getKecamatan($kabupaten) // returns kecamatan for given kabupaten
     */
    public static function getKecamatan($provinsiOrKabupaten, $kabupaten = null)
    {
        if ($kabupaten === null) {
            // Called with single argument = kabupaten
            $kab = $provinsiOrKabupaten;
            return self::where('kabupaten', $kab)
                ->select('kecamatan')
                ->distinct()
                ->orderBy('kecamatan')
                ->pluck('kecamatan');
        }

        // Called with provinsi and kabupaten
        return self::where('provinsi', $provinsiOrKabupaten)
            ->where('kabupaten', $kabupaten)
            ->select('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->pluck('kecamatan');
    }

    /**
     * Get kelurahan rows.
     *
     * Flexible signature:
     * - getKelurahan($provinsi, $kabupaten, $kecamatan)
     * - getKelurahan($kecamatan) // returns rows where kecamatan matches
     */
    public static function getKelurahan($provinsiOrKecamatan, $kabupaten = null, $kecamatan = null)
    {
        // If only one arg provided, treat it as kecamatan
        if ($kabupaten === null && $kecamatan === null) {
            $kec = $provinsiOrKecamatan;
            return self::where('kecamatan', $kec)->get();
        }

        // Called with provinsi, kabupaten, kecamatan
        return self::where('provinsi', $provinsiOrKecamatan)
            ->where('kabupaten', $kabupaten)
            ->where('kecamatan', $kecamatan)
            ->get();
    }
}