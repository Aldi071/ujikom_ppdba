{{-- resources/views/keuangan/keuangan.blade.php --}}
@extends('keuangan.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Keuangan</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Keuangan Role Content -->
        <div class="col-12">
            <div class="row">
                <!-- Bukti Bayar Masuk Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Bukti Bayar Masuk
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $buktiBayarMasuk }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-receipt fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pembayaran Valid Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pembayaran Valid
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pembayaranValid }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Nominal Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Nominal
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalNominalFormatted }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pending Card -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                        Menunggu Verifikasi
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pending }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
                                </div>
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
                            <h6 class="m-0 font-weight-bold text-primary">Pembayaran per Gelombang</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height:300px; width:100%">
                                <canvas id="pembayaranChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Payments Column -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Bukti Bayar Terbaru</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($buktiBayarTerbaru as $bayar)
                                        <tr>
                                            <td>{{ $bayar->nama }}</td>
                                            <td>
                                                <span class="badge badge-warning">Pending</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('keuangan.validasi.detail', $bayar->id) }}" 
                                                   class="btn btn-sm btn-primary">Cek Bukti</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center">Tidak ada data</td>
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
    </div>

</div>
@endsection

@push('scripts')
<script>
// Chart initialization script
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('pembayaranChart').getContext('2d');
    
    // Data dari controller
    var gelombangLabels = @json($pembayaranPerGelombang->pluck('gelombang'));
    var gelombangData = @json($pembayaranPerGelombang->pluck('total'));

    var pembayaranChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: gelombangLabels,
            datasets: [{
                label: 'Jumlah Pembayaran Valid',
                data: gelombangData,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
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
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });
});
</script>
@endpush