{{-- resources/views/keuangan/laporan/export-pdf.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan SPMB</title>
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
            grid-template-columns: repeat(3, 1fr);
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
        
        /* Footer */
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #dee2e6;
            text-align: right;
            font-size: 10px;
            color: #6c757d;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-3 { margin-bottom: 15px; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>LAPORAN KEUANGAN SPMB</h1>
        <div class="subtitle">Sistem Penerimaan Peserta Didik Baru</div>
        <div class="subtitle">
            Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}
        </div>
    </div>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-grid">
            <div class="info-item">
                <div class="info-number">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="info-label">TOTAL PENDAPATAN</div>
            </div>
            <div class="info-item">
                <div class="info-number">{{ $totalPembayaranValid }}</div>
                <div class="info-label">PEMBAYARAN VALID</div>
            </div>
            <div class="info-item">
                <div class="info-number">{{ $data->where('status', 'ADM_PASS')->count() }}</div>
                <div class="info-label">MENUNGGU VERIFIKASI</div>
            </div>
        </div>
        <div class="text-right">
            <small>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</small>
        </div>
    </div>

    <!-- Data Detail -->
    <table class="table">
        <thead>
            <tr>
                <th width="10%">No. Pendaftaran</th>
                <th width="15%">Nama</th>
                <th width="12%">Jurusan</th>
                <th width="12%">Gelombang</th>
                <th width="12%">Biaya Daftar</th>
                <th width="10%">Status</th>
                <th width="10%">Tanggal Daftar</th>
                <th width="10%">Tanggal Verifikasi</th>
                <th width="9%">Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item->no_pendaftaran }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->jurusan }}</td>
                <td>{{ $item->gelombang }}</td>
                <td class="text-right">Rp {{ number_format($item->biaya_daftar, 0, ',', '.') }}</td>
                <td class="text-center">
                    @php
                        $statusClass = [
                            'ADM_PASS' => 'badge-warning',
                            'PAID' => 'badge-success',
                            'ADM_REJECT' => 'badge-danger'
                        ][$item->status] ?? 'badge-secondary';
                        $statusText = [
                            'ADM_PASS' => 'Menunggu Bayar',
                            'PAID' => 'Lunas',
                            'ADM_REJECT' => 'Ditolak'
                        ][$item->status] ?? $item->status;
                    @endphp
                    <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                </td>
                <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}</td>
                <td class="text-center">
                    @if($item->tgl_verifikasi_payment)
                        {{ \Carbon\Carbon::parse($item->tgl_verifikasi_payment)->format('d/m/Y') }}
                    @else
                        -
                    @endif
                </td>
                <td class="text-center">{{ $item->user_verifikasi_payment ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div>Dokumen ini dicetak otomatis dari Sistem SPMB</div>
        <div>Halaman 1/1</div>
    </div>
</body>
</html>