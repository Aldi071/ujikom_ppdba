{{-- resources/views/keuangan/validasi/detail.blade.php --}}
@extends('keuangan.layouts.admin')

@php
use Illuminate\Support\Facades\DB;
@endphp

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Validasi Bukti Bayar</h1>
        <a href="{{ route('keuangan.validasi.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
        </a>
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

    <!-- Data Siswa -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">No. Pendaftaran</th>
                            <td>{{ $pendaftar->no_pendaftaran }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $pendaftar->nama }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>{{ $pendaftar->nisn ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jurusan</th>
                            <td>{{ $pendaftar->jurusan }}</td>
                        </tr>
                        <tr>
                            <th>Gelombang</th>
                            <td>{{ $pendaftar->gelombang }}</td>
                        </tr>
                        <tr>
                            <th>Biaya Pendaftaran</th>
                            <td>Rp {{ number_format($pendaftar->biaya_daftar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bukti Pembayaran</h6>
                </div>
                <div class="card-body">
                    @if($pendaftar->bukti_bayar_url)
                        {{-- Cek jika ini adalah reupload --}}
                        @php
                            // Query langsung untuk cek catatan berkas
                            $berkasInfo = DB::table('pendaftar_berkas')
                                ->where('pendaftar_id', $pendaftar->id)
                                ->where('jenis', 'BUKTI_BAYAR')
                                ->first();
                            $isReupload = $berkasInfo && strpos($berkasInfo->catatan, 'REUPLOAD') !== false;
                        @endphp
                        
                        @if($isReupload)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fas fa-redo"></i>
                            <strong>Bukti Pembayaran Reupload</strong><br>
                            <small>Pendaftar telah mengupload ulang bukti pembayaran yang sebelumnya ditolak. Silakan verifikasi kembali.</small>
                        </div>
                        @endif
                        
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pendaftar->bukti_bayar_url) }}" 
                                 alt="Bukti Bayar" class="img-fluid img-thumbnail" style="max-height: 300px;">
                            <div class="mt-3">
                                <a href="{{ asset('storage/' . $pendaftar->bukti_bayar_url) }}" 
                                   target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-expand"></i> Lihat Full Size
                                </a>
                                <a href="{{ asset('storage/' . $pendaftar->bukti_bayar_url) }}" 
                                   download class="btn btn-sm btn-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">
                                    File: {{ $pendaftar->bukti_bayar_file }} 
                                    ({{ number_format($pendaftar->bukti_bayar_size / 1024, 2) }} KB)
                                </small>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-muted">
                            <i class="fas fa-receipt fa-3x mb-3"></i>
                            <p>Bukti bayar belum diupload</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Pembayaran -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informasi Pembayaran</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Rekening Tujuan</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Bank</th>
                            <td>BANK BRI</td>
                        </tr>
                        <tr>
                            <th>No. Rekening</th>
                            <td>1234-5678-9012-3456</td>
                        </tr>
                        <tr>
                            <th>Atas Nama</th>
                            <td>SMK NEGERI 1 CONTOH</td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td>Rp {{ number_format($pendaftar->biaya_daftar, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Status Verifikasi</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Status Saat Ini</th>
                            <td>
                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Verifikator Administrasi</th>
                            <td>{{ $pendaftar->user_verifikasi_adm ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Verifikasi Adm</th>
                            <td>
                                @if($pendaftar->tgl_verifikasi_adm)
                                    {{ \Carbon\Carbon::parse($pendaftar->tgl_verifikasi_adm)->format('d/m/Y H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Validasi -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Verifikasi Pembayaran</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('keuangan.validasi.update-status', $pendaftar->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status Verifikasi</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="PAID" {{ old('status') == 'PAID' ? 'selected' : '' }}>Pembayaran Valid</option>
                                <option value="ADM_REJECT" {{ old('status') == 'ADM_REJECT' ? 'selected' : '' }}>Pembayaran Tidak Valid</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="catatan">Catatan (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      id="catatan" name="catatan" rows="3" 
                                      placeholder="Berikan catatan jika diperlukan (contoh: nominal tidak sesuai, bukti tidak jelas, dll)">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Perhatian:</strong> Pastikan bukti pembayaran sudah sesuai dengan nominal dan rekening tujuan sebelum melakukan verifikasi.
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Simpan Verifikasi
                </button>
            </form>
        </div>
    </div>

</div>
@endsection