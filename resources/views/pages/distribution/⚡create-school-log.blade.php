<?php

use Livewire\Component;
use App\enum\DriverCategory;
use App\enum\DriverFlow;
use App\Models\SchoolDelivery;
use App\Models\School;
use App\Models\DriverLocation;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;

    public $logs = [];
    public $last_log;

    public $schools;

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

        $this->loadLogs();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Distribusi', 'link' => route('distribution.index')],
            ['label' => 'Log Pengiriman Sekolah', ],
        ];
    }

    public function loadLogs()
    {
        $this->logs = SchoolDelivery::with('school')
            ->where('driver_id', $this->driver_id)
            ->latest()
            ->get();

        $this->last_log = $this->logs->first();

        if ($this->last_log) {

            // isi ulang state form dari log terakhir
            $this->category = $this->last_log->category->name;
            $this->school_id = $this->last_log->school_id;

            $this->amount_pk = $this->last_log->amount_pk;
            $this->amount_pb = $this->last_log->amount_pb;
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


    public function setLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
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

        return $this->last_log->flow === DriverFlow::DEPART;
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
        $this->reset(['latitude','longitude','address']);
    }
}
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />
    
    <x-header title="Input Log Distribusi Sekolah" subtitle="Catat aktivitas perjalanan distribusi" separator>
        <x-slot:actions>
            <x-button link="{{ route('distribution.school-log-index') }}" label="Pengiriman" class="btn-primary" />
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
                wire:model.live="school_id"
                :options="$schools"
                option-label="school_name"
                option-value="id"
                placeholder="Pilih Sekolah"
                :disabled="$this->isOnTrip()"
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
        <x-card title="Lokasi GPS">
            <div
            x-data="{
                interval: null,

                startTracking(){
                    this.interval = setInterval(() => {
                        navigator.geolocation.getCurrentPosition(
                            pos => {
                                $wire.updateLiveLocation(
                                    pos.coords.latitude,
                                    pos.coords.longitude
                                )
                            },
                            err => console.error(err),
                            { enableHighAccuracy: true }
                        )
                    }, 10000)
                }
            }"
            x-init="startTracking()"
            >
            </div>
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
                        <h3 class="text-xl font-semibold">{{ $log->school->school_name }}</h3>
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