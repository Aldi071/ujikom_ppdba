{{-- resources/views/verifikator/verifikator.blade.php --}}
@extends('verifikator.layouts.admin')

@section('styles')
<style>
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    .dropdown-item:hover {
        background-color: #f8f9fc;
    }
    .dropdown-item i {
        width: 16px;
        margin-right: 8px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Verifikator</h1>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="row">
                <!-- Cards statistics... (tetap sama) -->
            </div>

            <!-- Charts and Tables Row -->
            <div class="row">
                <!-- Chart Column -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Verifikasi Berkas</h6>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="statusChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Recent Applicants Column -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pendaftar Menunggu Verifikasi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Jurusan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($pendaftarMenunggu as $pendaftar)
                                        <tr>
                                            <td>{{ $pendaftar->nama }}</td>
                                            <td>{{ $pendaftar->jurusan }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" 
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-cog"></i> Aksi
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('verifikator.detail', $pendaftar->id) }}">
                                                            <i class="fas fa-eye text-info"></i> Cek Detail
                                                        </a>
                                                    </div>
                                                </div>
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
    // Data untuk chart dari controller
    const statusLabels = @json($statusLabels);
    const statusCounts = @json($statusCounts);
    const statusColors = @json($statusColors);

    // Pastikan Chart.js sudah dimuat
    if (typeof Chart !== 'undefined') {
        // Buat bar chart
        const ctx = document.getElementById('statusChart').getContext('2d');
        const statusChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: statusLabels,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: statusCounts,
                    backgroundColor: statusColors,
                    borderColor: statusColors.map(color => color.replace('0.8', '1')),
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
                            stepSize: 1,
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `Jumlah: ${context.parsed.y}`;
                            }
                        }
                    }
                }
            }
        });
    } else {
        console.error('Chart.js tidak terload');
    }
</script>
@endpush