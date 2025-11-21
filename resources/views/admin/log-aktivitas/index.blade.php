@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Log Aktivitas</h1>
        <div>
            <a href="{{ route('admin.log-aktivitas.export') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> Export
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter"></i> Filter Data
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.log-aktivitas.index') }}" class="form-inline">
                <div class="form-group mr-3 mb-2">
                    <label for="search" class="mr-2">Cari:</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Aksi, Objek, User...">
                </div>

                <div class="form-group mr-3 mb-2">
                    <label for="aksi" class="mr-2">Aksi:</label>
                    <select class="form-control" id="aksi" name="aksi">
                        <option value="">-- Semua Aksi --</option>
                        <option value="CREATE" {{ request('aksi') == 'CREATE' ? 'selected' : '' }}>CREATE</option>
                        <option value="UPDATE" {{ request('aksi') == 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                        <option value="DELETE" {{ request('aksi') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
                        <option value="LOGIN" {{ request('aksi') == 'LOGIN' ? 'selected' : '' }}>LOGIN</option>
                        <option value="LOGOUT" {{ request('aksi') == 'LOGOUT' ? 'selected' : '' }}>LOGOUT</option>
                        <option value="VIEW" {{ request('aksi') == 'VIEW' ? 'selected' : '' }}>VIEW</option>
                        <option value="VERIFY" {{ request('aksi') == 'VERIFY' ? 'selected' : '' }}>VERIFY</option>
                        <option value="EXPORT" {{ request('aksi') == 'EXPORT' ? 'selected' : '' }}>EXPORT</option>
                    </select>
                </div>

                <div class="form-group mr-3 mb-2">
                    <label for="user_id" class="mr-2">User:</label>
                    <select class="form-control" id="user_id" name="user_id">
                        <option value="">-- Semua User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ request('user_id') == $user->user_id ? 'selected' : '' }}>
                                {{ $user->user->nama ?? 'System' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary mb-2">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.log-aktivitas.index') }}" class="btn btn-secondary mb-2 ml-2">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </form>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table"></i> Data Log Aktivitas
            </h6>
        </div>
        <div class="card-body">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th>No</th>
                                <th>Waktu</th>
                                <th>User</th>
                                <th>Aksi</th>
                                <th>Objek</th>
                                <th>IP Address</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}</td>
                                    <td>
                                        <small>
                                            {{ $log->waktu->format('d/m/Y H:i:s') }}
                                            <br>
                                            <span class="text-muted">{{ $log->waktu->diffForHumans() }}</span>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $log->user->nama ?? 'System' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $colors = [
                                                'CREATE' => 'success',
                                                'UPDATE' => 'info',
                                                'DELETE' => 'danger',
                                                'LOGIN' => 'primary',
                                                'LOGOUT' => 'warning',
                                                'VIEW' => 'secondary',
                                                'EXPORT' => 'info',
                                                'IMPORT' => 'info',
                                                'VERIFY' => 'success',
                                                'REJECT' => 'danger'
                                            ];
                                            $color = $colors[$log->aksi] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $color }}">{{ $log->aksi }}</span>
                                    </td>
                                    <td>{{ $log->objek }}</td>
                                    <td><small>{{ $log->ip }}</small></td>
                                    <td>
                                        <a href="{{ route('admin.log-aktivitas.show', $log->id) }}" 
                                           class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.log-aktivitas.destroy', $log->id) }}" 
                                              method="POST" style="display:inline;" 
                                              onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $logs->links() }}
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> Tidak ada data log aktivitas
                </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Tambahkan custom script jika diperlukan
</script>
@endpush
