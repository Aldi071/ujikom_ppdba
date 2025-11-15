@extends('kepsek.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Hasil Seleksi PPDB</h1>
        <div>
            <a href="{{ route('kepsek.hasil-seleksi.export', request()->all()) }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-file-excel fa-sm text-white-50"></i> Export Excel
            </a>
            <a href="{{ route('kepsek.hasil-seleksi.print', request()->all()) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-print fa-sm text-white-50"></i> Cetak
            </a>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Lulus Seleksi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalLulus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Tidak Lulus
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalTidakLulus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Cadangan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCadangan }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('kepsek.hasil-seleksi') }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Status Seleksi</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="LULUS" {{ $status == 'LULUS' ? 'selected' : '' }}>Lulus</option>
                                <option value="TIDAK_LULUS" {{ $status == 'TIDAK_LULUS' ? 'selected' : '' }}>Tidak Lulus</option>
                                <option value="CADANGAN" {{ $status == 'CADANGAN' ? 'selected' : '' }}>Cadangan</option>
                                <option value="PAID" {{ $status == 'PAID' ? 'selected' : '' }}>Sudah Bayar</option>
                                <option value="ADM_PASS" {{ $status == 'ADM_PASS' ? 'selected' : '' }}>Lulus Administrasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="jurusan_id">Jurusan</label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ $jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="gelombang_id">Gelombang</label>
                            <select class="form-control" id="gelombang_id" name="gelombang_id">
                                <option value="">Semua Gelombang</option>
                                @foreach($gelombangList as $gelombang)
                                    <option value="{{ $gelombang->id }}" {{ $gelombang_id == $gelombang->id ? 'selected' : '' }}>
                                        {{ $gelombang->nama }} - {{ $gelombang->tahun }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ $search }}" placeholder="Nama / No. Pendaftaran / NISN">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter"></i> Filter Data
                        </button>
                        <a href="{{ route('kepsek.hasil-seleksi') }}" class="btn btn-secondary">
                            <i class="fas fa-sync"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Results Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Hasil Seleksi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>No. Pendaftaran</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Asal Sekolah</th>
                            <th>Jurusan</th>
                            <th>Gelombang</th>
                            <th>Status</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilSeleksi as $key => $pendaftar)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <strong>{{ $pendaftar->no_pendaftaran }}</strong>
                            </td>
                            <td>{{ $pendaftar->dataSiswa->nama ?? '-' }}</td>
                            <td>{{ $pendaftar->dataSiswa->nisn ?? '-' }}</td>
                            <td>{{ $pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $pendaftar->jurusan->nama ?? '-' }}</span>
                            </td>
                            <td>{{ $pendaftar->gelombang->nama ?? '-' }}</td>
                            <td>
                                @if($pendaftar->status == 'LULUS')
                                    <span class="badge badge-success">LULUS</span>
                                @elseif($pendaftar->status == 'TIDAK_LULUS')
                                    <span class="badge badge-danger">TIDAK LULUS</span>
                                @elseif($pendaftar->status == 'CADANGAN')
                                    <span class="badge badge-warning">CADANGAN</span>
                                @elseif($pendaftar->status == 'PAID')
                                    <span class="badge badge-primary">SUDAH BAYAR</span>
                                @elseif($pendaftar->status == 'ADM_PASS')
                                    <span class="badge badge-info">LULUS ADMINISTRASI</span>
                                @else
                                    <span class="badge badge-secondary">{{ $pendaftar->status }}</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center">Tidak ada data hasil seleksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($hasilSeleksi->count() > 0)
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted">Menampilkan <strong>{{ $hasilSeleksi->count() }}</strong> hasil seleksi</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('kepsek.hasil-seleksi.export', request()->all()) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="{{ route('kepsek.hasil-seleksi.print', request()->all()) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="fas fa-print"></i> Cetak
                        </a>
                    </div>
                </div>
            </div>
            @endif
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
    // Auto submit form ketika filter berubah
    document.addEventListener('DOMContentLoaded', function() {
        const filterSelects = document.querySelectorAll('#status, #jurusan_id, #gelombang_id');
        
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    });
</script>
@endpush