{{-- resources/views/admin/master/jurusan.blade.php --}}
@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data Jurusan</h1>
    </div>

    <!-- Alert Messages -->
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

    <div class="row">
        <div class="col-md-4">
            <!-- Form Tambah Jurusan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ isset($editJurusan) ? 'Edit Jurusan' : 'Tambah Jurusan' }}
                    </h6>
                </div>
                <div class="card-body">
                    @if(isset($editJurusan))
                        <form action="{{ route('admin.master.jurusan.update', $editJurusan->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.master.jurusan.store') }}" method="POST">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label for="kode">Kode Jurusan *</label>
                            <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                                   id="kode" name="kode" 
                                   value="{{ old('kode', isset($editJurusan) ? $editJurusan->kode : '') }}" 
                                   required maxlength="10">
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Jurusan *</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" 
                                   value="{{ old('nama', isset($editJurusan) ? $editJurusan->nama : '') }}" 
                                   required maxlength="100">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota *</label>
                            <input type="number" class="form-control @error('kuota') is-invalid @enderror" 
                                   id="kuota" name="kuota" min="1" 
                                   value="{{ old('kuota', isset($editJurusan) ? $editJurusan->kuota : '') }}" 
                                   required>
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($editJurusan) ? 'Update' : 'Simpan' }}
                        </button>
                        @if(isset($editJurusan))
                            <a href="{{ route('admin.master.jurusan') }}" class="btn btn-secondary">Batal</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Data Table Jurusan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Jurusan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Jurusan</th>
                                    <th>Kuota</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jurusan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->kode }}</strong></td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->kuota }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.master.jurusan.edit', $item->id) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.master.jurusan.destroy', $item->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus jurusan ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data jurusan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Auto-hide alert setelah 5 detik
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endsection