<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendaftar - {{ date('d F Y') }}</title>
    <style>
        body {
            font-family: 'Nunito', Arial, sans-serif;
            font-size: 13px;
            color: #222;
            background: #fff;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header-left {
            display: flex;
            align-items: center;
        }
        .logo {
            width: 60px;
            height: 60px;
            margin-right: 18px;
        }
        .header-title {
            font-size: 1.7em;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 2px;
        }
        .header-desc {
            font-size: 1em;
            color: #555;
        }
        .summary {
            margin-bottom: 18px;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 12px 18px;
            box-shadow: 0 1px 2px #eee;
        }
        .summary-row {
            display: flex;
            gap: 32px;
            font-size: 1em;
        }
        .summary-item {
            font-weight: bold;
            color: #007bff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0 30px 0;
        }
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f6fc;
        }
        tr:nth-child(odd) {
            background-color: #fff;
        }
        .badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .badge-success { background-color: #28a745; color: #fff; }
        .badge-warning { background-color: #ffc107; color: #222; }
        .badge-danger { background-color: #dc3545; color: #fff; }
        .badge-info { background-color: #17a2b8; color: #fff; }
        .badge-primary { background-color: #007bff; color: #fff; }
        .badge-secondary { background-color: #6c757d; color: #fff; }
        .footer {
            margin-top: 40px;
            text-align: right;
            color: #555;
            font-size: 1em;
        }
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        .signature .name {
            margin-top: 60px;
            font-weight: bold;
            font-size: 1em;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <div style="font-size:2em;font-weight:bold;color:#007bff;margin-right:18px;">SMK Negeri X</div>
            <div>
                <div class="header-title">Laporan Pendaftar SPMB</div>
                <div class="header-desc">Sistem Penerimaan Peserta Didik Baru</div>
            </div>
        </div>
        <div>
            <div class="header-desc">Tanggal: <b>{{ $tanggalLaporan ?? date('d F Y') }}</b></div>
            <div class="header-desc">Total Data: <b>{{ $pendaftars->count() }}</b></div>
        </div>
    </div>

    <div class="summary">
        <div class="summary-row">
            <div class="summary-item">Lulus: <span style="color:#28a745;font-weight:normal;">{{ $pendaftars->where('status','LULUS')->count() }}</span></div>
            <div class="summary-item">Tidak Lulus: <span style="color:#dc3545;font-weight:normal;">{{ $pendaftars->where('status','TIDAK_LULUS')->count() }}</span></div>
            <div class="summary-item">Cadangan: <span style="color:#ffc107;font-weight:normal;">{{ $pendaftars->where('status','CADANGAN')->count() }}</span></div>
            <div class="summary-item">Sudah Bayar: <span style="color:#17a2b8;font-weight:normal;">{{ $pendaftars->where('status','PAID')->count() }}</span></div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
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
            @foreach($pendaftars as $i => $pendaftar)
            <tr>
                <td>{{ $i+1 }}</td>
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

    <div class="signature">
        <div>Mengetahui,</div>
        <div>Kepala Sekolah</div>
        <div class="name">__________________________</div>
    </div>

    <div class="footer">
        Dicetak pada: {{ date('d F Y H:i:s') }}<br>
        Oleh: {{ Auth::user()->name ?? 'System' }}<br>
        &copy; {{ date('Y') }} SPMB System - SMK BAKTI NUSANTARA 666
    </div>
</body>
</html>