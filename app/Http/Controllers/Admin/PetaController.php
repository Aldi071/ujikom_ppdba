<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Wilayah;
use App\Models\PendaftarDataSiswa;
use Illuminate\Http\Request;

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
    if (config('app.debug')) {
        \Log::info('PetaController getData dipanggil', ['request' => $request->all()]);
    }

    $query = Pendaftar::with([
        'dataSiswa.wilayah',
        'jurusan',
        'gelombang'
    ]);

    // Untuk testing, tampilkan semua data dulu (hapus kondisi whereHas)
    // ->whereHas('dataSiswa', function($q) {
    //     $q->whereNotNull('lat')->whereNotNull('lng');
    // });

    // Filter berdasarkan jurusan
    if ($request->has('jurusan_id') && $request->jurusan_id != '') {
        $query->where('jurusan_id', $request->jurusan_id);
    }

    // Filter berdasarkan status
    if ($request->has('status') && $request->status != '') {
        $query->where('status', $request->status);
    }

    $pendaftars = $query->get();

    if (config('app.debug')) {
        \Log::info('Total pendaftar ditemukan: ' . $pendaftars->count());
    }

    $data = [];
    foreach ($pendaftars as $pendaftar) {
        if (config('app.debug')) {
            \Log::info('Memproses pendaftar: ' . $pendaftar->id, [
                'nama' => $pendaftar->dataSiswa->nama ?? 'N/A',
                'lat' => $pendaftar->dataSiswa->lat ?? 'null',
                'lng' => $pendaftar->dataSiswa->lng ?? 'null'
            ]);
        }

        // Jika koordinat null, gunakan koordinat default berdasarkan wilayah
        $lat = $pendaftar->dataSiswa->lat;
        $lng = $pendaftar->dataSiswa->lng;

        // Jika koordinat masih null, gunakan koordinat default berdasarkan kabupaten
        if (!$lat || !$lng) {
            $defaultCoords = $this->getDefaultCoordinates($pendaftar->dataSiswa->wilayah->kabupaten ?? 'Jakarta');
            $lat = $defaultCoords['lat'];
            $lng = $defaultCoords['lng'];
        }

        $data[] = [
            'id' => $pendaftar->id,
            'no_pendaftaran' => $pendaftar->no_pendaftaran,
            'nama' => $pendaftar->dataSiswa->nama,
            'jurusan' => $pendaftar->jurusan->nama,
            'status' => $pendaftar->status,
            'lat' => (float)$lat,
            'lng' => (float)$lng,
            'alamat' => $pendaftar->dataSiswa->alamat,
            'kabupaten' => $pendaftar->dataSiswa->wilayah->kabupaten ?? 'N/A',
            'color' => $this->getColorByStatus($pendaftar->status),
            'has_real_coordinates' => !!( $pendaftar->dataSiswa->lat && $pendaftar->dataSiswa->lng )
        ];
    }

    if (config('app.debug')) {
        \Log::info('Data yang dikirim ke frontend:', ['count' => count($data)]);
    }

    return response()->json($data);
}

private function getDefaultCoordinates($kabupaten)
{
    $defaultCoords = [
        'Jakarta' => ['lat' => -6.2088, 'lng' => 106.8456],
        'Bandung' => ['lat' => -6.9175, 'lng' => 107.6191],
        'Tangerang' => ['lat' => -6.4025, 'lng' => 106.7942],
        'Semarang' => ['lat' => -6.9667, 'lng' => 110.4167],
        'Sumedang' => ['lat' => -6.8500, 'lng' => 107.9167],
    ];

    return $defaultCoords[$kabupaten] ?? ['lat' => -6.2088, 'lng' => 106.8456]; // Default ke Jakarta
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