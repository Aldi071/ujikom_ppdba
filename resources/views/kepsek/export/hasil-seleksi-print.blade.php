<!DOCTYPE html>
<html>
<head>
    <title>Hasil Seleksi PPDB</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .badge { padding: 4px 10px; border-radius: 4px; font-size: 12px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-primary { background-color: #cce5ff; color: #004085; }
        .badge-info { background-color: #d1ecf1; color: #0c5460; }
        .footer { margin-top: 30px; text-align: center; font-size: 12px; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
        @media print {
            .no-print { display: none; }
            body { font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>HASIL SELEKSI PPDB</h1>
        <p>SMK Example School</p>
        <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No. Pendaftaran</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Asal Sekolah</th>
                <th>Jurusan</th>
                <th>Status</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasilSeleksi as $key => $pendaftar)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td><strong>{{ $pendaftar->no_pendaftaran }}</strong></td>
                <td>{{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
                <td>{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
                <td>{{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td>
                <td>{{ $pendaftar->jurusan->nama ?? '-' }}</td>
                <td>
                    @if($pendaftar->status == 'LULUS')
                        <span class="badge badge-success">LULUS</span>
                    @elseif($pendaftar->status == 'TIDAK_LULUS')
                        <span class="badge badge-danger">TIDAK LULUS</span>
                    @elseif($pendaftar->status == 'CADANGAN')
                        <span class="badge badge-warning">CADANGAN</span>
                    @elseif($pendaftar->status == 'PAID')
                        <span class="badge badge-primary">SUDAH BAYAR</span>
                    @elseif($pendaftar->status == 'ADM_PASS')
                        <span class="badge badge-info">LULUS ADMINISTRASI</span>
                    @else
                        <span class="badge badge-secondary">{{ $pendaftar->status }}</span>
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Total Data: {{ $hasilSeleksi->count() }} siswa</p>
        <p>&copy; {{ date('Y') }} SMK Example School - Sistem PPDB</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>