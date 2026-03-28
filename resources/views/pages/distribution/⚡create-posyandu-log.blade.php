<?php

use Livewire\Component;
use App\enum\DriverCategory;
use App\enum\DriverFlow;
use App\Models\PosyanduDelivery;
use App\Models\Posyandu;
use App\Models\DriverLocation;
use App\Models\DistributionRoute;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;

    public $logs = [];

    public $posyandus = [];
    public $distribution_route = [];
    public $selected_route;

    public $category;
    public $flow;
    public $driver_id;

    public $posyandu_id;
    public $address;
    public $amount_bumil;
    public $amount_busui;
    public $amount_balita;

    public $latitude = null;
    public $longitude = null;

    public function mount()
    {
        $this->driver_id = Auth::id();

        $this->distribution_route = DistributionRoute::where('is_active', true)
            ->select('id', 'route_name')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'name' => $r->route_name,
            ])->toArray();

        $this->loadLogs();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Distribusi', 'link' => route('distribution.index')],
            ['label' => 'Log Pengiriman Posyandu'],
        ];
    }

    private function latestLog()
    {
        return PosyanduDelivery::where('driver_id', $this->driver_id)
            ->latest()
            ->first();
    }

    public function loadLogs()
    {
        $this->logs = PosyanduDelivery::with('posyandu')
            ->where('driver_id', $this->driver_id)
            ->latest()
            ->get();

        $last = $this->latestLog();
        if ($last->flow->name === 'DEPART') {
            // isi ulang state form dari log terakhir
            $this->category = $last->category->name;
            $this->posyandu_id = $last->posyandu_id;

            $this->amount_bumil = $last->amount_bumil;
            $this->amount_busui = $last->amount_busui;
            $this->amount_balita = $last->amount_balita;
        }
    }

    public function rules()
    {
        $rules = [
            'category' => 'required',
            'flow' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];

        if ($this->flow === DriverFlow::ARRIVE->name) {
            $rules['posyandu_id'] = 'required|exists:posyandu,id';
            $rules['amount_bumil'] = 'required|numeric|min:0';
            $rules['amount_busui'] = 'required|numeric|min:0';
            $rules['amount_balita'] = 'required|numeric|min:0';
        }

        return $rules;
    }

    public function updatedSelectedRoute()
    {
        $this->reset([
            'posyandu_id',
            'address',
            'amount_bumil',
            'amount_busui',
            'amount_balita',
        ]);

        $route = DistributionRoute::with('posyandus')
            ->find($this->selected_route);

        $this->posyandus = $route?->posyandus ?? [];
    }

    public function updatedPosyanduId($value)
    {
        $posyandu = Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->find($value);

        if (!$posyandu) {
            $this->reset([
                'posyandu_id',
                'amount_bumil',
                'amount_busui',
                'amount_balita',
                'address',
            ]);
            return;
        }

        $this->amount_bumil = $posyandu->portions_sum_bumil ?? 0;
        $this->amount_busui = $posyandu->portions_sum_busui ?? 0;
        $this->amount_balita = $posyandu->portions_sum_balita ?? 0;
        $this->address = $posyandu->address;
    }

    public function canDepart(): bool
    {
        $last = $this->latestLog();
        if (!$last) return true;

        return $last->flow !== DriverFlow::DEPART;
    }

    public function canArrive(): bool
    {
        $last = $this->latestLog();
        return $last && $last->flow === DriverFlow::DEPART;
    }

    public function isOnTrip(): bool
    {
        $last = $this->latestLog();
        return $last && $last->flow === DriverFlow::DEPART;
    }

    public function updateLiveLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;

        DriverLocation::create([
            'driver_id' => $this->driver_id,
            'latitude' => $lat,
            'longitude' => $lng,
        ]);
    }

    public function berangkat()
    {
        if (!$this->canDepart()) {
            session()->flash('error', 'Anda belum melakukan tiba dari perjalanan sebelumnya.');
            return;
        }

        $this->flow = DriverFlow::DEPART->name;
        $this->saveDelivery();
    }

    public function tiba()
    {
        if (!$this->canArrive()) {
            session()->flash('error', 'Anda belum klik berangkat.');
            return;
        }

        $this->flow = DriverFlow::ARRIVE->name;
        $this->saveDelivery();

        $this->reset([
            'posyandu_id',
            'address',
            'amount_bumil',
            'amount_busui',
            'amount_balita',
        ]);
    }

    private function saveDelivery()
    {
        $this->validate();

        PosyanduDelivery::create([
            'timestamp' => now(),
            'prev_log_id' => $this->latestLog()?->id,
            'category' => $this->category,
            'flow' => $this->flow,
            'posyandu_id' => $this->posyandu_id,
            'amount_bumil' => $this->amount_bumil,
            'amount_busui' => $this->amount_busui,
            'amount_balita' => $this->amount_balita,
            'driver_id' => $this->driver_id,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        $this->loadLogs();
    }
}
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />
    
    <x-header title="Input Log Distribusi Posyandu" subtitle="Catat aktivitas perjalanan distribusi" separator>
        <x-slot:actions>
            <x-button link="{{ route('distribution.school-log-index') }}" label="Pengiriman Sekolah" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    @if(session()->has('error'))
    <x-alert icon="o-x-circle" class="alert-error">
        {{ session('error') }}
    </x-alert>
    @endif
    
    @if(session()->has('success'))
    <x-alert icon="o-check-circle" class="alert-success">
        {{ session('success') }}
    </x-alert>
    @endif

    <x-form>
        <x-radio
            label="Jenis"
            wire:model="category"
            :options="[
            ['id'=>DriverCategory::DELIVERY->name,'name'=>DriverCategory::DELIVERY->label()],
            ['id'=>DriverCategory::TAKE->name,'name'=>DriverCategory::TAKE->label()]
            ]"
            inline
        />
        
        <div class="grid grid-cols-4 gap-1 items-center">
            <x-select
                label="Rute"
                wire:model.live="selected_route"
                :options="$distribution_route"
                option-label="name"
                option-value="id"
                placeholder="Pilih Rute"
                :disabled="$this->isOnTrip()"
            />
            <div class="col-span-3">
                <x-select
                    label="Posyandu"
                    wire:model.live="posyandu_id"
                    :options="$this->posyandus"
                    option-label="posyandu_name"
                    option-value="id"
                    placeholder="Pilih Posyandu"
                    :disabled="$this->isOnTrip()"
                />
            </div>
        </div>
        <x-textarea label="Alamat" wire:model="address" placeholder="..." rows="2" disabled />
        <div class="grid grid-cols-3 gap-1">
            <x-input
            label="Jumlah BUMIL"
            wire:model="amount_bumil"
            :disabled="$this->isOnTrip()"
            />
            <x-input
            label="Jumlah BUSUI"
            wire:model="amount_busui"
            :disabled="$this->isOnTrip()"
            />

            <x-input
            label="Jumlah BALITA"
            wire:model="amount_balita"
            :disabled="$this->isOnTrip()"
            />
        </div>

        {{-- ================= GPS ================= --}}
        <x-card>
            <x-slot:title>
                <div class="flex items-center gap-2">
                    <span>Lokasi GPS</span>
        
                    <span
                        x-data="{ ready: false }"
                        x-bind:class="ready ? 'text-green-600' : 'text-red-600'"
                        x-text="ready ? '✔ GPS Terkunci' : '✖ Mencari Sinyal GPS...'"
                        x-on:gps-ready.window="ready = true"
                        x-on:gps-lost.window="ready = false"
                        class="text-sm font-semibold"
                    ></span>
                </div>
            </x-slot:title>
        
            <div
                x-data="{
                    interval: null,
        
                    init() {
                        this.getLocation();
        
                        this.interval = setInterval(() => {
                            this.getLocation();
                        }, 10000);
                    },
        
                    getLocation() {
                        navigator.geolocation.getCurrentPosition(
                            (pos) => {
                                window.dispatchEvent(new Event('gps-ready'));
        
                                $wire.updateLiveLocation(
                                    pos.coords.latitude,
                                    pos.coords.longitude
                                );
                            },
                            (err) => {
                                console.error(err);
                                window.dispatchEvent(new Event('gps-lost'));
                            },
                            { enableHighAccuracy: true }
                        );
                    }
                }"
                x-init="init()"
            ></div>
        </x-card>
    </x-form>

    {{-- ================= ACTION BUTTON ================= --}}
    <div class="grid grid-cols-2 gap-3">
        
        <x-button
        label="Berangkat"
        icon="o-truck"
        wire:click="berangkat"
        class="btn-success"
        :disabled="!$this->canDepart()"
        />
        
        <x-button
        label="Tiba"
        icon="o-map-pin"
        wire:click="tiba"
        class="btn-primary"
        :disabled="!$this->canArrive()"
        />
        
    </div>

    {{-- LOG --}}
    <div class="mt-3">
        <h2 class="text-2xl font-semibold mb-1 border-b">Histori Log Distribusi</h2>
        @foreach ($logs as $log)
            <div class="p-2 border rounded-md shadow mb-2">
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-xs font-light">{{ Carbon::parse($log->timestamp)->translatedFormat('d M Y H:i') }}</h5>
                        <h3 class="text-xl font-semibold">
                            {{ $log->posyandu->posyandu_name ?? 'Perjalanan Dimulai' }}
                        </h3>
                        <p>
                            <span>Porsi BUMIL: {{ $log->amount_bumil }}</span>
                            <span>Porsi BUSUI: {{ $log->amount_busui }}</span>
                            <span>Porsi BALITA: {{ $log->amount_balita }}</span>
                        </p>
                    </div>
                    <div>
                        @if ($log->flow->name === 'DEPART')
                        <span class="p-2 bg-amber-500 text-white rounded-md">
                            {{ $log->flow->label() }}
                        </span>    
                        @else
                        <span class="p-2 bg-green-500 text-white rounded-md">
                            {{ $log->flow->label() }}
                        </span>    

                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>