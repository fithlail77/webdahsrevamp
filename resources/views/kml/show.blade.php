@extends('layouts.admin')

@section('content')
<h1 class="h3 mb-2 text-gray-800">GPS Tracking</h1>
<h1 class="h5 mb-2 text-gray-800">Nama    : {{ $kmlFile->nama_asisten }} </h1>
<h1 class="h5 mb-2 text-gray-800">Estate  : {{ $kmlFile->estate }} </h1>
<h1 class="h5 mb-2 text-gray-800">Divisi  : {{ $kmlFile->divisi }} </h1>
<h1 class="h5 mb-2 text-gray-800">Tanggal : {{ $kmlFile->tanggal }} </h1>
<hr>
<div class="card shadow mb-4">
    <div id="map" style="height: 700px;"></div>
</div>
<div class="card shadow mb-4">
    <a href="{{ route('kml.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    var map = L.map('map', { maxZoom: 23 })
        .setView([-6.2, 106.816666], 10);

    // Base Layers
    var osmLayer = L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        { attribution: '© OpenStreetMap contributors' }
    );

    var satelliteLayer = L.tileLayer(
        'https://clarity.maptiles.arcgis.com/arcgis/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        {
            attribution: 'Tiles © Esri',
            maxZoom: 23,
            maxNativeZoom: 19
        }
    );

    satelliteLayer.addTo(map);

    L.control.layers({
        "Maps": osmLayer,
        "Satellite": satelliteLayer
    }).addTo(map);

    var coordinates = @json($coordinates);
    var startTime = @json($startTime);
    var endTime = @json($endTime);

    if (coordinates.length > 0) {

        var latlngs = coordinates.map(function(coord) {
            return [coord.lat, coord.lng];
        });

        function calculateDistance(latlngs) {

            function toRad(x) {
                return x * Math.PI / 180;
            }
        
            var total = 0;
        
            for (var i = 1; i < latlngs.length; i++) {
            
                var lat1 = latlngs[i - 1][0];
                var lon1 = latlngs[i - 1][1];
                var lat2 = latlngs[i][0];
                var lon2 = latlngs[i][1];
            
                var R = 6371; // km
                var dLat = toRad(lat2 - lat1);
                var dLon = toRad(lon2 - lon1);
            
                var a =
                    Math.sin(dLat/2) * Math.sin(dLat/2) +
                    Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
                    Math.sin(dLon/2) * Math.sin(dLon/2);
            
                var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
            
                total += R * c;
            }
        
            return total;
        }

        function calculateDuration(start, end) {

            if (!start || !end) return '-';

            var startDate = new Date(start);
            var endDate = new Date(end);

            var diffMs = endDate - startDate;

            var hours = Math.floor(diffMs / (1000 * 60 * 60));
            var minutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

            return hours + " jam " + minutes + " menit";
        }

        if (latlngs.length > 1) {

            var polyline = L.polyline(latlngs, {
                color: 'yellow',
                weight: 4,
                opacity: 0.8
            }).addTo(map);

            // Marker START (Hijau)
            var startMarker = L.circleMarker(latlngs[0], {
                radius: 8,
                color: 'green',
                fillColor: 'green',
                fillOpacity: 1
            }).addTo(map).bindPopup("START");

            // Marker END (Biru)
            var endMarker = L.circleMarker(latlngs[latlngs.length - 1], {
                radius: 8,
                color: 'red',
                fillColor: 'red',
                fillOpacity: 1
            }).addTo(map).bindPopup("END");

            var totalDistance = calculateDistance(latlngs).toFixed(2);

            var totalDuration = calculateDuration(startTime, endTime);

            polyline.bindTooltip(
                `<div style="font-size:13px">
                    <strong>Informasi Tracking</strong><br>
                    📍 Mulai: ${startTime ? startTime : '-'}<br>
                    🏁 Selesai: ${endTime ? endTime : '-'}<br>
                    🟢 Jarak: ${totalDistance} km<br>
                    🟣 Durasi: ${totalDuration}
                 </div>`,
                { sticky: true }
            );

            map.fitBounds(polyline.getBounds());
        }
    }

});
</script>
@endpush