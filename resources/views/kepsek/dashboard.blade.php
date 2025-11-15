@extends('kepsek.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Kepala Sekolah</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row - Statistik Angka -->
    <div class="row">
        <!-- Total Pendaftar Card -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                🧑‍🎓 Total Pendaftar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendaftar }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pendaftar Hari Ini Card -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                📥 Pendaftar Hari Ini
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendaftarHariIni }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lulus Administrasi Card -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                ✔ Lulus Administrasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lulusAdministrasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sudah Bayar Card -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                💰 Sudah Bayar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudahBayar }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lulus Seleksi Card -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                🎉 Lulus Seleksi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lulusSeleksi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tidak Lulus Card -->
        <div class="col-xl-2 col-md-4 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                ❌ Tidak Lulus
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $tidakLulus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row - KPI Ringkas -->
    <div class="row">
        <!-- Pendaftar vs Kuota Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pendaftar vs Kuota
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lulusSeleksi }}/{{ $lulusSeleksi + $kuotaTersedia }}</div>
                            <div class="text-xs text-muted">Kuota Tersedia: {{ $kuotaTersedia }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Keterisian Kuota Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Keterisian Kuota
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $keterisianKuota }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-warning" role="progressbar" 
                                             style="width: {{ $keterisianKuota }}%" 
                                             aria-valuenow="{{ $keterisianKuota }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rasio Terverifikasi Administrasi -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rasio Terverifikasi Adm
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $rasioTerverifikasiAdm }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                             style="width: {{ $rasioTerverifikasiAdm }}%" 
                                             aria-valuenow="{{ $rasioTerverifikasiAdm }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rasio Terverifikasi Pembayaran -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Rasio Terverifikasi Bayar
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $rasioTerverifikasiBayar }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: {{ $rasioTerverifikasiBayar }}%" 
                                             aria-valuenow="{{ $rasioTerverifikasiBayar }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-receipt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Row 1 -->
    <div class="row">
        <!-- Grafik Pendaftar per Hari -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Harian Pendaftar (7 Hari Terakhir)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="pendaftarPerHariChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Peminat per Jurusan -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Peminat per Jurusan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="peminatJurusanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Row 2 -->
    <div class="row">
        <!-- Grafik Status Verifikasi -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Status Verifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="statusVerifikasiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pembayaran -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Status Pembayaran</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="statusPembayaranChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Row 3 -->
    <div class="row">
        <!-- Grafik Komposisi Wilayah -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Komposisi Berdasarkan Kabupaten</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="komposisiWilayahChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Asal Sekolah -->
        <div class="col-xl-6 col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Asal Sekolah</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="asalSekolahChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="row">
        <!-- Chart Column -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tren Pendaftaran Tahun {{ date('Y') }}</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:300px; width:100%">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rekap Asal Sekolah Column -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rekap Asal Sekolah</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Asal Sekolah</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekapAsalSekolah as $sekolah)
                                <tr>
                                    <td>{{ Str::limit($sekolah->nama_sekolah, 25) }}</td>
                                    <td>{{ $sekolah->jumlah }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.85em;
    }
    .table th {
        border-top: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Tunggu hingga DOM siap sepenuhnya
    document.addEventListener('DOMContentLoaded', function() {
        // Debug log removed: DOM loaded, initializing charts
        
        // Fungsi untuk memastikan data tersedia
        function ensureData(data, fallback) {
            return data && data.length > 0 ? data : fallback;
        }

        // Data fallback untuk testing
        const fallbackTrenHarian = [5, 8, 12, 7, 15, 10, 13];
        const fallbackPeminatJurusan = [45, 30, 25, 20, 15];
        const fallbackStatusVerifikasi = [60, 25, 10, 5];
        const fallbackStatusPembayaran = [40, 35, 25];
        const fallbackKomposisiWilayah = [35, 25, 20, 15, 10, 8, 5, 3];
        const fallbackAsalSekolah = [30, 25, 20, 15, 10];
        const fallbackTrenBulanan = [50, 65, 80, 120, 150, 180, 200, 165, 140, 110, 85, 60];

        // 1. Grafik Pendaftar per Hari
        const pendaftarPerHariCtx = document.getElementById('pendaftarPerHariChart');
        if (pendaftarPerHariCtx) {
            // Debug log removed: Initializing pendaftarPerHariChart
            
            const labelsHarian = [
                @foreach($grafikPendaftarPerHari as $data)
                    '{{ date("d M", strtotime($data->tanggal)) }}',
                @endforeach
            ];
            
            const dataHarian = [
                @foreach($grafikPendaftarPerHari as $data)
                    {{ $data->total }},
                @endforeach
            ];

            // Jika data kosong, gunakan fallback untuk testing
            const finalDataHarian = dataHarian.length > 0 ? dataHarian : fallbackTrenHarian;
            const finalLabelsHarian = labelsHarian.length > 0 ? labelsHarian : ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

            new Chart(pendaftarPerHariCtx, {
                type: 'bar',
                data: {
                    labels: finalLabelsHarian,
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: finalDataHarian,
                        backgroundColor: '#4e73df',
                        borderColor: '#2e59d9',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // 2. Grafik Peminat per Jurusan
        const peminatJurusanCtx = document.getElementById('peminatJurusanChart');
        if (peminatJurusanCtx) {
            // Debug log removed: Initializing peminatJurusanChart
            
            const labelsJurusan = [
                @foreach($peminatPerJurusan as $jurusan)
                    '{{ $jurusan->jurusan }}',
                @endforeach
            ];
            
            const dataJurusan = [
                @foreach($peminatPerJurusan as $jurusan)
                    {{ $jurusan->total_peminat }},
                @endforeach
            ];

            const finalDataJurusan = dataJurusan.length > 0 ? dataJurusan : fallbackPeminatJurusan;
            const finalLabelsJurusan = labelsJurusan.length > 0 ? labelsJurusan : ['TKJ', 'RPL', 'TEI', 'TKR', 'TBSM'];

            new Chart(peminatJurusanCtx, {
                type: 'doughnut',
                data: {
                    labels: finalLabelsJurusan,
                    datasets: [{
                        data: finalDataJurusan,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // 3. Grafik Status Verifikasi
        const statusVerifikasiCtx = document.getElementById('statusVerifikasiChart');
        if (statusVerifikasiCtx) {
            // Debug log removed: Initializing statusVerifikasiChart
            
            const labelsVerifikasi = [
                @foreach($statusVerifikasi as $status)
                    '{{ $status->status }}',
                @endforeach
            ];
            
            const dataVerifikasi = [
                @foreach($statusVerifikasi as $status)
                    {{ $status->jumlah }},
                @endforeach
            ];

            const finalDataVerifikasi = dataVerifikasi.length > 0 ? dataVerifikasi : fallbackStatusVerifikasi;
            const finalLabelsVerifikasi = labelsVerifikasi.length > 0 ? labelsVerifikasi : ['DRAFT', 'SUBMIT', 'ADM_PASS', 'PAID'];

            new Chart(statusVerifikasiCtx, {
                type: 'pie',
                data: {
                    labels: finalLabelsVerifikasi,
                    datasets: [{
                        data: finalDataVerifikasi,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // 4. Grafik Status Pembayaran
        const statusPembayaranCtx = document.getElementById('statusPembayaranChart');
        if (statusPembayaranCtx) {
            // Debug log removed: Initializing statusPembayaranChart
            
            const labelsPembayaran = [
                @foreach($statusPembayaran as $status)
                    '{{ $status->status_bayar }}',
                @endforeach
            ];
            
            const dataPembayaran = [
                @foreach($statusPembayaran as $status)
                    {{ $status->jumlah }},
                @endforeach
            ];

            const finalDataPembayaran = dataPembayaran.length > 0 ? dataPembayaran : fallbackStatusPembayaran;
            const finalLabelsPembayaran = labelsPembayaran.length > 0 ? labelsPembayaran : ['SUDAH_BAYAR', 'BELUM_BAYAR', 'TIDAK_TERVERIFIKASI'];

            new Chart(statusPembayaranCtx, {
                type: 'pie',
                data: {
                    labels: finalLabelsPembayaran,
                    datasets: [{
                        data: finalDataPembayaran,
                        backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        // 5. Grafik Komposisi Wilayah
        const komposisiWilayahCtx = document.getElementById('komposisiWilayahChart');
        if (komposisiWilayahCtx) {
            // Debug log removed: Initializing komposisiWilayahChart
            
            const labelsWilayah = [
                @foreach($komposisiWilayah as $wilayah)
                    '{{ $wilayah->kabupaten }}',
                @endforeach
            ];
            
            const dataWilayah = [
                @foreach($komposisiWilayah as $wilayah)
                    {{ $wilayah->jumlah }},
                @endforeach
            ];

            const finalDataWilayah = dataWilayah.length > 0 ? dataWilayah : fallbackKomposisiWilayah;
            const finalLabelsWilayah = labelsWilayah.length > 0 ? labelsWilayah : ['Jakarta Pusat', 'Jakarta Selatan', 'Jakarta Barat', 'Jakarta Timur', 'Tangerang', 'Bekasi', 'Depok', 'Bogor'];

            new Chart(komposisiWilayahCtx, {
                type: 'bar',
                data: {
                    labels: finalLabelsWilayah,
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: finalDataWilayah,
                        backgroundColor: '#36b9cc',
                        borderColor: '#2c9faf',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // 6. Grafik Asal Sekolah
        const asalSekolahCtx = document.getElementById('asalSekolahChart');
        if (asalSekolahCtx) {
            // Debug log removed: Initializing asalSekolahChart
            
            const labelsSekolah = [
                @foreach($rekapAsalSekolah as $sekolah)
                    '{{ Str::limit($sekolah->nama_sekolah, 15) }}',
                @endforeach
            ];
            
            const dataSekolah = [
                @foreach($rekapAsalSekolah as $sekolah)
                    {{ $sekolah->jumlah }},
                @endforeach
            ];

            const finalDataSekolah = dataSekolah.length > 0 ? dataSekolah : fallbackAsalSekolah;
            const finalLabelsSekolah = labelsSekolah.length > 0 ? labelsSekolah : ['SMA Negeri 1', 'SMA Negeri 2', 'SMA Swasta A', 'SMA Swasta B', 'MA Negeri'];

            new Chart(asalSekolahCtx, {
                type: 'pie',
                data: {
                    labels: finalLabelsSekolah,
                    datasets: [{
                        data: finalDataSekolah,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        }

        // 7. Trend Chart (Bulanan)
        const trendCtx = document.getElementById('trendChart');
        if (trendCtx) {
            // Debug log removed: Initializing trendChart
            
            const dataTren = [
                @foreach($trenData as $data)
                    {{ $data }},
                @endforeach
            ];

            const finalDataTren = dataTren.length > 0 ? dataTren : fallbackTrenBulanan;

            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Pendaftar',
                        data: finalDataTren,
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Debug log removed: All charts initialized
    });

    // Fallback jika Chart.js tidak terload
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        // Sembunyikan container chart dan tampilkan pesan error
        document.querySelectorAll('.chart-container').forEach(container => {
            container.innerHTML = '<div class="alert alert-warning text-center">Grafik tidak dapat dimuat. Pastikan Chart.js terload dengan benar.</div>';
        });
    }
</script>
@endpush