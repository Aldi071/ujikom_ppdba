<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Wilayah;
use App\Models\PendaftarDataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PetaController extends Controller
{
    public function index()
    {
        $jurusanList = Jurusan::where('aktif', 1)->get();
        $totalPendaftar = Pendaftar::count();
        
        // Data untuk statistik
        $pendaftarPerKabupaten = PendaftarDataSiswa::join('pendaftar', 'pendaftar_data_siswa.pendaftar_id', '=', 'pendaftar.id')
            ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
            ->selectRaw('wilayah.kabupaten, COUNT(*) as total')
            ->groupBy('wilayah.kabupaten')
            ->orderBy('total', 'desc')
            ->get();

        // Data jurusan terpopuler per kabupaten
        $popularJurusanPerKabupaten = $this->getPopularJurusanPerKabupaten($pendaftarPerKabupaten);

        return view('admin.peta-sebaran', compact(
            'jurusanList', 
            'totalPendaftar', 
            'pendaftarPerKabupaten',
            'popularJurusanPerKabupaten'
        ));
    }

    private function getPopularJurusanPerKabupaten($pendaftarPerKabupaten)
    {
        $popularJurusanData = [];

        foreach ($pendaftarPerKabupaten as $kabupaten) {
            $popularJurusan = Pendaftar::join('pendaftar_data_siswa', 'pendaftar.id', '=', 'pendaftar_data_siswa.pendaftar_id')
                ->join('wilayah', 'pendaftar_data_siswa.wilayah_id', '=', 'wilayah.id')
                ->join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
                ->where('wilayah.kabupaten', $kabupaten->kabupaten)
                ->selectRaw('jurusan.nama, COUNT(*) as total')
                ->groupBy('jurusan.nama')
                ->orderBy('total', 'desc')
                ->first();

            $popularJurusanData[$kabupaten->kabupaten] = [
                'nama' => $popularJurusan->nama ?? 'N/A',
                'total' => $popularJurusan->total ?? 0
            ];
        }

        return $popularJurusanData;
    }

    public function getData(Request $request)
{
    // Bersihkan output buffer untuk menghilangkan BOM
    if (ob_get_length()) ob_clean();
    
    $query = Pendaftar::with([
        'dataSiswa.wilayah',
        'jurusan',
        'gelombang'
    ]);

    // Filter berdasarkan jurusan
    if ($request->has('jurusan_id') && $request->jurusan_id != '') {
        $query->where('jurusan_id', $request->jurusan_id);
    }

    // Filter berdasarkan status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $pendaftars = $query->get();

    $data = [];
    foreach ($pendaftars as $pendaftar) {
        if (!$pendaftar->dataSiswa || !$pendaftar->dataSiswa->wilayah) {
            Log::warning('Pendaftar tanpa data siswa atau wilayah: ' . $pendaftar->id);
            continue;
        }

        $wilayah = $pendaftar->dataSiswa->wilayah;
        
        // Dapatkan koordinat berdasarkan wilayah
        $coordinates = $this->getCoordinatesByWilayah($wilayah);
        
        $data[] = [
            'id' => $pendaftar->id,
            'no_pendaftaran' => $pendaftar->no_pendaftaran,
            'nama' => $pendaftar->dataSiswa->nama,
            'jurusan' => $pendaftar->jurusan->nama,
            'status' => $pendaftar->status,
            'lat' => $coordinates['lat'],
            'lng' => $coordinates['lng'],
            'alamat' => $pendaftar->dataSiswa->alamat,
            'provinsi' => $wilayah->provinsi,
            'kabupaten' => $wilayah->kabupaten,
            'kecamatan' => $wilayah->kecamatan,
            'kelurahan' => $wilayah->kelurahan,
            'kodepos' => $wilayah->kodepos,
            'color' => $this->getColorByStatus($pendaftar->status),
            'has_real_coordinates' => false,
            'wilayah_based' => true
        ];
    }
    // Return response dengan header JSON yang explicit
    return response()->json($data, 200, [
        'Content-Type' => 'application/json; charset=utf-8'
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

    /**
     * Mendapatkan koordinat berdasarkan data wilayah
     * Prioritas: 
     * 1. Koordinat dari database wilayah (jika ada kolom lat/lng)
     * 2. Koordinat default berdasarkan kabupaten
     * 3. Koordinat default Jawa Barat
     */
    private function getCoordinatesByWilayah($wilayah)
    {
        // Jika wilayah memiliki koordinat langsung, gunakan itu
        if (isset($wilayah->lat) && isset($wilayah->lng) && $wilayah->lat && $wilayah->lng) {
            return [
                'lat' => (float)$wilayah->lat,
                'lng' => (float)$wilayah->lng
            ];
        }

        // Jika tidak, gunakan koordinat default berdasarkan kabupaten
        return $this->getDefaultCoordinatesByKabupaten($wilayah->kabupaten);
    }

    /**
     * Koordinat default berdasarkan kabupaten di Jawa Barat
     */
    private function getDefaultCoordinatesByKabupaten($kabupaten)
    {
        $kabupatenCoordinates = [
            // Kota
            'Kota Bandung' => ['lat' => -6.9175, 'lng' => 107.6191],
            'Kota Cirebon' => ['lat' => -6.7320, 'lng' => 108.5523],
            'Kota Bekasi' => ['lat' => -6.2383, 'lng' => 106.9756],
            'Kota Depok' => ['lat' => -6.4025, 'lng' => 106.7942],
            'Kota Bogor' => ['lat' => -6.5971, 'lng' => 106.8060],
            'Kota Tasikmalaya' => ['lat' => -7.3257, 'lng' => 108.2148],
            
            // Kabupaten
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
            
            // Default untuk Jawa Barat (Bandung)
            'default' => ['lat' => -6.9175, 'lng' => 107.6191]
        ];

        // Cari koordinat berdasarkan kabupaten
        foreach ($kabupatenCoordinates as $key => $coords) {
            if (strpos($kabupaten, $key) !== false) {
                return $coords;
            }
        }

        // Jika tidak ditemukan, gunakan default
        return $kabupatenCoordinates['default'];
    }

    private function getColorByStatus($status)
    {
        $colors = [
            'DRAFT' => '#6c757d',
            'SUBMIT' => '#ffc107',
            'ADM_PASS' => '#17a2b8',
            'ADM_REJECT' => '#dc3545',
            'PAID' => '#007bff',
            'LULUS' => '#28a745',
            'TIDAK_LULUS' => '#dc3545',
            'CADANGAN' => '#fd7e14'
        ];

        return $colors[$status] ?? '#6c757d';
    }
}