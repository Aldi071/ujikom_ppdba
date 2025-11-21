{{-- resources/views/verifikator/data-pendaftar.blade.php --}}
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
@php
use Illuminate\Support\Facades\DB;
@endphp
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Pendaftar</h1>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('verifikator.data-pendaftar') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
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
                    <div class="col-md-3">
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
                    <div class="col-md-3">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Pencarian</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama atau No. Pendaftaran">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <a href="{{ route('verifikator.data-pendaftar') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Reset
                </a>
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
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No. Pendaftaran</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Jurusan</th>
                            <th>Gelombang</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftars as $pendaftar)
                        @php
                            // Cek apakah ada reupload pada berkas (REUPLOAD marker)
                            $hasReupload = DB::table('pendaftar_berkas')
                                ->where('pendaftar_id', $pendaftar->id)
                                ->where('catatan', 'like', '%REUPLOAD%')
                                ->exists();
                        @endphp
                        <tr {{ $hasReupload ? 'style="background-color: #fffbeb;"' : '' }}>
                            <td>{{ $pendaftar->no_pendaftaran }}</td>
                            <td>{{ $pendaftar->nama }}
                                @if($hasReupload)
                                    <small class="ml-2 text-warning"><i class="fas fa-redo"></i> Reupload</small>
                                @endif
                            </td>
                            <td>{{ $pendaftar->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            <td>{{ $pendaftar->jurusan }}</td>
                            <td>{{ $pendaftar->gelombang }}</td>
                            <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                            <td>
                                @php
                                    $statusClass = [
                                        'DRAFT' => 'secondary',
                                        'SUBMIT' => 'warning',
                                        'ADM_PASS' => 'success',
                                        'ADM_REJECT' => 'danger',
                                        'PAID' => 'info',
                                        'LULUS' => 'success',
                                        'TIDAK_LULUS' => 'danger',
                                        'CADANGAN' => 'warning'
                                    ][$pendaftar->status] ?? 'secondary';
                                @endphp
                                <span class="badge badge-{{ $statusClass }}">
                                    {{ $statusList[$pendaftar->status] ?? $pendaftar->status }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" 
                                            data-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-cog"></i> Aksi
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('verifikator.detail-pendaftar', $pendaftar->id) }}">
                                            <i class="fas fa-eye text-info"></i> Lihat Detail
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <button type="button" class="dropdown-item" 
                                                data-toggle="modal" data-target="#statusModal{{ $pendaftar->id }}">
                                            <i class="fas fa-edit text-warning"></i> Edit Status
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Status Modal -->
                        <div class="modal fade" id="statusModal{{ $pendaftar->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('verifikator.update-status', $pendaftar->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Status - {{ $pendaftar->no_pendaftaran }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="status">Status Baru</label>
                                                <select class="form-control" name="status" required>
                                                    @foreach($statusList as $key => $value)
                                                        <option value="{{ $key }}" {{ $pendaftar->status == $key ? 'selected' : '' }}>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="catatan">Catatan (Opsional)</label>
                                                <textarea class="form-control" name="catatan" rows="3" 
                                                          placeholder="Berikan catatan jika diperlukan"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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

</div>
@endsection

@push('scripts')
<script>
function updateStatus(id, status) {
    if (confirm('Apakah Anda yakin ingin mengubah status pendaftar ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `{{ url('verifikator/pendaftar') }}/${id}/status`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = status;
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        form.appendChild(statusField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush