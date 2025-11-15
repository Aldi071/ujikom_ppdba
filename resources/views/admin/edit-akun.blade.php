@extends('admin.layouts.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Akun - {{ $user->nama }}</h1> <!-- PERUBAHAN: name menjadi nama -->
    <a href="{{ route('admin.akun.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Form Edit Akun</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.akun.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="nama">Nama Lengkap *</label> <!-- PERUBAHAN: name menjadi nama -->
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" name="nama" value="{{ old('nama', $user->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="hp">Nomor HP *</label> <!-- PERUBAHAN: phone menjadi hp -->
                        <input type="text" class="form-control @error('hp') is-invalid @enderror" 
                               id="hp" name="hp" value="{{ old('hp', $user->hp) }}" required>
                        @error('hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Role *</label>
                        <select class="form-control @error('role') is-invalid @enderror" id="role" name="role" required>
                            <option value="">Pilih Role</option>
                            @foreach($roleList as $key => $value)
                                <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="aktif">Status Akun *</label> <!-- PERUBAHAN: is_active menjadi aktif -->
                        <select class="form-control @error('aktif') is-invalid @enderror" id="aktif" name="aktif" required>
                            <option value="1" {{ old('aktif', $user->aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('aktif', $user->aktif) == 0 ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                        @error('aktif')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle"></i> 
                            Jika mengubah password, password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan simbol.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Akun
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
                <h6 class="m-0 font-weight-bold text-primary">Informasi Akun</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-user text-white" style="font-size: 2rem;"></i>
                    </div>
                </div>
                
                <table class="table table-sm table-borderless">
                    <tr>
                        <td><strong>ID:</strong></td>
                        <td>{{ $user->id }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diupdate:</strong></td>
                        <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if($user->aktif) <!-- PERUBAHAN: is_active menjadi aktif -->
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Nonaktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Verifikasi:</strong></td>
                        <td>
                            @if($user->is_verified)
                                <span class="badge badge-success">Terverifikasi</span>
                            @else
                                <span class="badge badge-warning">Belum Verifikasi</span>
                            @endif
                        </td>
                    </tr>
                </table>
                
                @if($user->id === auth()->user()->id)
                    <div class="alert alert-warning small">
                        <i class="fas fa-exclamation-triangle"></i>
                        Anda sedang mengedit akun sendiri. Hati-hati dalam melakukan perubahan.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection