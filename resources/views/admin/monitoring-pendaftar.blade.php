@extends('admin.layouts.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Monitoring Pendaftar</h1>
</div>

<!-- Filter Section -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.monitoring.pendaftar.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Pencarian</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nama, NIK, NISN, No. Pendaftaran">
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.monitoring.pendaftar.index') }}" class="btn btn-secondary">
                                <i class="fas fa-sync"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pendaftar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No. Pendaftaran</th>
                        <th>Nama Siswa</th>
                        <th>Jurusan</th>
                        <th>Gelombang</th>
                        <th>Tanggal Daftar</th>
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
                        <td colspan="7" class="text-center">Tidak ada data pendaftar</td>
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
@endsection

@section('styles')
<link href="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "searching": false,
            "info": false,
            "ordering": true
        });
    });
</script>
@endsection