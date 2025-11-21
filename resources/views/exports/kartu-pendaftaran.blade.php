<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Pendaftaran - {{ $pendaftar->no_pendaftaran }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #3b82f6;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #3b82f6;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            color: #1e40af;
            margin: 5px 0;
            font-size: 18px;
        }
        .no-pendaftaran {
            background: #3b82f6;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 20px 0;
            border-radius: 5px;
        }
        .data-section {
            margin-bottom: 20px;
        }
        .section-title {
            background: #f1f5f9;
            padding: 8px;
            font-weight: bold;
            color: #1e40af;
            border-left: 4px solid #3b82f6;
            margin-bottom: 10px;
        }
        .data-row {
            display: flex;
            margin-bottom: 5px;
        }
        .data-label {
            width: 150px;
            font-weight: bold;
        }
        .data-value {
            flex: 1;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            color: white;
        }
        .status-submit { background: #10b981; }
        .status-adm-pass { background: #f59e0b; }
        .status-paid { background: #3b82f6; }
        .status-lulus { background: #059669; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KARTU PENDAFTARAN</h1>
        <h2>BAKNUS 666</h2>
        <p>Tahun Ajaran {{ date('Y') }}/{{ date('Y')+1 }}</p>
    </div>

    <div class="no-pendaftaran">
        NOMOR PENDAFTARAN: {{ $pendaftar->no_pendaftaran }}
    </div>

    <div class="data-section">
        <div class="section-title">DATA PRIBADI</div>
        <div class="data-row">
            <div class="data-label">Nama Lengkap</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->nama ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">NISN</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->nisn ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">NIK</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->nik ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Jenis Kelamin</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Tempat, Tanggal Lahir</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->tmp_lahir ?? '-' }}, {{ $pendaftar->dataSiswa->tgl_lahir ? date('d-m-Y', strtotime($pendaftar->dataSiswa->tgl_lahir)) : '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Alamat</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->alamat ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">No. HP</div>
            <div class="data-value">: {{ $pendaftar->dataSiswa->hp ?? '-' }}</div>
        </div>
    </div>

    <div class="data-section">
        <div class="section-title">DATA ORANG TUA</div>
        <div class="data-row">
            <div class="data-label">Nama Ayah</div>
            <div class="data-value">: {{ $pendaftar->dataOrtu->nama_ayah ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Pekerjaan Ayah</div>
            <div class="data-value">: {{ $pendaftar->dataOrtu->pekerjaan_ayah ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Nama Ibu</div>
            <div class="data-value">: {{ $pendaftar->dataOrtu->nama_ibu ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Pekerjaan Ibu</div>
            <div class="data-value">: {{ $pendaftar->dataOrtu->pekerjaan_ibu ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">No. HP Orang Tua</div>
            <div class="data-value">: {{ $pendaftar->dataOrtu->hp_ayah ?? $pendaftar->dataOrtu->hp_ibu ?? '-' }}</div>
        </div>
    </div>

    <div class="data-section">
        <div class="section-title">DATA SEKOLAH ASAL</div>
        <div class="data-row">
            <div class="data-label">Nama Sekolah</div>
            <div class="data-value">: {{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">NPSN</div>
            <div class="data-value">: {{ $pendaftar->asalSekolah->npsn ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Alamat Sekolah</div>
            <div class="data-value">: {{ $pendaftar->asalSekolah->kabupaten ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Nilai Rata-rata</div>
            <div class="data-value">: {{ $pendaftar->asalSekolah->nilai_rata ?? '-' }}</div>
        </div>
    </div>

    <div class="data-section">
        <div class="section-title">DATA PENDAFTARAN</div>
        <div class="data-row">
            <div class="data-label">Jurusan Pilihan</div>
            <div class="data-value">: {{ $pendaftar->jurusan->nama ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Gelombang</div>
            <div class="data-value">: {{ $pendaftar->gelombang->nama ?? '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Tanggal Daftar</div>
            <div class="data-value">: {{ $pendaftar->tanggal_daftar ? date('d-m-Y H:i', strtotime($pendaftar->tanggal_daftar)) : '-' }}</div>
        </div>
        <div class="data-row">
            <div class="data-label">Status</div>
            <div class="data-value">: 
                @php
                    $statusClass = 'status-submit';
                    if($pendaftar->status == 'ADM_PASS') $statusClass = 'status-adm-pass';
                    elseif($pendaftar->status == 'PAID') $statusClass = 'status-paid';
                    elseif($pendaftar->status == 'LULUS') $statusClass = 'status-lulus';
                @endphp
                <span class="status-badge {{ $statusClass }}">
                    {{ $pendaftar->status }}
                </span>
            </div>
        </div>
    </div>

    <div class="footer">
        <p><strong>PENTING:</strong></p>
        <p>• Simpan kartu pendaftaran ini dengan baik</p>
        <p>• Bawa kartu ini saat daftar ulang</p>
        <p>• Pantau status pendaftaran di website resmi</p>
        <br>
        <p>Dicetak pada: {{ date('d-m-Y H:i:s') }}</p>
        <p>Website: www.baknus666.sch.id | Email: info@baknus666.sch.id</p>
    </div>
</body>
</html>