{{-- resources/views/verifikator/export-pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendaftaran PPDB</title>
    <style>
        /* Reset dan base styles */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'DejaVu Sans', Arial, sans-serif; 
            font-size: 12px; 
            line-height: 1.4;
            color: #333;
        }
        
        /* Header */
        .header { 
            text-align: center; 
            margin-bottom: 20px; 
            padding-bottom: 15px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 { 
            font-size: 20px; 
            margin-bottom: 5px;
            color: #2c3e50;
        }
        
        .header .subtitle { 
            font-size: 14px; 
            color: #7f8c8d;
            margin-bottom: 5px;
        }
        
        /* Info Box */
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .info-item {
            text-align: center;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        
        .info-number {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .info-label {
            font-size: 11px;
            color: #6c757d;
            margin-top: 5px;
        }
        
        /* Tables */
        .table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        .table th { 
            background-color: #2c3e50; 
            color: white; 
            padding: 8px; 
            text-align: left;
            border: 1px solid #34495e;
        }
        
        .table td { 
            padding: 6px; 
            border: 1px solid #ddd; 
        }
        
        .table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .table tr:hover {
            background-color: #e9ecef;
        }
        
        /* Badges untuk status */
        .badge { 
            padding: 3px 6px; 
            border-radius: 3px; 
            font-size: 9px; 
            font-weight: bold;
        }
        
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: black; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-secondary { background-color: #6c757d; color: white; }
        
        /* Statistik Section */
        .stats-section {
            margin-bottom: 20px;
        }
        
        .stats-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        
        .stats-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        
        .stats-table th,
        .stats-table td {
            padding: 6px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        
        .stats-table th {
            background-color: #34495e;
            color: white;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: right;
            font-size: 10px;
            color: #6c757d;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-3 { margin-bottom: 15px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN PENDAFTARAN PPDB</h1>
        <div class="subtitle">Sistem Penerimaan Peserta Didik Baru</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        </div>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-number">{{ $totalPendaftar }}</div>
                <div class="info-label">TOTAL PENDAFTAR</div>
            </div>
            <div class="info-item">
                <div class="info-number">{{ $menungguVerifikasi }}</div>
                <div class="info-label">MENUNGGU VERIFIKASI</div>
            </div>
            <div class="info-item">
                <div class="info-number">{{ $diterima }}</div>
                <div class="info-label">DI TERIMA</div>
            </div>
            <div class="info-item">
                <div class="info-number">{{ $ditolak }}</div>
                <div class="info-label">DI TOLAK</div>
            </div>
        </div>
        <div class="text-right">
            <small>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</small>
        </div>
    </div>

    <!-- Statistik per Jurusan -->
    <div class="stats-section">
        <div class="stats-title">STATISTIK PER JURUSAN</div>
        <table class="stats-table">
            <thead>
                <tr>
                    <th width="70%">Jurusan</th>
                    <th width="15%">Jumlah</th>
                    <th width="15%">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistikJurusan as $item)
                <tr>
                    <td>{{ $item->jurusan }}</td>
                    <td class="text-center">{{ $item->total }}</td>
                    <td class="text-center">
                        @if($totalPendaftar > 0)
                            {{ number_format(($item->total / $totalPendaftar) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </td>
                </tr>
                @endforeach
                <tr style="font-weight: bold; background-color: #e9ecef;">
                    <td>TOTAL</td>
                    <td class="text-center">{{ $totalPendaftar }}</td>
                    <td class="text-center">100%</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Data Detail Pendaftar -->
    <div class="stats-section">
        <div class="stats-title">DATA DETAIL PENDAFTAR</div>
        <table class="table">
            <thead>
                <tr>
                    <th width="8%">No. Pendaftaran</th>
                    <th width="15%">Nama</th>
                    <th width="5%">JK</th>
                    <th width="15%">Jurusan</th>
                    <th width="15%">Asal Sekolah</th>
                    <th width="10%">Status</th>
                    <th width="12%">Tanggal Daftar</th>
                    <th width="10%">Verifikator</th>
                    <th width="10%">Tgl Verifikasi</th>
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
                    <td class="text-center">
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
                                'SUBMIT' => 'Menunggu',
                                'ADM_PASS' => 'Diterima',
                                'ADM_REJECT' => 'Ditolak',
                                'PAID' => 'Bayar',
                                'LULUS' => 'Lulus',
                                'TIDAK_LULUS' => 'Tidak Lulus',
                                'CADANGAN' => 'Cadangan'
                            ][$item->status] ?? $item->status;
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ $item->user_verifikasi_adm ?? '-' }}</td>
                    <td class="text-center">
                        @if($item->tgl_verifikasi_adm)
                            {{ \Carbon\Carbon::parse($item->tgl_verifikasi_adm)->format('d/m/Y') }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @if($data->count() == 0)
        <div style="text-align: center; padding: 20px; color: #6c757d;">
            Tidak ada data pendaftar pada periode yang dipilih.
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <div>Dokumen ini dicetak otomatis dari Sistem PPDB</div>
        <div>Halaman 1/1</div>
    </div>
</body>
</html>