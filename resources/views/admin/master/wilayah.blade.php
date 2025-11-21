{{-- resources/views/admin/master/wilayah.blade.php --}}
@extends('admin.layouts.main')

@section('styles')
<style>
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
    .dropdown-item:hover {
        background-color: #f8f9fc;
    }
    .dropdown-item i {
        width: 16px;
        margin-right: 8px;
    }
    .dropdown-item.text-danger:hover {
        background-color: #f5c6cb;
        color: #721c24 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Master Data Wilayah</h1>
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

    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <!-- Form Tambah Wilayah -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tambah Wilayah Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.master.wilayah.store') }}" method="POST" id="wilayahForm">
                        @csrf
                        <div class="form-group">
                            <label for="provinsi">Provinsi *</label>
                            <select class="form-control @error('provinsi') is-invalid @enderror" 
                                    id="provinsi" name="provinsi" required>
                                <option value="">Pilih Provinsi</option>
                                @foreach($provinsiList as $provinsi)
                                    <option value="{{ $provinsi }}" {{ old('provinsi') == $provinsi ? 'selected' : '' }}>
                                        {{ $provinsi }}
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
                                <!-- Data akan diisi via AJAX -->
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
                                <!-- Data akan diisi via AJAX -->
                            </select>
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan/Desa *</label>
                            <input type="text" class="form-control @error('kelurahan') is-invalid @enderror" 
                                   id="kelurahan" name="kelurahan" 
                                   value="{{ old('kelurahan') }}" 
                                   required maxlength="100" placeholder="Nama kelurahan/desa">
                            @error('kelurahan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kodepos">Kode Pos *</label>
                            <input type="text" class="form-control @error('kodepos') is-invalid @enderror" 
                                   id="kodepos" name="kodepos" 
                                   value="{{ old('kodepos') }}" 
                                   required maxlength="10" placeholder="Contoh: 12345">
                            @error('kodepos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary" id="resetForm">Reset</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Data Table Wilayah -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Wilayah</h6>
                    <span class="badge badge-primary">{{ $wilayah->total() }} Data</span>
                </div>
                <div class="card-body">
                    @if($wilayah->total() == 0)
                        <div class="text-center py-4">
                            <i class="fas fa-map-marker-alt fa-3x text-gray-300 mb-3"></i>
                            <h5 class="text-gray-800">Belum Ada Data Wilayah</h5>
                            <p class="text-muted">Silakan tambah data wilayah menggunakan form di sebelah kiri.</p>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#quickAddModal">
                                <i class="fas fa-plus"></i> Tambah Data Contoh
                            </button>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Provinsi</th>
                                        <th>Kabupaten/Kota</th>
                                        <th>Kecamatan</th>
                                        <th>Kelurahan/Desa</th>
                                        <th>Kode Pos</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wilayah as $item)
                                        <tr>
                                            <td>{{ ($wilayah->currentPage() - 1) * $wilayah->perPage() + $loop->iteration }}</td>
                                            <td>{{ $item->provinsi }}</td>
                                            <td>{{ $item->kabupaten }}</td>
                                            <td>{{ $item->kecamatan }}</td>
                                            <td>{{ $item->kelurahan }}</td>
                                            <td>{{ $item->kodepos }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button" 
                                                            data-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-cog"></i> Aksi
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('admin.master.wilayah.edit', $item->id) }}">
                                                            <i class="fas fa-edit text-warning"></i> Edit Wilayah
                                                        </a>
                                                        <div class="dropdown-divider"></div>
                                                        <form action="{{ route('admin.master.wilayah.destroy', $item->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger" 
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus wilayah ini?')">
                                                                <i class="fas fa-trash"></i> Hapus Wilayah
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            {{ $wilayah->links('custom.pagination') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Quick Add Modal -->
<div class="modal fade" id="quickAddModal" tabindex="-1" role="dialog" aria-labelledby="quickAddModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickAddModalLabel">Tambah Data Wilayah Contoh</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Tambahkan data wilayah contoh untuk mengisi database?</p>
                <div class="alert alert-info">
                    <small><i class="fas fa-info-circle"></i> Data contoh akan membantu menguji fungsi dropdown berantai.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('admin.master.wilayah.quick-add') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Ya, Tambah Data Contoh</button>
                </form>
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

        // CSRF Token untuk AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Load kabupaten berdasarkan provinsi
        function loadKabupaten(provinsi, selectedKabupaten = '') {
            if (!provinsi) {
                $('#kabupaten').html('<option value="">Pilih Kabupaten/Kota</option>');
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
                return;
            }

            // Debug log removed: Loading kabupaten for provinsi
            
            $.ajax({
                url: '{{ route("admin.master.wilayah.get-kabupaten") }}',
                type: 'GET',
                data: { 
                    provinsi: provinsi,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Debug log removed: Kabupaten response
                    
                    var kabupatenDropdown = $('#kabupaten');
                    kabupatenDropdown.html('<option value="">Pilih Kabupaten/Kota</option>');
                    
                    if (response && response.length > 0) {
                        $.each(response, function(index, kabupaten) {
                            var selected = (kabupaten == selectedKabupaten) ? 'selected' : '';
                            kabupatenDropdown.append('<option value="' + kabupaten + '" ' + selected + '>' + kabupaten + '</option>');
                        });
                    } else {
                        kabupatenDropdown.append('<option value="">Tidak ada data</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading kabupaten:', error);
                    $('#kabupaten').html('<option value="">Error loading data</option>');
                }
            });
        }

        // Load kecamatan berdasarkan kabupaten
        function loadKecamatan(kabupaten, selectedKecamatan = '') {
            if (!kabupaten) {
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
                return;
            }

            // Debug log removed: Loading kecamatan for kabupaten
            
            $.ajax({
                url: '{{ route("admin.master.wilayah.get-kecamatan") }}',
                type: 'GET',
                data: { 
                    kabupaten: kabupaten,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // Debug log removed: Kecamatan response
                    
                    var kecamatanDropdown = $('#kecamatan');
                    kecamatanDropdown.html('<option value="">Pilih Kecamatan</option>');
                    
                    if (response && response.length > 0) {
                        $.each(response, function(index, kecamatan) {
                            var selected = (kecamatan == selectedKecamatan) ? 'selected' : '';
                            kecamatanDropdown.append('<option value="' + kecamatan + '" ' + selected + '>' + kecamatan + '</option>');
                        });
                    } else {
                        kecamatanDropdown.append('<option value="">Tidak ada data</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading kecamatan:', error);
                    $('#kecamatan').html('<option value="">Error loading data</option>');
                }
            });
        }

        // Event handler untuk perubahan provinsi
        $('#provinsi').change(function() {
            var provinsi = $(this).val();
            // Debug log removed: Provinsi changed to
            loadKabupaten(provinsi);
            // Reset kecamatan ketika provinsi berubah
            $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
        });

        // Event handler untuk perubahan kabupaten
        $('#kabupaten').change(function() {
            var kabupaten = $(this).val();
            // Debug log removed: Kabupaten changed to
            loadKecamatan(kabupaten);
        });

        // Inisialisasi saat halaman dimuat
        function initializeDropdowns() {
            var oldProvinsi = "{{ old('provinsi') }}";
            var oldKabupaten = "{{ old('kabupaten') }}";
            var oldKecamatan = "{{ old('kecamatan') }}";
            
            // Debug log removed: Old values
            
            if (oldProvinsi) {
                // Set provinsi dan load kabupaten
                $('#provinsi').val(oldProvinsi);
                loadKabupaten(oldProvinsi, oldKabupaten);
                
                if (oldKabupaten) {
                    // Tunggu sebentar untuk memastikan kabupaten sudah diload
                    setTimeout(function() {
                        loadKecamatan(oldKabupaten, oldKecamatan);
                    }, 500);
                }
            }
        }

        // Panggil inisialisasi
        initializeDropdowns();

        // Reset form
        $('#resetForm').click(function() {
            setTimeout(function() {
                $('#kabupaten').html('<option value="">Pilih Kabupaten/Kota</option>');
                $('#kecamatan').html('<option value="">Pilih Kecamatan</option>');
            }, 100);
        });

        // Log perubahan wilayah
        $('#provinsi, #kabupaten, #kecamatan').on('change', function() {
            // Debug log removed: Dropdown changed
        });
    });
</script>
@endsection