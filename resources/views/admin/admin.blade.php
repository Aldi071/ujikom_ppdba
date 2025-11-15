@extends('admin.layouts.main')

@section('content')
@php
    // Default values untuk menghindari undefined variable
    $totalPendaftar = $totalPendaftar ?? 0;
    $verifikasiAdm = $verifikasiAdm ?? 0;
    $sudahBayar = $sudahBayar ?? 0;
    $lulusSeleksi = $lulusSeleksi ?? 0;
    $totalKuota = $totalKuota ?? 0;
    $pendaftarTerbaru = $pendaftarTerbaru ?? collect();
    $pendaftarPerJurusan = $pendaftarPerJurusan ?? collect();
    $pendaftarPerStatus = $pendaftarPerStatus ?? collect();
    $chartData = $chartData ?? array_fill(0, 12, 0);
@endphp

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin SPMB</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
    </a>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Pendaftar -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pendaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendaftar }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sudah Verifikasi Administrasi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Verifikasi Administrasi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $verifikasiAdm }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sudah Bayar -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Sudah Bayar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudahBayar }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lulus Seleksi -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Lulus Seleksi</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lulusSeleksi }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Pendaftaran Tahun {{ date('Y') }}</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Jurusan</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    @foreach($pendaftarPerJurusan as $index => $jurusan)
                        @php
                            $colors = ['primary', 'success', 'info', 'warning', 'danger', 'secondary'];
                            $color = $colors[$index % count($colors)] ?? 'secondary';
                        @endphp
                        <span class="mr-2">
                            <i class="fas fa-circle text-{{ $color }}"></i> {{ $jurusan->nama }}
                        </span>
                        <br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <!-- Pendaftar Terbaru -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">5 Pendaftar Terbaru</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarTerbaru as $pendaftar)
                            <tr>
                                <td>{{ $pendaftar->nama_siswa ?? 'N/A' }}</td>
                                <td>{{ $pendaftar->nama_jurusan ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($pendaftar->created_at)->format('d M Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'DRAFT' => 'badge badge-secondary',
                                            'SUBMIT' => 'badge badge-warning',
                                            'ADM_PASS' => 'badge badge-info',
                                            'ADM_REJECT' => 'badge badge-danger',
                                            'PAID' => 'badge badge-primary',
                                            'LULUS' => 'badge badge-success',
                                            'TIDAK_LULUS' => 'badge badge-danger',
                                            'CADANGAN' => 'badge badge-warning',
                                        ];
                                        $currentStatus = $pendaftar->status ?? 'DRAFT';
                                    @endphp
                                    <span class="{{ $statusClass[$currentStatus] ?? 'badge badge-secondary' }}">
                                        {{ $currentStatus }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data pendaftar</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <!-- Status Pendaftaran -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Pendaftaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Jumlah</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftarPerStatus as $status)
                            <tr>
                                <td>
                                    @php
                                        $statusClass = [
                                            'DRAFT' => 'badge badge-secondary',
                                            'SUBMIT' => 'badge badge-warning',
                                            'ADM_PASS' => 'badge badge-info',
                                            'ADM_REJECT' => 'badge badge-danger',
                                            'PAID' => 'badge badge-primary',
                                            'LULUS' => 'badge badge-success',
                                            'TIDAK_LULUS' => 'badge badge-danger',
                                            'CADANGAN' => 'badge badge-warning',
                                        ];
                                        $currentStatus = $status->status ?? 'DRAFT';
                                    @endphp
                                    <span class="{{ $statusClass[$currentStatus] ?? 'badge badge-secondary' }}">
                                        {{ $currentStatus }}
                                    </span>
                                </td>
                                <td>{{ $status->total }}</td>
                                <td>
                                    @php
                                        $percentage = $totalPendaftar > 0 ? ($status->total / $totalPendaftar) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentage, 1) }}%
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data status</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Area Chart Example
var ctx = document.getElementById("myAreaChart");
if (ctx) {
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            datasets: [{
                label: "Pendaftar",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                    @foreach($chartData as $data)
                        {{ $data }},
                    @endforeach
                ],
            }],
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [{
                    time: {
                        unit: 'date'
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        maxTicksLimit: 7
                    }
                }],
                yAxes: [{
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        beginAtZero: true,
                        // Include a dollar sign in the ticks
                        callback: function(value, index, values) {
                            return number_format(value);
                        }
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2]
                    }
                }],
            },
            legend: {
                display: false
            },
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                titleMarginBottom: 10,
                titleFontColor: '#6e707e',
                titleFontSize: 14,
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                intersect: false,
                mode: 'index',
                caretPadding: 10,
                callbacks: {
                    label: function(tooltipItem, chart) {
                        var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                        return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                    }
                }
            }
        }
    });
}

// Pie Chart Example
var ctx2 = document.getElementById("myPieChart");
if (ctx2) {
    var myPieChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach($pendaftarPerJurusan as $jurusan)
                    "{{ $jurusan->nama }}",
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach($pendaftarPerJurusan as $jurusan)
                        {{ $jurusan->total }},
                    @endforeach
                ],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02d1b'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }],
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: '#dddfeb',
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false
            },
            cutoutPercentage: 80,
        },
    });
}

// Function to format numbers (from SB Admin 2 demo)
function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}
</script>
@endsection