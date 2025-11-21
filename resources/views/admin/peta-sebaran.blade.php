@extends('admin.layouts.main')

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    <style>
        #map {
            height: 600px;
            width: 100%;
            border-radius: 8px;
        }

        .map-container {
            position: relative;
        }

        .map-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-width: 250px;
        }

        .map-legend {
            position: absolute;
            bottom: 10px;
            left: 10px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-width: 200px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .stats-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cluster-marker {
            background: #007bff;
            color: white;
            border-radius: 50%;
            text-align: center;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peta Sebaran Pendaftar</h1>
    </div>

    <!-- Statistics Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Pendaftar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPendaftar }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                Dengan Koordinat</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="total-with-coordinates">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                                Kabupaten Terbanyak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if($pendaftarPerKabupaten->count() > 0)
                                    {{ $pendaftarPerKabupaten->first()->kabupaten }}
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map fa-2x text-gray-300"></i>
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
                                Total Kabupaten</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendaftarPerKabupaten->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-globe fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Peta Sebaran Geografis Pendaftar</h6>
        </div>
        <div class="card-body">
            <div class="map-container">
                <!-- Map Controls -->
                <div class="map-controls">
                    <h6 class="font-weight-bold mb-3">Filter Peta</h6>
                    <div class="form-group">
                        <label for="filterJurusan" class="small font-weight-bold">Jurusan</label>
                        <select class="form-control form-control-sm" id="filterJurusan">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusanList as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterStatus" class="small font-weight-bold">Status</label>
                        <select class="form-control form-control-sm" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="SUBMIT">Submit</option>
                            <option value="ADM_PASS">Lolos Administrasi</option>
                            <option value="PAID">Sudah Bayar</option>
                            <option value="LULUS">Lulus</option>
                            <option value="CADANGAN">Cadangan</option>
                        </select>
                    </div>
                    <button id="applyFilter" class="btn btn-primary btn-sm btn-block">
                        <i class="fas fa-filter"></i> Terapkan Filter
                    </button>
                    <button id="resetFilter" class="btn btn-secondary btn-sm btn-block mt-1">
                        <i class="fas fa-sync"></i> Reset
                    </button>
                </div>

                <!-- Map Legend -->
                <div class="map-legend">
                    <h6 class="font-weight-bold mb-2">Keterangan Status</h6>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #ffc107;"></div>
                        <span class="small">Submit</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #17a2b8;"></div>
                        <span class="small">Lolos Administrasi</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #007bff;"></div>
                        <span class="small">Sudah Bayar</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #28a745;"></div>
                        <span class="small">Lulus</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background-color: #fd7e14;"></div>
                        <span class="small">Cadangan</span>
                    </div>
                </div>

                <!-- Map -->
                <div id="map"></div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Pendaftar Berdasarkan Wilayah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kabupaten</th>
                            <th>Jumlah Pendaftar</th>
                            <th>Persentase</th>
                            <th>Jurusan Terpopuler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftarPerKabupaten as $kabupaten)
                            <tr>
                                <td>{{ $kabupaten->kabupaten }}</td>
                                <td>{{ $kabupaten->total }}</td>
                                <td>
                                    @php
                                        $percentage = $totalPendaftar > 0 ? ($kabupaten->total / $totalPendaftar) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentage, 1) }}%
                                </td>
                                <td>
                                    @php
                                        $popularJurusan = $popularJurusanPerKabupaten[$kabupaten->kabupaten] ?? null;
                                    @endphp
                                    {{ $popularJurusan['nama'] ?? 'N/A' }} ({{ $popularJurusan['total'] ?? 0 }})
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    <script>
        let map;
        let markersCluster;
        let allMarkers = [];

        // Initialize map
        function initMap() {
            // Debug log removed: Initializing map

            // Default center to Indonesia
            map = L.map('map').setView([-2.5489, 118.0149], 5);

            // Add tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Initialize marker cluster
            markersCluster = L.markerClusterGroup({
                chunkedLoading: true,
                maxClusterRadius: 50,
                spiderfyOnMaxZoom: true,
                showCoverageOnHover: true,
                zoomToBoundsOnClick: true
            });

            map.addLayer(markersCluster);

            // Load initial data
            loadMapData();
        }

        // Load map data with filters
        function loadMapData(filters = {}) {
            // Debug log removed: Loading map data with filters
            showLoading();

            fetch(`{{ route('admin.peta.sebaran.data') }}?${new URLSearchParams(filters)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Debug log removed: Data received from server
                    updateMapMarkers(data);
                    updateStatistics(data);
                    hideLoading();
                })
                .catch(error => {
                    console.error('Error loading map data:', error);
                    alert('Error loading map data: ' + error.message);
                    hideLoading();
                });
        }

        // Update markers on map
        // Update markers on map
        function updateMapMarkers(data) {
            console.log('Updating markers with data count:', data.length);

            // Clear existing markers
            markersCluster.clearLayers();
            allMarkers = [];

            if (data.length === 0) {
                console.log('No data to display');
                // Show message or default marker
                const defaultMarker = L.marker([-6.9175, 107.6191]) // Jawa Barat center
                    .bindPopup(`
                    <div class="popup-content">
                        <h6><strong>Tidak Ada Data</strong></h6>
                        <hr>
                        <p>Tidak ada data pendaftar yang sesuai dengan filter yang dipilih.</p>
                    </div>
                `)
                    .addTo(map);
                return;
            }

            data.forEach((item, index) => {
                console.log(`Processing marker ${index + 1}:`, item.nama, 'at', item.lat, item.lng);

                const marker = L.marker([item.lat, item.lng])
                    .bindPopup(`
                    <div class="popup-content">
                        <h6><strong>${item.nama}</strong></h6>
                        <hr>
                        <p class="mb-1"><strong>No. Pendaftaran:</strong> ${item.no_pendaftaran}</p>
                        <p class="mb-1"><strong>Jurusan:</strong> ${item.jurusan}</p>
                        <p class="mb-1"><strong>Status:</strong> <span class="badge badge-${getStatusClass(item.status)}">${getStatusText(item.status)}</span></p>
                        <p class="mb-1"><strong>Wilayah:</strong> ${item.kelurahan}, ${item.kecamatan}</p>
                        <p class="mb-1"><strong>Kabupaten:</strong> ${item.kabupaten}</p>
                        <p class="mb-1"><strong>Provinsi:</strong> ${item.provinsi}</p>
                        <p class="mb-0"><strong>Alamat:</strong> ${item.alamat}</p>
                        <p class="mt-1 text-info"><small><i class="fas fa-map-marker-alt"></i> Koordinat berdasarkan wilayah ${item.kabupaten}</small></p>
                    </div>
                `);

                // Custom icon based on status dengan tooltip
                const icon = L.divIcon({
                    className: 'custom-marker',
                    html: `
                    <div style="
                        background-color: ${item.color}; 
                        width: 24px; 
                        height: 24px; 
                        border-radius: 50%; 
                        border: 3px solid white; 
                        box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                        position: relative;
                    " 
                    title="${item.nama} - ${item.jurusan}">
                    </div>
                `,
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                marker.setIcon(icon);

                // Tambahkan tooltip
                marker.bindTooltip(`
                <strong>${item.nama}</strong><br>
                ${item.jurusan} - ${getStatusText(item.status)}<br>
                <small>${item.kabupaten}</small>
            `, {
                    permanent: false,
                    direction: 'top',
                    offset: [0, -12]
                });

                markersCluster.addLayer(marker);
                allMarkers.push(marker);

                console.log(`Marker added at ${item.lat}, ${item.lng} for ${item.nama}`);
            });

            // Fit map to show all markers
            if (data.length > 0) {
                const group = new L.featureGroup(allMarkers);
                map.fitBounds(group.getBounds(), { padding: [50, 50] });
                console.log('Map fitted to bounds of all markers');

                // Jika hanya ada 1 marker, zoom lebih dekat
                if (data.length === 1) {
                    map.setZoom(12);
                }
            }
        }

        // Helper function untuk teks status yang lebih readable
        function getStatusText(status) {
            const statusText = {
                'DRAFT': 'Draft',
                'SUBMIT': 'Telah Submit',
                'ADM_PASS': 'Lolos Administrasi',
                'ADM_REJECT': 'Ditolak Administrasi',
                'PAID': 'Sudah Bayar',
                'LULUS': 'Lulus',
                'TIDAK_LULUS': 'Tidak Lulus',
                'CADANGAN': 'Cadangan'
            };
            return statusText[status] || status;
        }

        // Update statistics
        function updateStatistics(data) {
            // Debug log removed: Updating statistics with data count
            document.getElementById('total-with-coordinates').textContent = data.length;
        }

        // Get Bootstrap class for status
        function getStatusClass(status) {
            const classes = {
                'DRAFT': 'secondary',
                'SUBMIT': 'warning',
                'ADM_PASS': 'info',
                'ADM_REJECT': 'danger',
                'PAID': 'primary',
                'LULUS': 'success',
                'TIDAK_LULUS': 'danger',
                'CADANGAN': 'warning'
            };
            return classes[status] || 'secondary';
        }

        // Show loading indicator
        function showLoading() {
            // Add loading spinner to map
            const loadingControl = L.Control.extend({
                options: { position: 'topleft' },
                onAdd: function (map) {
                    const container = L.DomUtil.create('div', 'leaflet-control-loading');
                    container.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';
                    return container;
                }
            });
            map.addControl(new loadingControl());
        }

        // Hide loading indicator
        function hideLoading() {
            // Remove loading spinner
            document.querySelector('.leaflet-control-loading')?.remove();
        }

        // Event listeners
        document.addEventListener('DOMContentLoaded', function () {
            // Debug log removed: DOM loaded, initializing map

            // Check if Leaflet is loaded
            if (typeof L === 'undefined') {
                console.error('Leaflet library not loaded!');
                alert('Error: Leaflet library not loaded. Please check internet connection.');
                return;
            }

            initMap();

            // Filter apply
            document.getElementById('applyFilter').addEventListener('click', function () {
                const filters = {
                    jurusan_id: document.getElementById('filterJurusan').value,
                    status: document.getElementById('filterStatus').value
                };
                // Debug log removed: Applying filters
                loadMapData(filters);
            });

            // Filter reset
            document.getElementById('resetFilter').addEventListener('click', function () {
                document.getElementById('filterJurusan').value = '';
                document.getElementById('filterStatus').value = '';
                // Debug log removed: Resetting filters
                loadMapData();
            });

            // Initialize DataTable
            if ($.fn.DataTable) {
                $('#dataTable').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "order": [[1, 'desc']],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                    }
                });
            } else {
                console.error('DataTables not loaded!');
            }
        });

        // Add CSS for loading spinner
        const style = document.createElement('style');
        style.textContent = `
        .leaflet-control-loading {
            background: white;
            padding: 5px;
            border-radius: 4px;
            box-shadow: 0 1px 5px rgba(0,0,0,0.4);
        }
    `;
        document.head.appendChild(style);
    </script>
@endsection