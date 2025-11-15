{{-- resources/views/verifikator/laporan.blade.php --}}
@extends('verifikator.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pendaftaran</h1>
        <a href="{{ route('verifikator.laporan.export', request()->all()) }}"
            class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Export PDF
        </a>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Pendaftaran</h1>
        <a href="{{ route('verifikator.laporan.preview', request()->all()) }}"
            target="_blank"
            class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm ml-2">
            <i class="fas fa-eye fa-sm text-white-50"></i> Preview PDF
        </a>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('verifikator.laporan') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="start_date" name="start_date"
                                value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="end_date" name="end_date"
                                value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan</label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ $jurusanId == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                @foreach($statusList as $key => $value)
                                <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Terapkan Filter
                </button>
                <a href="{{ route('verifikator.laporan') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row">
        <!-- Total Pendaftar Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendaftar
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

        <!-- Menunggu Verifikasi Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Verifikasi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menungguVerifikasi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Diterima Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Diterima
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $diterima }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ditolak Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Ditolak
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $ditolak }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Pie Chart untuk Jurusan -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pendaftar per Jurusan</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="jurusanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Chart untuk Trend Harian -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trend Pendaftaran Harian</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Statistik -->
    <div class="row">
        <!-- Statistik per Jurusan -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik per Jurusan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Jurusan</th>
                                    <th>Jumlah</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistikJurusan as $item)
                                <tr>
                                    <td>{{ $item->jurusan }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        @if($totalPendaftar > 0)
                                        {{ number_format(($item->total / $totalPendaftar) * 100, 1) }}%
                                        @else
                                        0%
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik per Status -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik per Status</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Status</th>
                                    <th>Jumlah</th>
                                    <th>Persentase</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistikStatus as $item)
                                <tr>
                                    <td>
                                        @php
                                        $statusLabels = [
                                        'DRAFT' => 'Draft',
                                        'SUBMIT' => 'Menunggu Verifikasi',
                                        'ADM_PASS' => 'Berkas Diterima',
                                        'ADM_REJECT' => 'Berkas Ditolak',
                                        'PAID' => 'Sudah Bayar',
                                        'LULUS' => 'Lulus',
                                        'TIDAK_LULUS' => 'Tidak Lulus',
                                        'CADANGAN' => 'Cadangan'
                                        ];
                                        @endphp
                                        {{ $statusLabels[$item->status] ?? $item->status }}
                                    </td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        @if($totalPendaftar > 0)
                                        {{ number_format(($item->total / $totalPendaftar) * 100, 1) }}%
                                        @else
                                        0%
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Data untuk chart jurusan
    const jurusanData = @json($statistikJurusan);
    const trendData = @json($statistikHarian);

    // Pie Chart untuk Jurusan
    const ctxPie = document.getElementById('jurusanChart').getContext('2d');
    const jurusanChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: jurusanData.map(item => item.jurusan),
            datasets: [{
                data: jurusanData.map(item => item.total),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Line Chart untuk Trend Harian
    const ctxLine = document.getElementById('trendChart').getContext('2d');
    const trendChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: trendData.map(item => new Date(item.tanggal).toLocaleDateString()),
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: trendData.map(item => item.total),
                backgroundColor: 'rgba(78, 115, 223, 0.1)',
                borderColor: '#4e73df',
                pointBackgroundColor: '#4e73df',
                pointBorderColor: '#4e73df',
                pointRadius: 3,
                pointHoverRadius: 5,
                fill: true
            }]
        },
        options: {
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
</script>
@endpush