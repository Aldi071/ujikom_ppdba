<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftar::with(['jurusan', 'gelombang', 'dataSiswa', 'asalSekolah'])
            ->orderBy('created_at', 'desc');

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('dataSiswa', function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            })->orWhere('no_pendaftaran', 'like', "%{$search}%");
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan gelombang
        if ($request->has('gelombang_id') && $request->gelombang_id != '') {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        $pendaftars = $query->paginate(10);
        $jurusanList = Jurusan::where('aktif', 1)->get();
        $gelombangList = Gelombang::where('aktif', 1)->get();
        $statusList = [
            'DRAFT' => 'Draft',
            'SUBMIT' => 'Submit',
            'ADM_PASS' => 'Lolos Administrasi',
            'ADM_REJECT' => 'Tidak Lolos Administrasi',
            'PAID' => 'Sudah Bayar',
            'LULUS' => 'Lulus',
            'TIDAK_LULUS' => 'Tidak Lulus',
            'CADANGAN' => 'Cadangan'
        ];

        return view('admin.monitoring-pendaftar', compact(
            'pendaftars', 
            'jurusanList', 
            'gelombangList', 
            'statusList'
        ));
    }

    public function show($id)
    {
        $pendaftar = Pendaftar::with([
            'jurusan', 
            'gelombang', 
            'dataSiswa', 
            'dataOrtu', 
            'asalSekolah',
            'berkas'
        ])->findOrFail($id);

        return view('admin.monitoring-detail', compact('pendaftar'));
    }

    // Method updateStatus dipindahkan ke Verifikator
    // Admin hanya bisa melihat data (view only)
}