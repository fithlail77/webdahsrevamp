@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 600px;
        width: 100%;
        z-index: 1;
    }
    .info-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
    }
    .info-box h5 {
        margin-bottom: 15px;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h3 mb-0">Track: {{ $kmlFile->name }}</h2>
        <a href="{{ route('kml.index') }}" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="info-box">
                <h5>Informasi Track</h5>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Asisten:</strong> {{ $kmlFile->nama_asisten }}
                    </div>
                    <div class="col-md-4">
                        <strong>Estate:</strong> {{ $kmlFile->estate }}
                    </div>
                    <div class="col-md-4">
                        <strong>Divisi:</strong> {{ $kmlFile->divisi }}
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kmlFile->tanggal)->format('d-m-Y') }}
                    </div>
                    <div class="col-md-4">
                        <strong>Waktu Mulai:</strong> {{ $startTime ?? '-' }}
                    </div>
                    <div class="col-md-4">
                        <strong>Waktu Selesai:</strong> {{ $endTime ?? '-' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <div id="map"></div>
        </div>
    </div>
    
    <div class="mt-3">
        <strong>Jumlah Titik:</strong> {{ count($coordinates) ?? 0 }}
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = null;
    var trackLayer = null;
    var markerStart = null;
    var markerEnd = null;
    
    // Koordinat dari controller
    var coordinates = @json($coordinates);
    
    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
    
    function initMap() {
        // Create map
        map = L.map('map').setView([0, 0], 13);
        
        // Add tile layer (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        if (coordinates && coordinates.length > 0) {
            var latLngs = [];
            
            // Create polyline from coordinates
            for (var i = 0; i < coordinates.length; i++) {
                latLngs.push([coordinates[i].lat, coordinates[i].lng]);
            }
            
            // Draw polyline
            trackLayer = L.polyline(latLngs, {
                color: 'blue',
                weight: 3,
                opacity: 0.7
            }).addTo(map);
            
            // Add start marker (green)
            markerStart = L.marker([coordinates[0].lat, coordinates[0].lng], {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41]
                })
            }).addTo(map).bindPopup('Titik Awal');
            
            // Add end marker (red)
            var lastCoord = coordinates[coordinates.length - 1];
            markerEnd = L.marker([lastCoord.lat, lastCoord.lng], {
                icon: L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-red.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41]
                })
            }).addTo(map).bindPopup('Titik Akhir');
            
            // Fit map to track bounds
            map.fitBounds(trackLayer.getBounds(), { padding: [50, 50] });
            
            // Invalidate map size
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        } else {
            alert('Tidak ada koordinat ditemukan dalam file KML');
        }
    }
</script>
@endpush
