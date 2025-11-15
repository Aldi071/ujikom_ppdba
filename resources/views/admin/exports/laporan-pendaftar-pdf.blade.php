<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendaftar - {{ date('d F Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-primary { background-color: #007bff; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }
        .footer { margin-top: 50px; text-align: right; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENDAFTAR PPDB</h1>
        <p>Tanggal Laporan: {{ $tanggalLaporan }}</p>
        <p>Total Data: {{ $pendaftars->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Pendaftaran</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Jurusan</th>
                <th>Gelombang</th>
                <th>Tanggal Daftar</th>
                <th>Status</th>
                <th>Asal Sekolah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendaftars as $pendaftar)
            <tr>
                <td>{{ $pendaftar->no_pendaftaran }}</td>
                <td>{{ $pendaftar->dataSiswa->nama ?? 'N/A' }}</td>
                <td>{{ $pendaftar->dataSiswa->nisn ?? 'N/A' }}</td>
                <td>{{ $pendaftar->jurusan->nama ?? 'N/A' }}</td>
                <td>{{ $pendaftar->gelombang->nama ?? 'N/A' }}</td>
                <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y') }}</td>
                <td>
                    @php
                        $statusClass = [
                            'DRAFT' => 'badge-secondary',
                            'SUBMIT' => 'badge-warning',
                            'ADM_PASS' => 'badge-info',
                            'ADM_REJECT' => 'badge-danger',
                            'PAID' => 'badge-primary',
                            'LULUS' => 'badge-success',
                            'TIDAK_LULUS' => 'badge-danger',
                            'CADANGAN' => 'badge-warning',
                        ];
                    @endphp
                    <span class="badge {{ $statusClass[$pendaftar->status] ?? 'badge-secondary' }}">
                        {{ $pendaftar->status }}
                    </span>
                </td>
                <td>{{ $pendaftar->asalSekolah->nama_sekolah ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
        <p>Oleh: {{ Auth::user()->name ?? 'System' }}</p>
    </div>
</body>
</html>