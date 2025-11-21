@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1>Peta Sebaran Pendaftar</h1>
    <div id="map" style="height: 600px; width: 100%;"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<script>
const map = L.map('map').setView([-6.9175, 107.6191], 10);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

fetch('/admin/map/data')
    .then(response => response.json())
    .then(data => {
        data.forEach(siswa => {
            L.marker([siswa.lat, siswa.lng])
                .addTo(map)
                .bindPopup(`
                    <b>${siswa.nama}</b><br>
                    Jurusan: ${siswa.jurusan}<br>
                    Alamat: ${siswa.alamat}<br>
                    Wilayah: ${siswa.wilayah}
                `);
        });
    });
</script>
@endpush