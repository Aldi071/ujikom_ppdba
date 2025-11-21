@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Log Aktivitas</h1>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-history"></i> Informasi Log
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-gray-700 font-weight-bold">ID Log</h6>
                            <p class="text-gray-800">{{ $log->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray-700 font-weight-bold">Waktu</h6>
                            <p class="text-gray-800">{{ $log->waktu->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6 class="text-gray-700 font-weight-bold">User</h6>
                            <p class="text-gray-800">
                                <span class="badge badge-info">{{ $log->user->nama ?? 'System' }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray-700 font-weight-bold">Aksi</h6>
                            <p class="text-gray-800">
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
                            </p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6 class="text-gray-700 font-weight-bold">Objek</h6>
                            <p class="text-gray-800">{{ $log->objek }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h6 class="text-gray-700 font-weight-bold">IP Address</h6>
                            <p class="text-gray-800">{{ $log->ip }}</p>
                        </div>
                    </div>

                    @if($log->objek_data)
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="text-gray-700 font-weight-bold">Data Objek</h6>
                                <pre class="bg-light p-3 rounded">{{ json_encode($log->objek_data, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('admin.log-aktivitas.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <form action="{{ route('admin.log-aktivitas.destroy', $log->id) }}" 
                                  method="POST" style="display:inline;" 
                                  onsubmit="return confirm('Yakin ingin menghapus log ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4 bg-light">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle"></i> Ringkasan
                    </h6>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">ID:</dt>
                        <dd class="col-sm-7"><small>{{ $log->id }}</small></dd>

                        <dt class="col-sm-5">Aksi:</dt>
                        <dd class="col-sm-7">
                            @php $color = $colors[$log->aksi] ?? 'secondary'; @endphp
                            <span class="badge badge-{{ $color }}">{{ $log->aksi }}</span>
                        </dd>

                        <dt class="col-sm-5">User:</dt>
                        <dd class="col-sm-7"><small>{{ $log->user->nama ?? 'System' }}</small></dd>

                        <dt class="col-sm-5">Waktu:</dt>
                        <dd class="col-sm-7">
                            <small>
                                {{ $log->waktu->format('d M Y') }}
                                <br>
                                {{ $log->waktu->format('H:i:s') }}
                            </small>
                        </dd>

                        <dt class="col-sm-5">IP:</dt>
                        <dd class="col-sm-7"><small>{{ $log->ip }}</small></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
