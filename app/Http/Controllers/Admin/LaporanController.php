<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use App\Models\Jurusan;
use App\Models\Gelombang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\PendaftarExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class LaporanController extends Controller
{
    public function pendaftar(Request $request)
    {
        $query = Pendaftar::with([
            'jurusan',
            'gelombang',
            'dataSiswa',
            'dataOrtu',
            'asalSekolah'
        ]);

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('tanggal_daftar', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_selesai') && $request->tanggal_selesai != '') {
            $query->whereDate('tanggal_daftar', '<=', $request->tanggal_selesai);
        }

        // Filter berdasarkan jurusan
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Filter berdasarkan gelombang
        if ($request->has('gelombang_id') && $request->gelombang_id != '') {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kabupaten
        if ($request->has('kabupaten') && $request->kabupaten != '') {
            $query->whereHas('dataSiswa.wilayah', function ($q) use ($request) {
                $q->where('kabupaten', 'like', '%' . $request->kabupaten . '%');
            });
        }

        $pendaftars = $query->orderBy('tanggal_daftar', 'desc')->paginate(20);

        // Data untuk filter
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

        // Statistik
        $totalPendaftar = Pendaftar::count();
        $totalSubmit = Pendaftar::where('status', 'SUBMIT')->count();
        $totalLulus = Pendaftar::where('status', 'LULUS')->count();
        $totalDitolak = Pendaftar::where('status', 'ADM_REJECT')->count();

        // Data untuk chart
        $pendaftarPerBulan = Pendaftar::selectRaw('MONTH(tanggal_daftar) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_daftar', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pendaftarPerJurusan = Pendaftar::join('jurusan', 'pendaftar.jurusan_id', '=', 'jurusan.id')
            ->selectRaw('jurusan.nama, COUNT(*) as total')
            ->groupBy('jurusan.nama')
            ->orderBy('total', 'desc')
            ->get();

        return view('admin.laporan-pendaftar', compact(
            'pendaftars',
            'jurusanList',
            'gelombangList',
            'statusList',
            'totalPendaftar',
            'totalSubmit',
            'totalLulus',
            'totalDitolak',
            'pendaftarPerBulan',
            'pendaftarPerJurusan'
        ));
    }

    public function exportPendaftar(Request $request)
    {
        try {
            $query = Pendaftar::with([
                'jurusan',
                'gelombang',
                'dataSiswa',
                'dataOrtu',
                'asalSekolah'
            ]);

            // Apply filters sama seperti method pendaftar
            if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
                $query->whereDate('tanggal_daftar', '>=', $request->tanggal_mulai);
            }

            if ($request->has('tanggal_selesai') && $request->tanggal_selesai != '') {
                $query->whereDate('tanggal_daftar', '<=', $request->tanggal_selesai); // PERBAIKAN
            }

            if ($request->has('jurusan_id') && $request->jurusan_id != '') {
                $query->where('jurusan_id', $request->jurusan_id);
            }

            if ($request->has('gelombang_id') && $request->gelombang_id != '') {
                $query->where('gelombang_id', $request->gelombang_id);
            }

            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            // Tambahkan filter kabupaten untuk export juga
            if ($request->has('kabupaten') && $request->kabupaten != '') {
                $query->whereHas('dataSiswa.wilayah', function ($q) use ($request) {
                    $q->where('kabupaten', 'like', '%' . $request->kabupaten . '%');
                });
            }

            $pendaftars = $query->orderBy('tanggal_daftar', 'desc')->get();

            $format = $request->get('format', 'excel');
            $filename = 'laporan-pendaftar-' . date('Y-m-d');

            if ($format === 'excel') {
                return Excel::download(new PendaftarExport($pendaftars), $filename . '.xlsx');
            } elseif ($format === 'csv') {
                return Excel::download(new PendaftarExport($pendaftars), $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
            } else {
                $data = [
                    'pendaftars' => $pendaftars,
                    'tanggalLaporan' => date('d F Y'),
                    'filter' => $request->all()
                ];

                $pdf = PDF::loadView('admin.exports.laporan-pendaftar-pdf', $data);
                return $pdf->download($filename . '.pdf');
            }

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat export: ' . $e->getMessage());
        }
    }

    /**
     * Export CSV Manual sebagai alternatif jika Excel bermasalah
     */
    public function exportPendaftarManual(Request $request)
    {
        $query = Pendaftar::with([
            'jurusan',
            'gelombang',
            'dataSiswa',
            'dataOrtu',
            'asalSekolah'
        ]);

        // Apply filters
        if ($request->has('tanggal_mulai') && $request->tanggal_mulai != '') {
            $query->whereDate('tanggal_daftar', '>=', $request->tanggal_mulai);
        }

        if ($request->has('tanggal_selesai') && $request->tanggal_selesai != '') {
            $query->whereDate('tanggal_daftar', '<=', $request->tanggal_selesai);
        }

        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        if ($request->has('gelombang_id') && $request->gelombang_id != '') {
            $query->where('gelombang_id', $request->gelombang_id);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('kabupaten') && $request->kabupaten != '') {
            $query->whereHas('dataSiswa.wilayah', function($q) use ($request) {
                $q->where('kabupaten', 'like', '%' . $request->kabupaten . '%');
            });
        }

        $pendaftars = $query->orderBy('tanggal_daftar', 'desc')->get();

        $filename = 'laporan-pendaftar-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($pendaftars) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8
            fwrite($file, "\xEF\xBB\xBF");
            
            // Header
            fputcsv($file, [
                'No. Pendaftaran',
                'Nama Siswa',
                'NISN',
                'Jurusan',
                'Gelombang',
                'Tanggal Daftar',
                'Status',
                'Asal Sekolah',
                'Kabupaten',
                'Nilai Rata-rata',
                'Nama Ayah',
                'Pekerjaan Ayah'
            ]);

            // Data
            foreach ($pendaftars as $pendaftar) {
                fputcsv($file, [
                    $pendaftar->no_pendaftaran,
                    $pendaftar->dataSiswa->nama ?? 'N/A',
                    $pendaftar->dataSiswa->nisn ?? 'N/A',
                    $pendaftar->jurusan->nama ?? 'N/A',
                    $pendaftar->gelombang->nama ?? 'N/A',
                    $pendaftar->tanggal_daftar ? $pendaftar->tanggal_daftar->format('d/m/Y') : 'N/A',
                    $this->getStatusText($pendaftar->status),
                    $pendaftar->asalSekolah->nama_sekolah ?? 'N/A',
                    $pendaftar->asalSekolah->kabupaten ?? 'N/A',
                    $pendaftar->asalSekolah->nilai_rata ?? 'N/A',
                    $pendaftar->dataOrtu->nama_ayah ?? 'N/A',
                    $pendaftar->dataOrtu->pekerjaan_ayah ?? 'N/A'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Helper function untuk mengkonversi status ke text
     */
    private function getStatusText($status)
    {
        $statusMap = [
            'DRAFT' => 'Draft',
            'SUBMIT' => 'Submit',
            'ADM_PASS' => 'Lolos Administrasi',
            'ADM_REJECT' => 'Tidak Lolos Administrasi',
            'PAID' => 'Sudah Bayar',
            'LULUS' => 'Lulus',
            'TIDAK_LULUS' => 'Tidak Lulus',
            'CADANGAN' => 'Cadangan'
        ];

        return $statusMap[$status] ?? $status;
    }

}