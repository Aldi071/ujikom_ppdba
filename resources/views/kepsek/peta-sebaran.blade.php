@extends('kepsek.layouts.admin')

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peta Sebaran Domisili Pendaftar</h1>
        <div>
            <button id="reset-map" class="btn btn-secondary btn-sm">
                <i class="fas fa-sync-alt"></i> Reset Peta
            </button>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Data Koordinat
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDataPeta }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Cakupan Data
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $persentaseDataPeta }}%</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Cluster Titik
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $clusterData->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pendaftar
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendaftar }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Filter Data Peta</h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('kepsek.peta-sebaran') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="jurusan_id">Filter Berdasarkan Jurusan</label>
                            <select class="form-control" id="jurusan_id" name="jurusan_id">
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}" {{ $jurusan_id == $jurusan->id ? 'selected' : '' }}>
                                    {{ $jurusan->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="status">Filter Berdasarkan Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="LULUS" {{ $status == 'LULUS' ? 'selected' : '' }}>Lulus</option>
                                <option value="TIDAK_LULUS" {{ $status == 'TIDAK_LULUS' ? 'selected' : '' }}>Tidak Lulus</option>
                                <option value="CADANGAN" {{ $status == 'CADANGAN' ? 'selected' : '' }}>Cadangan</option>
                                <option value="PAID" {{ $status == 'PAID' ? 'selected' : '' }}>Sudah Bayar</option>
                                <option value="ADM_PASS" {{ $status == 'ADM_PASS' ? 'selected' : '' }}>Lulus Administrasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Terapkan Filter
                                </button>
                                <a href="{{ route('kepsek.peta-sebaran') }}" class="btn btn-secondary">
                                    <i class="fas fa-sync"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Peta Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Peta Sebaran Domisili Pendaftar</h6>
            <div class="btn-group">
                <button id="toggle-cluster" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-layer-group"></i> Mode Cluster
                </button>
                <button id="toggle-heatmap" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-fire"></i> Mode Heatmap
                </button>
            </div>
        </div>
        <div class="card-body">
            @if($dataPeta->count() > 0)
            <div class="row">
                <div class="col-12">
                    <!-- Container untuk peta dengan overflow hidden -->
                    <div class="map-wrapper" style="position: relative; overflow: hidden; border-radius: 5px; border: 1px solid #ddd;">
                        <div id="map-container"></div>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-3 pt-3 border-top">
                <div class="row">
                    <div class="col-md-12">
                        <h6 class="mb-2">Keterangan Marker:</h6>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-primary mr-2">●</span>
                                <small>Lulus Administrasi</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-success mr-2">●</span>
                                <small>Sudah Bayar</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-warning mr-2">●</span>
                                <small>Lulus Seleksi</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-danger mr-2">●</span>
                                <small>Tidak Lulus</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-map-marked-alt fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Data Peta Tidak Tersedia</h4>
                <p class="text-muted">Tidak ada data koordinat yang dapat ditampilkan pada peta.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Data Table Section -->
    @if($dataPeta->count() > 0)
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar dengan Koordinat</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Asal Sekolah</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th>Koordinat</th>
                            <th>Wilayah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataPeta as $key => $data)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $data->nama ?? '-' }}</td>
                            <td>{{ $data->pendaftar->asalSekolah->nama_sekolah ?? '-' }}</td>
                            <td>
                                <span class="badge badge-info">{{ $data->pendaftar->jurusan->nama ?? '-' }}</span>
                            </td>
                            <td>
                                @if($data->pendaftar->status == 'LULUS')
                                <span class="badge badge-success">LULUS</span>
                                @elseif($data->pendaftar->status == 'TIDAK_LULUS')
                                <span class="badge badge-danger">TIDAK LULUS</span>
                                @elseif($data->pendaftar->status == 'CADANGAN')
                                <span class="badge badge-warning">CADANGAN</span>
                                @elseif($data->pendaftar->status == 'PAID')
                                <span class="badge badge-primary">SUDAH BAYAR</span>
                                @elseif($data->pendaftar->status == 'ADM_PASS')
                                <span class="badge badge-info">LULUS ADMINISTRASI</span>
                                @else
                                <span class="badge badge-secondary">{{ $data->pendaftar->status }}</span>
                                @endif
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $data->lat }}, {{ $data->lng }}
                                </small>
                            </td>
                            <td>{{ $data->wilayah->kabupaten ?? '-' }}, {{ $data->wilayah->kecamatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<!-- Leaflet Marker Cluster CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />

<style>
    /* Container utama untuk peta */
    .map-wrapper {
        height: 600px;
        background: #f8f9fa;
    }

    /* Container peta Leaflet */
    #map-container {
        height: 100%;
        width: 100%;
        position: relative;
        z-index: 1;
    }

    /* Pastikan Leaflet container tidak memiliki margin/padding */
    .leaflet-container {
        height: 100%;
        width: 100%;
        position: relative !important;
        z-index: 1;
        background: #f8f9fa;
    }

    /* Fix untuk marker cluster */
    .marker-cluster-small {
        background-color: rgba(181, 226, 140, 0.6);
    }

    .marker-cluster-small div {
        background-color: rgba(110, 204, 57, 0.6);
    }

    .marker-cluster-medium {
        background-color: rgba(241, 211, 87, 0.6);
    }

    .marker-cluster-medium div {
        background-color: rgba(240, 194, 12, 0.6);
    }

    .marker-cluster-large {
        background-color: rgba(253, 156, 115, 0.6);
    }

    .marker-cluster-large div {
        background-color: rgba(241, 128, 23, 0.6);
    }

    /* Custom marker styles */
    .custom-marker {
        background: transparent !important;
        border: none !important;
    }

    /* Leaflet popup styling */
    .leaflet-popup-content-wrapper {
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .leaflet-popup-content {
        margin: 12px 15px;
        line-height: 1.4;
    }

    /* Responsive design untuk mobile */
    @media (max-width: 768px) {
        .map-wrapper {
            height: 400px;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<!-- Leaflet Marker Cluster -->
<script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Debug log removed: DOM loaded, initializing map

        @if($dataPeta->count() > 0)
        initializeMap();
        @else
        // Debug log removed: No map data available
        @endif

        function initializeMap() {
            try {
                // Pastikan container ada
                const mapContainer = document.getElementById('map-container');
                if (!mapContainer) {
                    console.error('Map container not found');
                    return;
                }

                // Clear any existing map
                if (mapContainer._leaflet_map) {
                    mapContainer._leaflet_map.remove();
                }

                // Debug log removed: Initializing Leaflet map

                // Default center ke Indonesia dengan bounds yang reasonable
                const map = L.map('map-container', {
                    zoomControl: true,
                    scrollWheelZoom: true
                }).setView([-6.2088, 106.8456], 5); // Jakarta sebagai center

                // Simpan reference ke map
                mapContainer._leaflet_map = map;

                // Tambahkan tile layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                    maxZoom: 18
                }).addTo(map);

                // Marker cluster group dengan konfigurasi yang lebih baik
                const markers = L.markerClusterGroup({
                    chunkedLoading: true,
                    maxClusterRadius: 50,
                    spiderfyOnMaxZoom: true,
                    showCoverageOnHover: true,
                    zoomToBoundsOnClick: true
                });

                // Data untuk peta - gunakan pendekatan yang lebih aman
                const mapData = [
                    @foreach($dataPeta as $item)
                    @if($item->lat && $item->lng)
                    {
                        lat: {{ $item->lat }},
                        lng: {{ $item->lng }},
                        nama: `{{ $item->nama ?? 'Tidak ada nama' }}`,
                        sekolah: `{{ $item->pendaftar->asalSekolah->nama_sekolah ?? '-' }}`,
                        jurusan: `{{ $item->pendaftar->jurusan->nama ?? '-' }}`,
                        status: `{{ $item->pendaftar->status ?? 'UNKNOWN' }}`,
                        no_pendaftaran: `{{ $item->pendaftar->no_pendaftaran ?? '-' }}`,
                        wilayah: `{{ $item->wilayah ? $item->wilayah->kabupaten . ', ' . $item->wilayah->kecamatan : '-' }}`
                    },
                    @endif
                    @endforeach
                ];

                // Debug log removed: Map data loaded

                // Tambahkan markers ke cluster
                let validMarkersCount = 0;
                mapData.forEach(function(data) {
                    try {
                        // Validasi koordinat
                        if (!data.lat || !data.lng || isNaN(data.lat) || isNaN(data.lng)) {
                            console.warn('Invalid coordinates:', data);
                            return;
                        }

                        // Pastikan koordinat dalam range yang reasonable untuk Indonesia
                        if (data.lat < -11 || data.lat > 6 || data.lng < 95 || data.lng > 141) {
                            console.warn('Coordinates out of Indonesia bounds:', data);
                            return;
                        }

                        // Tentukan warna marker berdasarkan status
                        let markerColor = 'gray';
                        let statusText = 'Tidak Diketahui';

                        switch (data.status) {
                            case 'ADM_PASS':
                                markerColor = 'blue';
                                statusText = 'Lulus Administrasi';
                                break;
                            case 'PAID':
                                markerColor = 'green';
                                statusText = 'Sudah Bayar';
                                break;
                            case 'LULUS':
                                markerColor = 'orange';
                                statusText = 'Lulus Seleksi';
                                break;
                            case 'TIDAK_LULUS':
                                markerColor = 'red';
                                statusText = 'Tidak Lulus';
                                break;
                            default:
                                markerColor = 'gray';
                                statusText = data.status;
                        }

                        // Buat custom icon yang lebih sederhana
                        const customIcon = L.divIcon({
                            className: 'custom-marker',
                            html: `<div style="
                                background-color: ${markerColor}; 
                                width: 20px; 
                                height: 20px; 
                                border-radius: 50%; 
                                border: 3px solid white; 
                                box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                                cursor: pointer;
                            "></div>`,
                            iconSize: [26, 26],
                            iconAnchor: [13, 13]
                        });

                        // Buat marker
                        const marker = L.marker([data.lat, data.lng], {
                            icon: customIcon,
                            title: data.nama
                        }).bindPopup(`
                            <div style="min-width: 250px; font-family: Arial, sans-serif;">
                                <h6 style="margin: 0 0 8px 0; color: #2e59d9; border-bottom: 1px solid #eee; padding-bottom: 5px;">
                                    ${data.nama}
                                </h6>
                                <table style="width: 100%; font-size: 12px; border-collapse: collapse;">
                                    <tr>
                                        <td style="padding: 3px 0; color: #666;"><strong>No. Pendaftaran:</strong></td>
                                        <td style="padding: 3px 0;">${data.no_pendaftaran}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 3px 0; color: #666;"><strong>Asal Sekolah:</strong></td>
                                        <td style="padding: 3px 0;">${data.sekolah}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 3px 0; color: #666;"><strong>Jurusan:</strong></td>
                                        <td style="padding: 3px 0;">${data.jurusan}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 3px 0; color: #666;"><strong>Status:</strong></td>
                                        <td style="padding: 3px 0;">
                                            <span style="color: ${markerColor}; font-weight: bold;">${statusText}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 3px 0; color: #666;"><strong>Wilayah:</strong></td>
                                        <td style="padding: 3px 0;">${data.wilayah}</td>
                                    </tr>
                                </table>
                            </div>
                        `);

                        markers.addLayer(marker);
                        validMarkersCount++;

                    } catch (error) {
                        console.error('Error creating marker:', error, data);
                    }
                });

                // Tambahkan cluster markers ke peta
                map.addLayer(markers);
                // Debug log removed: Added markers

                // Fit bounds untuk menampilkan semua marker
                if (validMarkersCount > 0) {
                    setTimeout(() => {
                        try {
                            const bounds = markers.getBounds();
                            if (bounds.isValid()) {
                                map.fitBounds(bounds, {
                                    padding: [20, 20],
                                    maxZoom: 12
                                });
                            } else {
                                // Fallback bounds untuk Indonesia
                                map.fitBounds([
                                    [-11.0, 95.0], // Southwest bounds
                                    [6.0, 141.0] // Northeast bounds
                                ]);
                            }
                        } catch (e) {
                            console.warn('Could not fit bounds:', e);
                        }
                    }, 100);
                }

                // Tombol reset peta
                document.getElementById('reset-map').addEventListener('click', function() {
                    if (validMarkersCount > 0) {
                        const bounds = markers.getBounds();
                        if (bounds.isValid()) {
                            map.fitBounds(bounds, {
                                padding: [20, 20]
                            });
                        }
                    } else {
                        map.setView([-6.2088, 106.8456], 5);
                    }
                });

                // Handle window resize
                let resizeTimer;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        try {
                            if (map && typeof map.invalidateSize === 'function') {
                                map.invalidateSize(true);

                                // Re-fit bounds setelah resize
                                setTimeout(() => {
                                    if (validMarkersCount > 0) {
                                        const bounds = markers.getBounds();
                                        if (bounds.isValid()) {
                                            map.fitBounds(bounds, {
                                                padding: [20, 20],
                                                maxZoom: 12
                                            });
                                        }
                                    }
                                }, 150);
                            }
                        } catch (error) {
                            console.warn('Error during resize:', error);
                        }
                    }, 300);
                });

                // Force map to fit properly in container
                setTimeout(() => {
                    map.invalidateSize(true);

                    // Tambahkan bounds padding untuk memastikan peta tidak terlalu ketat
                    if (validMarkersCount > 0) {
                        const bounds = markers.getBounds();
                        if (bounds.isValid()) {
                            map.fitBounds(bounds, {
                                padding: [30, 30], // Increased padding
                                maxZoom: 12
                            });
                        }
                    }
                }, 100);

                // Debug log removed: Map initialization completed

            } catch (error) {
                console.error('Error initializing map:', error);
                // Tampilkan pesan error ke user
                const mapContainer = document.getElementById('map-container');
                if (mapContainer) {
                    mapContainer.innerHTML = `
                        <div class="alert alert-danger text-center">
                            <h5>Error Memuat Peta</h5>
                            <p>Terjadi kesalahan saat memuat peta. Silakan refresh halaman.</p>
                            <small>Error: ${error.message}</small>
                        </div>
                    `;
                }
            }
        }

        // Handler untuk toggle buttons (simplified)
        document.getElementById('toggle-cluster')?.addEventListener('click', function() {
            alert('Mode Cluster diaktifkan');
        });

        document.getElementById('toggle-heatmap')?.addEventListener('click', function() {
            alert('Mode Heatmap membutuhkan library tambahan. Fitur akan datang.');
        });
    });
</script>
@endpush