@extends('admin.layouts.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Akun Baru</h1>
    <a href="{{ route('admin.akun.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Tambah Akun</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.akun.store') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="nama">Nama Lengkap *</label> <!-- PERUBAHAN: name menjadi nama -->
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hp">Nomor HP *</label> <!-- PERUBAHAN: phone menjadi hp -->
                        <input type="text" class="form-control @error('hp') is-invalid @enderror" 
                               id="hp" name="hp" value="{{ old('hp') }}" required>
                        @error('hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            @foreach($roleList as $key => $value)
                                <option value="{{ $key }}" {{ old('role') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password *</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle"></i> 
                            Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Akun
                    </button>
                    <a href="{{ route('admin.akun.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Role</h6>
            </div>
            <div class="card-body">
                <div class="small">
                    <p><strong>Administrator:</strong></p>
                    <ul>
                        <li>Akses penuh ke semua fitur</li>
                        <li>Dapat mengelola semua data</li>
                        <li>Dapat mengelola akun pengguna</li>
                    </ul>
                    
                    <p><strong>Verifikator Administrasi:</strong></p>
                    <ul>
                        <li>Dapat memverifikasi data pendaftar</li>
                        <li>Dapat mengubah status pendaftaran</li>
                        <li>Tidak dapat mengelola akun</li>
                    </ul>
                    
                    <p><strong>Staff Keuangan:</strong></p>
                    <ul>
                        <li>Dapat memverifikasi pembayaran</li>
                        <li>Dapat melihat laporan keuangan</li>
                        <li>Tidak dapat mengelola data master</li>
                    </ul>
                    
                    <p><strong>Kepala Sekolah:</strong></p>
                    <ul>
                        <li>Dapat melihat laporan dan statistik</li>
                        <li>Dapat melihat data pendaftar</li>
                        <li>Akses terbatas untuk monitoring</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection