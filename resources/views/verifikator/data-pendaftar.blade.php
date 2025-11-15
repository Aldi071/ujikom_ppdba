{{-- resources/views/verifikator/data-pendaftar.blade.php --}}
@extends('verifikator.layouts.admin')

@section('content')
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
                        <tr>
                            <td>{{ $pendaftar->no_pendaftaran }}</td>
                            <td>{{ $pendaftar->nama }}</td>
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
                                <a href="{{ route('verifikator.detail-pendaftar', $pendaftar->id) }}" 
                                   class="btn btn-sm btn-primary" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if($pendaftar->status == 'SUBMIT')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success" 
                                            onclick="updateStatus({{ $pendaftar->id }}, 'ADM_PASS')"
                                            title="Terima">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            onclick="updateStatus({{ $pendaftar->id }}, 'ADM_REJECT')"
                                            title="Tolak">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                @endif
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
                {{ $pendaftars->links() }}
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