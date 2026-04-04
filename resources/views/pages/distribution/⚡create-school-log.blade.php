<?php

use Livewire\Component;
use App\Enums\DriverCategory;
use App\Enums\DriverFlow;
use App\Models\SchoolDelivery;
use App\Models\School;
use App\Models\DriverLocation;
use App\Models\DistributionRoute;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;

    public $logs = [];
    public $last_log;

    public $schools;
    public $distribution_route;
    public $selected_route;

    public $timestamp;
    public $category;
    public $flow;
    public $driver_id;

    public $school_id;
    public $address;
    public $amount_pk;
    public $amount_pb;

    public $latitude = null;
    public $longitude = null;

    public function mount()
    {
        $this->driver_id = Auth::id();

        $this->schools = School::orderBy('school_name')->get();

        $this->distribution_route = DistributionRoute::where('is_active', true)
            ->select('id', 'route_name')
            ->get()
            ->map(fn ($r) => [
                'id' => $r->id,
                'name' => $r->route_name,
            ])
            ->toArray();
        
        $this->loadLogs();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Distribusi', 'link' => route('distribution.index')],
            ['label' => 'Log Pengiriman Sekolah', ],
        ];
    }

    private function latestLog()
    {
        return SchoolDelivery::where('driver_id', $this->driver_id)
            ->latest()
            ->first();
    }

    public function loadLogs()
    {
        $this->logs = SchoolDelivery::with('school')
            ->where('driver_id', $this->driver_id)
            ->latest()
            ->get();

        $last = $this->latestLog();

        if ($last?->flow?->name === 'DEPART') {
            // isi ulang state form dari log terakhir
            $this->category = $last->category->name;
            $this->school_id = $last->school_id;

            $this->amount_pk = $last->amount_pk;
            $this->amount_pb = $last->amount_pb;
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
            $rules['school_id'] = 'required|exists:schools,id';
            $rules['amount_pk'] = 'required|numeric|min:0';
            $rules['amount_pb'] = 'required|numeric|min:0';
        }

        return $rules;
    }

    public function updatedSelectedRoute()
    {
        $this->reset([
            'school_id',
            'address',
            'amount_pk',
            'amount_pb',
        ]);

        $route = DistributionRoute::with('schools')
            ->find($this->selected_route);

        $this->schools = $route?->schools ?? [];
    }

    public function updatedSchoolId($value)
    {
        $school = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->find($value);

        if (!$school){
            $this->reset([
                'school_id',
                'amount_pk',
                'amount_pb',
            ]);
            return;
        }

        $teacher = $school->portions_sum_teacher_portions ?? 0;
        $nonTeacher = $school->portions_sum_non_teacher_portions ?? 0;

        $tambahan = $teacher + $nonTeacher;

        $small = $school->portions_sum_small_portions ?? 0;
        $big = $school->portions_sum_big_portions ?? 0;

        if ($big != 0) {
            $bigFinal = $big + $tambahan;
            $smallFinal = $small;
        } else {
            $smallFinal = $small + $tambahan;
            $bigFinal = $big;
        }

        $this->amount_pk = $smallFinal;
        $this->amount_pb = $bigFinal;
        $this->address = $school->address;
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
            'school_id',
            'amount_pk',
            'amount_pb',
        ]);
    }

    private function saveDelivery()
    {
        $this->timestamp = now();
        $this->validate();

        SchoolDelivery::create([

            'timestamp' => $this->timestamp,
            'prev_log_id' => $this->last_log?->id,
            'category' => $this->category,
            'flow' => $this->flow,

            'school_id' => $this->school_id,

            'amount_pk' => $this->amount_pk,
            'amount_pb' => $this->amount_pb,

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
    
    <x-header title="Input Log Distribusi Sekolah" subtitle="Catat aktivitas perjalanan distribusi" separator>
        <x-slot:actions>
            <x-button link="{{ route('distribution.posyandu-log-index') }}" label="Pengiriman Posyandu" class="btn-primary" />
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
                    label="Sekolah"
                    wire:model.live="school_id"
                    :options="$this->schools"
                    option-label="school_name"
                    option-value="id"
                    placeholder="Pilih Sekolah"
                    :disabled="$this->isOnTrip()"
                />
            </div>
        </div>
        <x-textarea label="Alamat" wire:model="address" placeholder="..." rows="2" disabled />
        <div class="grid grid-cols-2 gap-1">
            <x-input
            label="Jumlah PK"
            wire:model="amount_pk"
            :disabled="$this->isOnTrip()"
            />
            <x-input
            label="Jumlah PB"
            wire:model="amount_pb"
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
                        <h3 class="text-xl font-semibold">{{ $log->school->school_name ?? 'Perjalanan Dimulai' }}</h3>
                        <p>
                            <span>Porsi PK: {{ $log->amount_pk }}</span>
                            <span>Porsi Pb: {{ $log->amount_pb }}</span>
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