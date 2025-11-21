<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Export Log Aktivitas - {{ date('d-m-Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 10px; }
        .badge-success { background-color: #d4edda; color: #155724; }
        .badge-danger { background-color: #f8d7da; color: #721c24; }
        .badge-warning { background-color: #fff3cd; color: #856404; }
        .badge-primary { background-color: #cce5ff; color: #004085; }
        .badge-info { background-color: #d1ecf1; color: #0c5460; }
        .footer { margin-top: 20px; text-align: right; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LOG AKTIVITAS SISTEM</h1>
        <p>Tanggal Laporan: {{ date('d/m/Y H:i') }}</p>
        <p>Total Data: {{ $logs->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>User</th>
                <th>Aksi</th>
                <th>Objek</th>
                <th>IP Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $key => $log)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $log->waktu->format('d/m/Y H:i:s') }}</td>
                <td>{{ $log->user->nama ?? 'System' }}</td>
                <td>{{ $log->aksi }}</td>
                <td>{{ $log->objek }}</td>
                <td>{{ $log->ip }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: Sistem SPMB | Tanggal: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
