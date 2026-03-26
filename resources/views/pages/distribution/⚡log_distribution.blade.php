<?php

use Livewire\Component;
use App\Enum\DriverCategory;
use App\Enum\DriverFlow;

use App\Models\SchoolDelivery;
use App\Models\PosyanduDelivery;

use App\Models\School;
use App\Models\Posyandu;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;

    public $tab = 'school';

    public $schools = [];
    public $posyandus = [];

    public $logs = [];
    public $last_log;

    public $timestamp;
    public $category;
    public $flow;

    public $school_id;
    public $posyandu_id;

    public $amount_pk;
    public $amount_pb;

    public $amount_bumil;
    public $amount_busui;
    public $amount_balita;

    public $driver_id;

    public $latitude = null;
    public $longitude = null;

    public $locationStatus = 'Belum terdeteksi';


    public function mount()
    {
        $this->driver_id = Auth::id();

        $this->schools = School::orderBy('school_name')->get();
        $this->posyandus = Posyandu::orderBy('posyandu_name')->get();

        $this->loadLogs();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Distribusi']
        ];
    }


    public function updatedTab()
    {
        $this->reset([
            'school_id',
            'posyandu_id',
            'amount_pk',
            'amount_pb',
            'amount_bumil',
            'amount_busui',
            'amount_balita'
        ]);

        $this->loadLogs();
    }


    private function loadLogs()
    {
        if ($this->tab === 'school') {

            $this->logs = SchoolDelivery::with('school')
                ->where('driver_id', $this->driver_id)
                ->latest()
                ->get();

        } else {

            $this->logs = PosyanduDelivery::with('posyandu')
                ->where('driver_id', $this->driver_id)
                ->latest()
                ->get();

        }

        $this->last_log = $this->logs->first();
    }


    protected function rules()
    {
        if ($this->tab === 'school') {

            return [

                'category' => 'required',
                'flow' => 'required',

                'school_id' => 'required|exists:schools,id',

                'amount_pk' => 'required|numeric|min:0',
                'amount_pb' => 'required|numeric|min:0',

                'latitude' => 'required',
                'longitude' => 'required',

            ];
        }

        return [

            'category' => 'required',
            'flow' => 'required',

            'posyandu_id' => 'required|exists:posyandus,id',

            'amount_bumil' => 'required|numeric|min:0',
            'amount_busui' => 'required|numeric|min:0',
            'amount_balita' => 'required|numeric|min:0',

            'latitude' => 'required',
            'longitude' => 'required',

        ];
    }


    public function setLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;

        $this->locationStatus = 'Lokasi berhasil terdeteksi';
    }


    public function canDepart(): bool
    {
        if (!$this->last_log) {
            return true;
        }

        return $this->last_log->flow !== DriverFlow::DEPART;
    }


    public function canArrive(): bool
    {
        if (!$this->last_log) {
            return false;
        }

        if ($this->last_log->flow !== DriverFlow::DEPART) {
            return false;
        }

        // Pastikan tab sama dengan jenis log
        if ($this->tab === 'school' && $this->last_log instanceof \App\Models\SchoolDelivery) {
            return true;
        }

        if ($this->tab === 'posyandu' && $this->last_log instanceof \App\Models\PosyanduDelivery) {
            return true;
        }

        return false;
    }



    public function isOnTrip(): bool
    {
        if (!$this->last_log) return false;

        return $this->last_log->flow === DriverFlow::DEPART;
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

            session()->flash('error', 'Tujuan tiba tidak sesuai dengan perjalanan.');

            return;
        }

        $this->flow = DriverFlow::ARRIVE->name;

        $this->saveDelivery();

        $this->reset([
            'school_id',
            'posyandu_id',
            'amount_pk',
            'amount_pb',
            'amount_bumil',
            'amount_busui',
            'amount_balita'
        ]);
    }


    private function saveDelivery()
    {
        $this->timestamp = now();

        $this->validate();


        if ($this->tab === 'school') {

            SchoolDelivery::create([

                'timestamp' => $this->timestamp,
                'category' => $this->category,
                'flow' => $this->flow,

                'school_id' => $this->school_id,

                'amount_pk' => $this->amount_pk,
                'amount_pb' => $this->amount_pb,

                'driver_id' => $this->driver_id,

                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ]);

        } else {

            PosyanduDelivery::create([

                'timestamp' => $this->timestamp,
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

        }

        $this->loadLogs();

        session()->flash('success', 'Log berhasil disimpan.');

        $this->reset(['latitude','longitude']);

        $this->locationStatus = 'Belum terdeteksi';
    }

};
?>

<div class="space-y-5">

    <x-breadcrumbs :items="$breadcrumbs" />
    
    <x-header title="Input Log Driver" subtitle="Catat aktivitas perjalanan distribusi" separator>
        <x-slot:actions>
            <x-button link="{{ route('distribution.route-index') }}" label="Rute Distribusi" />
            <x-button link="{{ route('distribution.log-index') }}" label="Pengiriman" class="btn-primary" />
        </x-slot:actions>
    </x-header>
    
    {{-- ALERT --}}
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

    {{ ssdvsds }}
    
    <x-tabs wire:model="tab">
    
        {{-- ================= SEKOLAH ================= --}}
        <x-tab name="school" label="Sekolah">
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
                <x-select
                    label="Sekolah"
                    wire:model.live="school_id"
                    :options="$schools"
                    option-label="school_name"
                    option-value="id"
                    placeholder="Pilih Sekolah"
                    :disabled="$this->isOnTrip()"
                />
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
            </x-form>
        </x-tab>
        
        
        {{-- ================= POSYANDU ================= --}}
        <x-tab name="posyandu" label="Posyandu">
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
                <x-select
                    label="Posyandu"
                    wire:model.live="posyandu_id"
                    :options="$posyandus"
                    option-label="posyandu_name"
                    option-value="id"
                    placeholder="Pilih Posyandu"
                    :disabled="$this->isOnTrip()"
                />
                <div class="grid grid-cols-3 gap-1">
                    <x-input
                        label="Bumil"
                        wire:model="amount_bumil"
                        :disabled="$this->isOnTrip()"
                    />
                    <x-input
                        label="Busui"
                        wire:model="amount_busui"
                        :disabled="$this->isOnTrip()"
                    />
                    <x-input
                        label="Balita"
                        wire:model="amount_balita"
                        :disabled="$this->isOnTrip()"
                    />
                </div>
            </x-form>
        </x-tab>
    
    </x-tabs>
    
    
    {{-- ================= GPS ================= --}}
    <x-card title="Lokasi GPS">
        <div
        x-data="{
        loading:false,
        getLocation(){
        this.loading=true
        navigator.geolocation.getCurrentPosition(
        pos=>{
        $wire.setLocation(pos.coords.latitude,pos.coords.longitude)
        this.loading=false
        },
        ()=>{ alert('Gagal mendeteksi lokasi'); this.loading=false }
        )
        }
        }"
        class="space-y-2"
        >
            <x-button
                label="Ambil Lokasi"
                icon="o-map-pin"
                @click="getLocation()"
                spinner
            />
            <p class="text-xs text-gray-500">
                {{ $locationStatus }}
            </p>
            @if($latitude)
                <iframe
                class="w-full h-52 rounded-lg"
                loading="lazy"
                src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&z=17&output=embed">
                </iframe>
            @endif
        </div>
    </x-card>
        
        
    {{-- ================= ACTION BUTTON ================= --}}
    <div class="grid grid-cols-2 gap-3">
        
        <x-button
        label="Berangkat"
        icon="o-truck"
        wire:click="berangkat"
        class="btn-success"
        :disabled="($tab === 'school' && !$school_id) || ($tab === 'posyandu' && !$posyandu_id) || !$this->canDepart()"
        />
        
        <x-button
        label="Tiba"
        icon="o-map-pin"
        wire:click="tiba"
        class="btn-primary"
        :disabled="($tab === 'school' && !$school_id) || ($tab === 'posyandu' && !$posyandu_id) || !$this->canArrive()"
        />
        
    </div>
        
        
    {{-- ================= LOG ================= --}}
    <x-card title="Riwayat Log">
        @if(count($logs) === 0)
            <div class="text-center py-6 text-gray-400 text-sm">
                Belum ada riwayat pengiriman
            </div>
        @else
        <div class="divide-y">
            @foreach($logs as $log)
                <x-list-item :item="$log">
                    <x-slot:value>
                        <div>
                            <p class="font-medium">
                                {{ $log->category->label() }}
                                -
                                @if($tab === 'school')
                                    {{ $log->school->school_name ?? '-' }}
                                @else
                                    {{ $log->posyandu->posyandu_name ?? '-' }}
                                @endif
                            </p>
                            @if($tab === 'school')
                                <p class="text-sm text-gray-500">
                                    PK {{ $log->amount_pk }} • PB {{ $log->amount_pb }}
                                </p>
                            @else
                                <p class="text-sm text-gray-500">
                                    Bumil {{ $log->amount_bumil }} • Busui {{ $log->amount_busui }} • Balita {{ $log->amount_balita }}
                                </p>
                            @endif
                                <p class="text-xs text-gray-400">
                                    {{ Carbon::parse($log->timestamp)->translatedFormat('d M Y H:i') }}
                                </p>
                        </div>
                    </x-slot:value>

                    <x-slot:actions>
                    <x-badge
                    :value="$log->flow->label()"
                    class="{{ $log->flow->name === 'DEPART' ? 'badge-success' : 'badge-primary' }}"
                    />
                    </x-slot:actions>
                </x-list-item>
            @endforeach
            </div>
        @endif
    </x-card>
    
    </div>
    