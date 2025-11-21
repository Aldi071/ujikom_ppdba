{{-- resources/views/kepsek/seleksi-pendaftar.blade.php --}}
@extends('kepsek.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Final Selection - Keputusan Penerimaan</h1>
        <a href="{{ route('kepsek.hasil-seleksi') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                            <td>{{ $pendaftar->nisn }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Kelamin</th>
                            <td>{{ $pendaftar->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <th>Tempat, Tanggal Lahir</th>
                            <td>{{ $pendaftar->tmp_lahir }}, {{ \Carbon\Carbon::parse($pendaftar->tgl_lahir)->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Jurusan</th>
                            <td>{{ $pendaftar->jurusan }}</td>
                        </tr>
                        <tr>
                            <th>Gelombang</th>
                            <td>{{ $pendaftar->gelombang }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Daftar</th>
                            <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Status Verifikasi</th>
                            <td>
                                @php
                                    $statusClass = [
                                        'PAID' => 'success',
                                        'ADM_PASS' => 'success',
                                    ][$pendaftar->status] ?? 'secondary';
                                @endphp
                                <span class="badge badge-{{ $statusClass }}">
                                    {{ $statusList[$pendaftar->status] ?? $pendaftar->status }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Asal Sekolah -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Asal Sekolah</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Nama Sekolah</th>
                    <td>{{ $pendaftar->nama_sekolah ?? '-' }}</td>
                </tr>
                <tr>
                    <th>NPSN</th>
                    <td>{{ $pendaftar->npsn ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Kabupaten</th>
                    <td>{{ $pendaftar->kabupaten ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Nilai Rata-rata</th>
                    <td>{{ $pendaftar->nilai_rata ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Final Selection Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Keputusan Akhir Penerimaan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('kepsek.seleksi.update', $pendaftar->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status"><strong>Status Keputusan</strong></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">-- Pilih Keputusan --</option>
                                <option value="LULUS">🎉 LULUS (Diterima)</option>
                                <option value="TIDAK_LULUS">❌ TIDAK LULUS (Ditolak)</option>
                                <option value="CADANGAN">⏳ CADANGAN (Daftar Tunggu)</option>
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
                                      placeholder="Berikan catatan jika diperlukan">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> 
                    Keputusan ini akan dikirimkan ke calon siswa melalui WhatsApp sebagai notifikasi resmi penerimaan.
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-check"></i> Simpan Keputusan Akhir
                    </button>
                    <a href="{{ route('kepsek.hasil-seleksi') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
