{{-- resources/views/verifikator/detail-pendaftar.blade.php --}}
@extends('verifikator.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pendaftar</h1>
        <a href="{{ route('verifikator.data-pendaftar') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
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
                            <th>NIK</th>
                            <td>{{ $pendaftar->nik }}</td>
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
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $pendaftar->alamat }}</td>
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
                            <th>Status</th>
                            <td>
                                @php
                                    $statusClass = [
                                        'DRAFT' => 'secondary',
                                        'SUBMIT' => 'warning',
                                        'ADM_PASS' => 'success',
                                        'ADM_REJECT' => 'danger',
                                        'PAID' => 'info',
                                        'LULUS' => 'success',
                                        'TIDAK_LULUS' => 'danger',
                                        'CADANGAN' => 'warning'
                                    ][$pendaftar->status] ?? 'secondary';
                                @endphp
                                <span class="badge badge-{{ $statusClass }}">
                                    {{ $statusList[$pendaftar->status] ?? $pendaftar->status }}
                                </span>
                            </td>
                        </tr>
                        @if($pendaftar->user_verifikasi_adm)
                        <tr>
                            <th>Divervifikasi Oleh</th>
                            <td>{{ $pendaftar->user_verifikasi_adm }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Verifikasi</th>
                            <td>{{ \Carbon\Carbon::parse($pendaftar->tgl_verifikasi_adm)->format('d/m/Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Orang Tua -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Orang Tua</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Ayah</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $pendaftar->nama_ayah ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $pendaftar->pekerjaan_ayah ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6>Ibu</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Nama</th>
                            <td>{{ $pendaftar->nama_ibu ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Pekerjaan</th>
                            <td>{{ $pendaftar->pekerjaan_ibu ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
                <table class="table table-bordered">
                <tr>
                    <th>Nomor Handphone</th>
                    <td>{{ $pendaftar->hp_ibu ?? '-' }}</td>
                </tr>
                </table>
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

    <!-- Berkas -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Berkas Pendaftaran</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @forelse($berkas as $item)
                @php
                    $isReupload = $item->catatan && strpos($item->catatan, 'REUPLOAD') !== false;
                @endphp
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                            <h6 class="card-title text-uppercase">{{ $item->jenis }}
                                @if($isReupload)
                                    <span class="badge badge-warning ml-2" style="font-size: 0.7rem;">REUPLOAD</span>
                                @endif
                            </h6>
                            <p class="text-muted small">{{ number_format($item->ukuran_kb) }} KB</p>
                            <a href="{{ asset('storage/' . $item->url) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-secondary">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                            <a href="{{ asset('storage/' . $item->url) }}" 
                               download class="btn btn-sm btn-success">
                                <i class="fas fa-download"></i> Download
                            </a>
                            @if($item->catatan)
                            <div class="mt-2 text-left">
                                <small class="text-muted"><strong>Catatan:</strong> {{ $item->catatan }}</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted">Tidak ada berkas yang diupload</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Aksi Verifikasi -->
    @if(in_array($pendaftar->status, ['SUBMIT', 'ADM_PASS', 'ADM_REJECT']))
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Verifikasi Berkas</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('verifikator.update-status', $pendaftar->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status Verifikasi Berkas</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required onchange="toggleRejectOptions()">
                                <option value="">Pilih Status</option>
                                <option value="ADM_PASS">✓ Berkas Diterima</option>
                                <option value="ADM_REJECT">✗ Berkas Ditolak</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="catatan">Catatan Umum (Opsional)</label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" 
                                      id="catatan" name="catatan" rows="2" 
                                      placeholder="Berikan catatan umum jika diperlukan">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Berkas yang Ditolak -->
                <div id="rejectOptions" style="display: none;">
                    <hr>
                    <h6 class="text-danger">Berkas yang Ditolak</h6>
                    <p class="text-muted small">Pilih berkas yang ditolak dan berikan catatan untuk masing-masing berkas:</p>
                    
                    @if($berkas->count() > 0)
                        <div class="row">
                            @foreach($berkas as $item)
                            <div class="col-md-6 mb-3">
                                <div class="card border-left-danger">
                                    <div class="card-body">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" 
                                                   id="reject_{{ $item->id }}" 
                                                   name="rejected_berkas[]" 
                                                   value="{{ $item->id }}"
                                                   onchange="toggleBerkasNote({{ $item->id }})">
                                            <label class="custom-control-label font-weight-bold" for="reject_{{ $item->id }}">
                                                {{ $item->jenis }}
                                            </label>
                                        </div>
                                        <div class="mt-2">
                                            <textarea class="form-control form-control-sm berkas-note" 
                                                      id="note_{{ $item->id }}"
                                                      name="berkas_catatan[{{ $item->id }}]" 
                                                      rows="2" 
                                                      placeholder="Catatan untuk berkas {{ $item->jenis }}..." disabled style="display: none;"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i> Tidak ada berkas yang diupload untuk diverifikasi.
                        </div>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Simpan Verifikasi
                </button>
            </form>
        </div>
    </div>
    @endif

<script>
function toggleRejectOptions() {
    const status = document.getElementById('status').value;
    const rejectOptions = document.getElementById('rejectOptions');
    
    if (status === 'ADM_REJECT') {
        rejectOptions.style.display = 'block';
        // Ensure note visibility matches checked boxes
        document.querySelectorAll('input[name="rejected_berkas[]"]').forEach(cb => {
            const id = cb.value;
            try { toggleBerkasNote(id); } catch(e) {}
        });
    } else {
        rejectOptions.style.display = 'none';
        // Uncheck all checkboxes
        document.querySelectorAll('input[name="rejected_berkas[]"]').forEach(cb => cb.checked = false);
        // Clear all textareas
        document.querySelectorAll('textarea[name^="berkas_catatan"]').forEach(ta => { ta.value = ''; ta.disabled = true; ta.style.display = 'none'; });
    }
}

function toggleBerkasNote(id) {
    const cb = document.getElementById('reject_' + id);
    const ta = document.getElementById('note_' + id);
    if (!cb || !ta) return;

    if (cb.checked) {
        ta.style.display = 'block';
        ta.disabled = false;
        // focus the note to encourage input (optional)
        // ta.focus();
    } else {
        ta.style.display = 'none';
        ta.disabled = true;
        ta.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize per-berkas note visibility based on checkbox state
    document.querySelectorAll('input[name="rejected_berkas[]"]').forEach(cb => {
        const id = cb.value;
        // Attach change handler in case blade rendering didn't add onchange attributes
        cb.addEventListener('change', function() { toggleBerkasNote(id); });
        // Set initial visibility
        try { toggleBerkasNote(id); } catch(e) {}
    });
});
</script>

</div>
@endsection