{{-- resources/views/verifikator/export-laporan.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendaftaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .text-center { text-align: center; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN PENDAFTARAN PPDB</h2>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No. Pendaftaran</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Jurusan</th>
                <th>Asal Sekolah</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
                <th>Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->no_pendaftaran }}</td>
                <td>{{ $item->nama }}</td>
                <td class="text-center">{{ $item->jk == 'L' ? 'L' : 'P' }}</td>
                <td>{{ $item->jurusan }}</td>
                <td>{{ $item->nama_sekolah ?? '-' }}</td>
                <td>
                    @php
                        $statusClass = [
                            'DRAFT' => 'badge-secondary',
                            'SUBMIT' => 'badge-warning',
                            'ADM_PASS' => 'badge-success',
                            'ADM_REJECT' => 'badge-danger',
                            'PAID' => 'badge-info',
                            'LULUS' => 'badge-success',
                            'TIDAK_LULUS' => 'badge-danger',
                            'CADANGAN' => 'badge-warning'
                        ][$item->status] ?? 'badge-secondary';
                        
                        $statusText = [
                            'DRAFT' => 'Draft',
                            'SUBMIT' => 'Menunggu Verifikasi',
                            'ADM_PASS' => 'Diterima',
                            'ADM_REJECT' => 'Ditolak',
                            'PAID' => 'Sudah Bayar',
                            'LULUS' => 'Lulus',
                            'TIDAK_LULUS' => 'Tidak Lulus',
                            'CADANGAN' => 'Cadangan'
                        ][$item->status] ?? $item->status;
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                <td>{{ $item->user_verifikasi_adm ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p>Total Data: {{ $data->count() }}</p>
    </div>
</body>
</html>