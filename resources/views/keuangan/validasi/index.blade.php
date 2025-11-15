{{-- resources/views/keuangan/validasi/index.blade.php --}}
@extends('keuangan.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Validasi Bukti Bayar</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('keuangan.validasi.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama atau No. Pendaftaran">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jurusan">Jurusan</label>
                            <select class="form-control" id="jurusan" name="jurusan">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                    <option value="{{ $jurusan->id }}" {{ request('jurusan') == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="gelombang">Gelombang</label>
                            <select class="form-control" id="gelombang" name="gelombang">
                                <option value="">Semua Gelombang</option>
                                @foreach($gelombangList as $gelombang)
                                    <option value="{{ $gelombang->id }}" {{ request('gelombang') == $gelombang->id ? 'selected' : '' }}>
                                        {{ $gelombang->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('keuangan.validasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Bukti Bayar Masuk</h6>
            <span class="badge badge-primary">Total: {{ $pendaftars->total() }} Data</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Gelombang</th>
                            <th>Biaya Daftar</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftars as $pendaftar)
                        <tr>
                            <td>{{ $pendaftar->no_pendaftaran }}</td>
                            <td>{{ $pendaftar->nama }}</td>
                            <td>{{ $pendaftar->jurusan }}</td>
                            <td>{{ $pendaftar->gelombang }}</td>
                            <td>Rp {{ number_format($pendaftar->biaya_daftar, 0, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                            </td>
                            <td>
                                <a href="{{ route('keuangan.validasi.detail', $pendaftar->id) }}" 
                                   class="btn btn-sm btn-primary" title="Validasi">
                                    <i class="fas fa-check-circle"></i> Validasi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada data bukti bayar yang menunggu validasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $pendaftars->links() }}
            </div>
        </div>
    </div>

</div>
@endsection