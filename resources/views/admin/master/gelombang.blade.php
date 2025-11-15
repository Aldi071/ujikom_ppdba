{{-- resources/views/admin/master/gelombang.blade.php --}}
@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data Gelombang</h1>
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
            <!-- Form Tambah Gelombang -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        {{ isset($editGelombang) ? 'Edit Gelombang' : 'Tambah Gelombang' }}
                    </h6>
                </div>
                <div class="card-body">
                    @if(isset($editGelombang))
                        <form action="{{ route('admin.master.gelombang.update', $editGelombang->id) }}" method="POST">
                        @method('PUT')
                    @else
                        <form action="{{ route('admin.master.gelombang.store') }}" method="POST">
                    @endif
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama Gelombang *</label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" 
                                   value="{{ old('nama', isset($editGelombang) ? $editGelombang->nama : '') }}" 
                                   required maxlength="50" placeholder="Contoh: Gelombang 1">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun *</label>
                            <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                                   id="tahun" name="tahun" min="2020" max="2030"
                                   value="{{ old('tahun', isset($editGelombang) ? $editGelombang->tahun : date('Y')) }}" 
                                   required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_mulai">Tanggal Mulai *</label>
                            <input type="date" class="form-control @error('tgl_mulai') is-invalid @enderror" 
                                   id="tgl_mulai" name="tgl_mulai" 
                                   value="{{ old('tgl_mulai', isset($editGelombang) ? $editGelombang->tgl_mulai->format('Y-m-d') : '') }}" 
                                   required>
                            @error('tgl_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tgl_selesai">Tanggal Selesai *</label>
                            <input type="date" class="form-control @error('tgl_selesai') is-invalid @enderror" 
                                   id="tgl_selesai" name="tgl_selesai" 
                                   value="{{ old('tgl_selesai', isset($editGelombang) ? $editGelombang->tgl_selesai->format('Y-m-d') : '') }}" 
                                   required>
                            @error('tgl_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="biaya_daftar">Biaya Pendaftaran *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" class="form-control @error('biaya_daftar') is-invalid @enderror" 
                                       id="biaya_daftar" name="biaya_daftar" min="0" step="1000"
                                       value="{{ old('biaya_daftar', isset($editGelombang) ? $editGelombang->biaya_daftar : '') }}" 
                                       required>
                                @error('biaya_daftar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($editGelombang) ? 'Update' : 'Simpan' }}
                        </button>
                        @if(isset($editGelombang))
                            <a href="{{ route('admin.master.gelombang') }}" class="btn btn-secondary">Batal</a>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Data Table Gelombang -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Gelombang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tahun</th>
                                    <th>Periode</th>
                                    <th>Biaya</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gelombang as $item)
                                    @php
                                        $today = now()->format('Y-m-d');
                                        $tgl_mulai = $item->tgl_mulai->format('Y-m-d');
                                        $tgl_selesai = $item->tgl_selesai->format('Y-m-d');
                                        
                                        if ($today < $tgl_mulai) {
                                            $status = 'Akan Datang';
                                            $badge = 'secondary';
                                        } elseif ($today > $tgl_selesai) {
                                            $status = 'Selesai';
                                            $badge = 'dark';
                                        } else {
                                            $status = 'Aktif';
                                            $badge = 'success';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->nama }}</strong></td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>
                                            {{ $item->tgl_mulai->format('d/m/Y') }} - 
                                            {{ $item->tgl_selesai->format('d/m/Y') }}
                                        </td>
                                        <td>Rp {{ number_format($item->biaya_daftar, 0, ',', '.') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $badge }}">{{ $status }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.master.gelombang.edit', $item->id) }}" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.master.gelombang.destroy', $item->id) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" 
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus gelombang ini?')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data gelombang</td>
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
    $(document).ready(function() {
        // Auto-hide alert setelah 5 detik
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Validasi tanggal selesai harus setelah tanggal mulai
        $('#tgl_mulai').change(function() {
            var startDate = $(this).val();
            $('#tgl_selesai').attr('min', startDate);
        });

        $('#tgl_selesai').change(function() {
            var startDate = $('#tgl_mulai').val();
            var endDate = $(this).val();
            
            if (endDate <= startDate) {
                alert('Tanggal selesai harus setelah tanggal mulai');
                $(this).val('');
            }
        });

        // Format input biaya
        $('#biaya_daftar').on('input', function() {
            var value = $(this).val();
            if (value < 0) {
                $(this).val(0);
            }
        });
    });
</script>
@endsection