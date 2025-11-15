@extends('admin.layouts.main')

@section('styles')
<link href="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    .status-badge {
        font-size: 0.8rem;
        padding: 0.35rem 0.65rem;
    }
    .role-badge {
        font-size: 0.75rem;
    }
</style>
@endsection

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Akun</h1>
    <a href="{{ route('admin.akun.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Akun
    </a>
</div>

<!-- Filter Section -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter Data</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.akun.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="search">Pencarian</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nama, Email, No. HP">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="">Semua Role</option>
                            @foreach($roleList as $key => $value)
                                <option value="{{ $key }}" {{ request('role') == $key ? 'selected' : '' }}>
                                    {{ $value }}
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
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i> Filter
                            </button>
                            <a href="{{ route('admin.akun.index') }}" class="btn btn-secondary">
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
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Akun</h6>
        <span class="badge badge-primary">Total: {{ $users->total() }} akun</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Tanggal Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>
                            <strong>{{ $user->nama }}</strong>
                            @if($user->id === auth()->user()->id)
                                <span class="badge badge-info badge-pill">Anda</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->hp ?? '-' }}</td>
                        <td>
                            @php
                                $roleColors = [
                                    'admin' => 'badge-primary',
                                    'verifikator_adm' => 'badge-warning',
                                    'keuangan' => 'badge-success',
                                    'kepsek' => 'badge-info'
                                ];
                                $roleText = [
                                    'admin' => 'Admin',
                                    'verifikator_adm' => 'Verifikator',
                                    'keuangan' => 'Keuangan',
                                    'kepsek' => 'Kepsek'
                                ];
                            @endphp
                            <span class="badge {{ $roleColors[$user->role] ?? 'badge-secondary' }} role-badge">
                                {{ $roleText[$user->role] ?? $user->role }}
                            </span>
                        </td>
                        <td>
                            @if($user->aktif)
                                <span class="badge badge-success status-badge">Aktif</span>
                            @else
                                <span class="badge badge-danger status-badge">Nonaktif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.akun.edit', $user->id) }}" 
                                   class="btn btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($user->id !== auth()->user()->id)
                                    <form action="{{ route('admin.akun.toggle-status', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn {{ $user->aktif ? 'btn-warning' : 'btn-success' }}" 
                                                title="{{ $user->aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas {{ $user->aktif ? 'fa-ban' : 'fa-check' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('admin.akun.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary" disabled title="Tidak dapat mengubah akun sendiri">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data akun</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('sb-admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "searching": false,
            "ordering": true,
            "info": false
        });
    });
</script>
@endsection