@extends('admin.layouts.main')

@section('styles')
<link href="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .stat-card {
        border-left: 4px solid;
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
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
<!-- Page Heading -->
<div class="btn-group">
    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-download fa-sm"></i> Export Laporan
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#" onclick="exportReport('pdf')">
            <i class="fas fa-file-pdf text-danger"></i> Export PDF
        </a>
        <!-- Opsi manual -->
        <a class="dropdown-item" href="{{ route('admin.laporan.pendaftar.export-manual') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}">
            <i class="fas fa-file-csv text-warning"></i> Export CSV (Manual)
        </a>
    </div>
</div>
<!-- Statistics Row -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 stat-card">
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

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Dalam Proses (Submit)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSubmit }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Diterima (Lulus)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLulus }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2 stat-card">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Ditolak</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDitolak }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Laporan</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.laporan.pendaftar') }}" id="filterForm">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" 
                               value="{{ request('tanggal_mulai') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                               value="{{ request('tanggal_selesai') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="jurusan_id">Jurusan</label>
                        <select class="form-control" id="jurusan_id" name="jurusan_id">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ request('jurusan_id') == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="gelombang_id">Gelombang</label>
                        <select class="form-control" id="gelombang_id" name="gelombang_id">
                            <option value="">Semua Gelombang</option>
                            @foreach($gelombangList as $gelombang)
                                <option value="{{ $gelombang->id }}" {{ request('gelombang_id') == $gelombang->id ? 'selected' : '' }}>
                                    {{ $gelombang->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">Semua Status</option>
                            @foreach($statusList as $key => $value)
                                <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="kabupaten">Kabupaten</label>
                        <input type="text" class="form-control" id="kabupaten" name="kabupaten" 
                               value="{{ request('kabupaten') }}" placeholder="Cari berdasarkan kabupaten...">
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group" style="margin-top: 32px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Terapkan Filter
                        </button>
                        <a href="{{ route('admin.laporan.pendaftar') }}" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Reset Filter
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pendaftar Per Bulan ({{ date('Y') }})</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pendaftarBulanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pendaftar Per Jurusan</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="pendaftarJurusanChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar</h6>
        <span class="badge badge-primary">Total: {{ $pendaftars->total() }} data</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan</th>
                        <th>Gelombang</th>
                        <th>Tanggal Daftar</th>
                        <th>Asal Sekolah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftars as $pendaftar)
                    <tr>
                        <td>{{ $pendaftar->no_pendaftaran }}</td>
                        <td>{{ $pendaftar->dataSiswa->nama ?? 'N/A' }}</td>
                        <td>{{ $pendaftar->jurusan->nama ?? 'N/A' }}</td>
                        <td>{{ $pendaftar->gelombang->nama ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d M Y') }}</td>
                        <td>{{ $pendaftar->asalSekolah->nama_sekolah ?? 'N/A' }}</td>
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
                                $currentStatus = $pendaftar->status;
                            @endphp
                            <span class="{{ $statusClass[$currentStatus] ?? 'badge badge-secondary' }}">
                                {{ $currentStatus }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle" type="button" 
                                        data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-cog"></i> Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.monitoring.pendaftar.detail', $pendaftar->id) }}">
                                        <i class="fas fa-eye text-info"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data pendaftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $pendaftars->links('custom.pagination') }}
        </div>
    </div>
</div>

<!-- Export Form (Hidden) -->
<form id="exportForm" action="{{ route('admin.laporan.pendaftar.export') }}" method="GET" style="display: none;">
    <input type="hidden" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
    <input type="hidden" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
    <input type="hidden" name="jurusan_id" value="{{ request('jurusan_id') }}">
    <input type="hidden" name="gelombang_id" value="{{ request('gelombang_id') }}">
    <input type="hidden" name="status" value="{{ request('status') }}">
    <input type="hidden" name="kabupaten" value="{{ request('kabupaten') }}">
    <input type="hidden" name="format" id="exportFormat">
</form>
@endsection

@section('scripts')
<script src="{{ asset('sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// DataTable
$(document).ready(function() {
    $('#dataTable').DataTable({
        "paging": false,
        "searching": false,
        "ordering": true,
        "info": false,
        "dom": 'Bfrtip'
    });
});

// Export Function
function exportReport(format) {
    document.getElementById('exportFormat').value = format;
    document.getElementById('exportForm').submit();
}

// Charts
document.addEventListener('DOMContentLoaded', function() {
    // Pendaftar Per Bulan Chart
    const bulanCtx = document.getElementById('pendaftarBulanChart').getContext('2d');
    const bulanChart = new Chart(bulanCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: [
                    {{ $pendaftarPerBulan->where('bulan', 1)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 2)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 3)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 4)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 5)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 6)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 7)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 8)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 9)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 10)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 11)->first()->total ?? 0 }},
                    {{ $pendaftarPerBulan->where('bulan', 12)->first()->total ?? 0 }}
                ],
                backgroundColor: 'rgba(78, 115, 223, 0.5)',
                borderColor: 'rgba(78, 115, 223, 1)',
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

    // Pendaftar Per Jurusan Chart
    const jurusanCtx = document.getElementById('pendaftarJurusanChart').getContext('2d');
    const jurusanChart = new Chart(jurusanCtx, {
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
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                    '#858796', '#5a5c69', '#6f42c1', '#e83e8c', '#fd7e14'
                ]
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
});
</script>
@endsection