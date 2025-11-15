<?php

namespace App\Exports;

use App\Models\Pendaftar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendaftarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $pendaftars;

    public function __construct($pendaftars)
    {
        $this->pendaftars = $pendaftars;
    }

    public function collection()
    {
        return $this->pendaftars;
    }

    public function headings(): array
    {
        return [
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
        ];
    }

    public function map($pendaftar): array
    {
        return [
            $pendaftar->no_pendaftaran,
            $pendaftar->dataSiswa->nama ?? 'N/A',
            $pendaftar->dataSiswa->nisn ?? 'N/A',
            $pendaftar->jurusan->nama ?? 'N/A',
            $pendaftar->gelombang->nama ?? 'N/A',
            $pendaftar->tanggal_daftar->format('d/m/Y'),
            $this->getStatusText($pendaftar->status),
            $pendaftar->asalSekolah->nama_sekolah ?? 'N/A',
            $pendaftar->asalSekolah->kabupaten ?? 'N/A',
            $pendaftar->asalSekolah->nilai_rata ?? 'N/A',
            $pendaftar->dataOrtu->nama_ayah ?? 'N/A',
            $pendaftar->dataOrtu->pekerjaan_ayah ?? 'N/A'
        ];
    }

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