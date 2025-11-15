{{-- resources/views/admin/master/wilayah-edit.blade.php --}}
@extends('admin.layouts.main')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Wilayah</h1>
        <a href="{{ route('admin.master.wilayah') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Wilayah</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.master.wilayah.update', $wilayah->id) }}" method="POST" id="editWilayahForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="provinsi">Provinsi *</label>
                            <select class="form-control @error('provinsi') is-invalid @enderror" 
                                    id="provinsi" name="provinsi" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinsiList as $provinsiItem)
                                    <option value="{{ $provinsiItem }}" {{ old('provinsi', $wilayah->provinsi) == $provinsiItem ? 'selected' : '' }}>
                                        {{ $provinsiItem }}
                                    </option>
                                @endforeach
                            </select>
                            @error('provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kabupaten">Kabupaten/Kota *</label>
                            <select class="form-control @error('kabupaten') is-invalid @enderror" 
                                    id="kabupaten" name="kabupaten" required>
                                <option value="">Pilih Kabupaten/Kota</option>
                                @foreach($kabupatenList as $kabupatenItem)
                                    <option value="{{ $kabupatenItem }}" {{ old('kabupaten', $wilayah->kabupaten) == $kabupatenItem ? 'selected' : '' }}>
                                        {{ $kabupatenItem }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kabupaten')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kecamatan">Kecamatan *</label>
                            <select class="form-control @error('kecamatan') is-invalid @enderror" 
                                    id="kecamatan" name="kecamatan" required>
                                <option value="">Pilih Kecamatan</option>
                                @foreach($kecamatanList as $kecamatanItem)
                                    <option value="{{ $kecamatanItem }}" {{ old('kecamatan', $wilayah->kecamatan) == $kecamatanItem ? 'selected' : '' }}>
                                        {{ $kecamatanItem }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan/Desa *</label>
                            <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" 
                                   id="kelurahan" name="kelurahan" 
                                   value="{{ old('kelurahan', $wilayah->kelurahan) }}" 
                                   required maxlength="100">
                            @error('kelurahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kodepos">Kode Pos *</label>
                            <input type="text" class="form-control @error('kodepos') is-invalid @enderror" 
                                   id="kodepos" name="kodepos" 
                                   value="{{ old('kodepos', $wilayah->kodepos) }}" 
                                   required maxlength="10">
                            @error('kodepos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.master.wilayah') }}" class="btn btn-secondary">Batal</a>
                    </form>
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

        // AJAX untuk dropdown berantai di form edit
        $('#provinsi').change(function() {
            var provinsi = $(this).val();
            
            if (provinsi) {
                $.ajax({
                    url: '{{ route("admin.master.wilayah.get-kabupaten") }}',
                    type: 'GET',
                    data: { provinsi: provinsi },
                    success: function(data) {
                        $('#kabupaten').html('<option value="">Pilih Kabupaten/Kota</option>');
                        $.each(data, function(key, value) {
                            $('#kabupaten').append('<option value="'+ value +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#kabupaten').html('<option value="">Pilih Kabupaten/Kota</option>');
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            }
        });

        $('#kabupaten').change(function() {
            var kabupaten = $(this).val();
            
            if (kabupaten) {
                $.ajax({
                    url: '{{ route("admin.master.wilayah.get-kecamatan") }}',
                    type: 'GET',
                    data: { kabupaten: kabupaten },
                    success: function(data) {
                        $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
                        $.each(data, function(key, value) {
                            $('#kecamatan').append('<option value="'+ value +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            }
        });
    });
</script>
@endsection