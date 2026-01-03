<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Detail Petani: {{ $farmer->full_name }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

    <style>
        #map { height: 400px; width: 100%; border-radius: 0.5rem; z-index: 1; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-bold mb-4">Informasi Pribadi</h3>
                            <p><strong>Nama Lengkap:</strong> {{ $farmer->full_name }}</p>
                            <p><strong>NIK:</strong> {{ $farmer->nik }}</p>
                            <p><strong>Luas Lahan:</strong> {{ $farmer->land_area_ha }} Ha</p>
                            <p><strong>Kapasitas Max:</strong> {{ number_format($farmer->yield_capacity_limit, 2) }} Ton</p>
                            <p class="mt-2">
                                <strong>Status:</strong> 
                                <span class="px-2 py-1 text-xs rounded 
                                    {{ $farmer->status === 'active' ? 'bg-green-100 text-green-800' : 
                                      ($farmer->status === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($farmer->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold mb-4">Lokasi Kebun (Polygon)</h3>
                            <div id="map"></div>
                        </div>
</div> <hr class="my-8 border-gray-200">

                    <div class="mt-6">
                        <h3 class="text-lg font-bold mb-4">Input Setoran Baru (TBS)</h3>
                        
                        <form action="{{ route('deliveries.store', $farmer) }}" method="POST" class="max-w-xl">
                            @csrf <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Tanggal Setor</label>
                                    <input type="date" name="delivery_date" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Berat Buah (Kg)</label>
                                    <input type="number" name="weight_kg" placeholder="Contoh: 1500" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label class="block font-medium text-sm text-gray-700">Persentase Buah Busuk (%)</label>
                                    <input type="number" step="0.01" name="bad_fruit_percentage" placeholder="0 - 100" required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 text-sm font-medium">
                                    Simpan Transaksi
                                </button>
                            </div>
                        </form>

                        @if (session('status'))
                            <div class="mt-4 p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                <span class="font-medium">Info:</span> {{ session('status') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

    <script>
        const centerLat = {{ $farmer->farmLocation->center_lat ?? 0 }};
        const centerLng = {{ $farmer->farmLocation->center_long ?? 0 }};
        const polygonData = @json($farmer->farmLocation->boundary_coordinates ?? []);

        // LEAFLET LOGIC
        var map = L.map('map').setView([centerLat, centerLng], 13);

        // Pasang "Ubin" (Tiles) dari OpenStreetMap
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Tambahkan Marker di titik tengah
        L.marker([centerLat, centerLng]).addTo(map)
            .bindPopup("<b>Titik Pusat Kebun</b><br>{{ $farmer->full_name }}").openPopup();

        // Gambar Polygon (Area Kebun)
        // Leaflet butuh format [[lat, lng], [lat, lng]], tapi data kita [{lat:.., lng:..}]
        if (polygonData.length > 0) {
            var latlngs = polygonData.map(function(point) {
                return [point.lat, point.lng];
            });

            var polygon = L.polygon(latlngs, {
                color: 'red',       // Garis merah
                fillColor: '#f03',  // Isi merah
                fillOpacity: 0.5    // Transparan
            }).addTo(map);

            // Auto zoom
            map.fitBounds(polygon.getBounds());
        }
    </script>
</x-app-layout>