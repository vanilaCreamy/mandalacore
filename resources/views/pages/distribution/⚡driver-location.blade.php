<?php

use Livewire\Component;
use App\Models\DriverLocation;

new class extends Component
{
    public $breadcrumbs;
    public $driver_location;

    public function mount()
    {
        $this->driver_location = DriverLocation::all();

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => 'dashboard'],
            ['label' => 'Distribusi', 'distribution.index'],
            ['label' => 'Lokasi Driver']
        ];
    }

    public function loadLocations()
    {
        $locations = DriverLocation::with('driver')
            ->select('driver_id')
            ->selectRaw('MAX(id) as id')
            ->groupBy('driver_id')
            ->get()
            ->map(function ($row) {
                $loc = DriverLocation::with('driver')->find($row->id);

                return [
                    'driver_id' => $loc->driver_id,
                    'name' => $loc->driver->name ?? 'Driver',
                    'latitude' => $loc->latitude,
                    'longitude' => $loc->longitude,
                    'updated_at' => $loc->created_at->toDateTimeString(),
                ];
            });

        $this->dispatch('updateMap', drivers: $locations);
    }

};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Lokasi Driver" subtitle="Monitoring lokasi driver berada" separator>
        <x-slot:actions>
            <x-button link="{{ route('distribution.index') }}" icon="o-arrow-left" label="Kembali" class="btn-dash" />
        </x-slot:actions>
    </x-header>

    <div wire:init="loadLocations" wire:poll.10s="loadLocations">
        <div id="map" style="height:500px;" wire:ignore></div>
    </div>
</div>

<script>
    const map = L.map('map').setView([-7.3, 106.8], 12);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png')
        .addTo(map);

    const cluster = L.markerClusterGroup();
    map.addLayer(cluster);

    const markers = {};
    const routes  = {};   // polyline per driver
    const history = {};   // simpan titik terakhir di memory

    const MAX_POINTS = 30; // batas jejak biar ringan

    const activeIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/743/743922.png',
        iconSize: [35,35],
        iconAnchor: [17,35]
    });

    const offlineIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/1828/1828843.png',
        iconSize: [35,35],
        iconAnchor: [17,35]
    });

    function secondsAgo(time) {
        return (new Date() - new Date(time)) / 1000;
    }

    window.addEventListener('updateMap', (event) => {
        const drivers = event.detail.drivers;

        drivers.forEach(driver => {
            if (!driver.latitude || !driver.longitude) return;

            const latlng = [driver.latitude, driver.longitude];
            const isActive = secondsAgo(driver.updated_at) < 30;
            const icon = isActive ? activeIcon : offlineIcon;

            // === MARKER ===
            if (!markers[driver.driver_id]) {
                const marker = L.marker(latlng, { icon })
                    .bindTooltip(driver.name)
                    .bindPopup(`
                        <b>${driver.name}</b><br>
                        Update: ${driver.updated_at}
                    `);

                markers[driver.driver_id] = marker;
                cluster.addLayer(marker);

                history[driver.driver_id] = [latlng];

                routes[driver.driver_id] = L.polyline(history[driver.driver_id], {
                    weight: 4,
                    opacity: 0.7
                }).addTo(map);

            } else {
                markers[driver.driver_id]
                    .setLatLng(latlng)
                    .setIcon(icon);

                // === ROUTE HISTORY ===
                history[driver.driver_id].push(latlng);

                if (history[driver.driver_id].length > MAX_POINTS) {
                    history[driver.driver_id].shift();
                }

                routes[driver.driver_id].setLatLngs(history[driver.driver_id]);
            }
        });
    });
</script>

    