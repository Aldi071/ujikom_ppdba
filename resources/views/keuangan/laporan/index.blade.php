{{-- resources/views/keuangan/laporan/index.blade.php --}}
@extends('keuangan.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Laporan Keuangan</h1>
        <div>
            <a href="{{ route('keuangan.laporan.export', request()->all()) }}" 
               class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export PDF
            </a>
            <a href="{{ route('keuangan.laporan.preview', request()->all()) }}" 
               target="_blank"
               class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm ml-2">
                <i class="fas fa-eye fa-sm text-white-50"></i> Preview PDF
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('keuangan.laporan') }}" method="GET">
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
                <a href="{{ route('keuangan.laporan') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row">
        <!-- Total Pendapatan Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pendapatan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembayaran Valid Card -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pembayaran Valid
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPembayaranValid }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi Card -->
        <div class="col-xl-4 col-md-6 mb-4">
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
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Pie Chart untuk Pembayaran per Gelombang -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pembayaran per Gelombang</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="gelombangChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bar Chart untuk Nominal per Gelombang -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Nominal per Gelombang</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="nominalChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Gelombang</th>
                            <th>Biaya Daftar</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                            <th>Tanggal Verifikasi</th>
                            <th>Verifikator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $item->no_pendaftaran }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->jurusan }}</td>
                            <td>{{ $item->gelombang }}</td>
                            <td>Rp {{ number_format($item->biaya_daftar, 0, ',', '.') }}</td>
                            <td>
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
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d/m/Y') }}</td>
                            <td>
                                @if($item->tgl_verifikasi_payment)
                                    {{ \Carbon\Carbon::parse($item->tgl_verifikasi_payment)->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $item->user_verifikasi_payment ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Data untuk chart
    const gelombangData = @json($pembayaranPerGelombang);
    
    // Pie Chart untuk Gelombang
    const ctxPie = document.getElementById('gelombangChart').getContext('2d');
    const gelombangChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: gelombangData.map(item => item.gelombang),
            datasets: [{
                data: gelombangData.map(item => item.total),
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
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

    // Bar Chart untuk Nominal
    const ctxBar = document.getElementById('nominalChart').getContext('2d');
    const nominalChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: gelombangData.map(item => item.gelombang),
            datasets: [{
                label: 'Nominal (Rp)',
                data: gelombangData.map(item => item.nominal),
                backgroundColor: '#4e73df',
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        }
                    }
                }
            }
        }
    });
</script>
@endpush