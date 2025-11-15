@extends('admin.layouts.main')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pendaftar - {{ $pendaftar->no_pendaftaran }}</h1>
    <a href="{{ route('admin.monitoring.pendaftar.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Data Siswa -->
    <div class="col-lg-6 mb-4">
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
                        <td>{{ $pendaftar->dataSiswa->nama ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $pendaftar->dataSiswa->nik ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>NISN</th>
                        <td>{{ $pendaftar->dataSiswa->nisn ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>{{ $pendaftar->dataSiswa->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>{{ $pendaftar->dataSiswa->tmp_lahir ?? 'N/A' }}, {{ \Carbon\Carbon::parse($pendaftar->dataSiswa->tgl_lahir)->format('d M Y') ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $pendaftar->dataSiswa->alamat ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Pendaftaran -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Pendaftaran</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Jurusan</th>
                        <td>{{ $pendaftar->jurusan->nama ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Gelombang</th>
                        <td>{{ $pendaftar->gelombang->nama ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td>{{ \Carbon\Carbon::parse($pendaftar->tanggal_daftar)->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @php
                                $statusClass = [
                                    'DRAFT' => 'badge badge-secondary',
                                    'SUBMIT' => 'badge badge-warning',
                                    'ADM_PASS' => 'badge badge-info',
                                    'ADM_REJECT' => 'badge badge-danger',
                                    'PAID' => 'badge badge-primary',
                                    'LULUS' => 'badge badge-success',
                                    'TIDAK_LULUS' => 'badge badge-danger',
                                    'CADANGAN' => 'badge badge-warning',
                                ];
                                $currentStatus = $pendaftar->status;
                            @endphp
                            <span class="{{ $statusClass[$currentStatus] ?? 'badge badge-secondary' }}">
                                {{ $currentStatus }}
                            </span>
                        </td>
                    </tr>
                    @if($pendaftar->tgl_verifikasi_adm)
                    <tr>
                        <th>Verifikasi Admin</th>
                        <td>{{ $pendaftar->user_verifikasi_adm }} - {{ \Carbon\Carbon::parse($pendaftar->tgl_verifikasi_adm)->format('d M Y H:i') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Data Orang Tua -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Orang Tua</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th colspan="2" class="bg-light">Ayah</th>
                    </tr>
                    <tr>
                        <th width="40%">Nama</th>
                        <td>{{ $pendaftar->dataOrtu->nama_ayah ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $pendaftar->dataOrtu->pekerjaan_ayah ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $pendaftar->dataOrtu->hp_ayah ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="bg-light">Ibu</th>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>{{ $pendaftar->dataOrtu->nama_ibu ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Pekerjaan</th>
                        <td>{{ $pendaftar->dataOrtu->pekerjaan_ibu ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $pendaftar->dataOrtu->hp_ibu ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Data Asal Sekolah -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Asal Sekolah</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="40%">Nama Sekolah</th>
                        <td>{{ $pendaftar->asalSekolah->nama_sekolah ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>NPSN</th>
                        <td>{{ $pendaftar->asalSekolah->npsn ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Kabupaten</th>
                        <td>{{ $pendaftar->asalSekolah->kabupaten ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Rata-rata</th>
                        <td>{{ $pendaftar->asalSekolah->nilai_rata ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Berkas -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Berkas Pendaftaran</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Berkas</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendaftar->berkas as $berkas)
                            <tr>
                                <td>{{ $berkas->jenis }}</td>
                                <td>{{ $berkas->nama_file }}</td>
                                <td>{{ $berkas->ukuran_kb }} KB</td>
                                <td>
                                    @if($berkas->valid)
                                        <span class="badge badge-success">Valid</span>
                                    @else
                                        <span class="badge badge-warning">Belum Divalidasi</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ asset('storage/' . $berkas->url) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada berkas</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection