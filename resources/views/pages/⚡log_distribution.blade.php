<?php

use Livewire\Component;
use App\enum\DriverCategory;
use App\enum\DriverFlow;
use App\Models\SchoolDelivery;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

new class extends Component
{
    public $schools;
    public $logs;
    public $last_log;

    

    public $timestamp;
    public $category;
    public $flow;
    public $school_id;
    public $amount_pk;
    public $amount_pb;
    public $driver_id;
    public $latitude = null;
    public $longitude = null;
    public $locationStatus = 'Belum terdeteksi';

    public function mount()
    {
        $driver = auth()->user();

        $this->driver_id = $driver->id;

        // Ambil sekolah sesuai route driver
        $this->schools = School::where('route', $driver->route->route)->get();

        $this->logs = SchoolDelivery::where('driver_id', auth()->id())
            ->latest()
            ->get();

        $this->last_log = SchoolDelivery::where('driver_id', auth()->id())
            ->latest()
            ->first();

        $this->driver_id = auth()->id();

        if ($this->last_log && $this->last_log->flow === DriverFlow::DEPART) {

            // Karena category dan flow adalah enum
            $this->category  = $this->last_log->category->name;
            $this->school_id = $this->last_log->school_id;
            $this->amount_pk    = $this->last_log->amount_pk;
            $this->amount_pb    = $this->last_log->amount_pb;
        }
    }

    private function refreshLogs()
    {
        $this->logs = SchoolDelivery::where('driver_id', Auth::id())
            ->latest()
            ->get();

        $this->last_log = $this->logs->first();
    }

    protected function rules()
    {
        return [
            'timestamp' => 'required|date',
            'category' => 'required',
            'flow' => 'required',
            'school_id' => 'required|exists:schools,id',
            'amount_pk' => 'required|numeric|min:0',
            'amount_pb' => 'required|numeric|min:0',
            'driver_id' => 'required|exists:users,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ];
    }

    public function updatedSchoolId($value)
    {
        if (!$value) {
            $this->amount = null;
            return;
        }

        $school = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->find($value);

        if (!$school) {
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
    }

    public function setLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
        $this->locationStatus = 'Lokasi berhasil terdeteksi';
    }

    private function canDepart(): bool
    {
        if (!$this->last_log) {
            return true; // belum ada log → boleh berangkat
        }

        return $this->last_log->flow !== DriverFlow::DEPART;
    }

    private function canArrive(): bool
    {
        if (!$this->last_log) {
            return false; // belum pernah berangkat
        }

        return $this->last_log->flow === DriverFlow::DEPART;
    }

    public function isOnTrip(): bool
    {
        if (!$this->last_log) {
            return false;
        }

        return $this->last_log->flow === DriverFlow::DEPART;
    }

    public function berangkat()
    {
        if (!$this->canDepart()) {
            session()->flash('error', 'Anda belum melakukan Tiba dari perjalanan sebelumnya.');
            return;
        }

        $this->flow = DriverFlow::DEPART->name;
        $this->saveDelivery();
    }

    public function tiba()
    {
        if (!$this->canArrive()) {
            session()->flash('error', 'Anda belum melakukan Berangkat.');
            return;
        }

        $this->flow = DriverFlow::ARRIVE->name;
        $this->saveDelivery();

        $this->reset(['school_id', 'amount_pk', 'amount_pb']);
    }

    private function saveDelivery()
    {
        $this->timestamp = now();

        // Jika sedang dalam perjalanan,
        // pakai data dari log terakhir
        if ($this->isOnTrip()) {
            $this->category  = $this->last_log->category->name;
            $this->school_id = $this->last_log->school_id;
            $this->amount_pk    = $this->last_log->amount_pk;
            $this->amount_pb    = $this->last_log->amount_pb;
        }

        $this->validate();

        SchoolDelivery::create([
            'timestamp'  => $this->timestamp,
            'category'   => $this->category,
            'flow'       => $this->flow,
            'school_id'  => $this->school_id,
            'amount_pk'     => $this->amount_pk,
            'amount_pb'     => $this->amount_pb,
            'driver_id'  => $this->driver_id,
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,
        ]);

        $this->refreshLogs();

        session()->flash('success', 'Log berhasil disimpan.');



        $this->reset(['latitude', 'longitude']);
        $this->locationStatus = 'Belum terdeteksi';
    }
};
?>

<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-6 space-y-6">

    {{-- <div class="w-screen h-screen bg-slate-500 opacity-40  absolute top-0 left-0 z-50">
        <div class="">

        </div>
    </div> --}}
    {{-- <p class="text-red-500">timestamp: {{ $timestamp }}</p>
    <p class="text-red-500">category: {{ $category }}</p>
    <p class="text-red-500">flow: {{ $flow }}</p>
    <p class="text-red-500">school_id: {{ $school_id }}</p>
    <p class="text-red-500">amount: {{ $amount }}</p>
    <p class="text-red-500">driver_id: {{ $driver_id }}</p>
    <p class="text-red-500">latitude: {{ $latitude }}</p>
    <p class="text-red-500">longitude: {{ $longitude }}</p> --}}

    {{-- HEADER --}}
    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-700">Input Log Driver</h2>
        <p class="text-sm text-gray-500">Catat aktivitas perjalanan distribusi</p>
    </div>

    @if(session()->has('error'))
        <div class="bg-red-100 text-red-600 p-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    @if(session()->has('success'))
        <div class="bg-green-100 text-green-600 p-3 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- JENIS --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-2">
            Jenis
        </label>
        <div class="flex gap-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input 
                    type="radio" 
                    wire:model.live="category" 
                    value="{{ DriverCategory::DELIVERY->name }}"
                    @disabled($this->isOnTrip())
                >
                <span>{{ DriverCategory::DELIVERY->label() }}</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer">
                <input 
                    type="radio" 
                    wire:model.live="category" 
                    value="{{ DriverCategory::TAKE->name }}"
                    @disabled($this->isOnTrip())
                >
                <span>{{ DriverCategory::TAKE->label() }}</span>
            </label>
        </div>
        @error('flow')
            <p class="font-light text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    {{-- SEKOLAH --}}
    <div>
        <label class="block text-sm font-medium text-gray-600 mb-2">
            Nama Sekolah
        </label>
        <select wire:model.live="school_id"
            @disabled($this->isOnTrip())
            class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <option value="">-- Pilih Sekolah --</option>
            @foreach($schools as $item)
                <option value="{{ $item['id'] }}">{{ $item['school_name'] }}</option>
            @endforeach
        </select>
        @error('school_id')
            <p class="font-light text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-2 gap-2 items-center justify-center">
        <div class="">
            <label class="block text-sm font-medium text-gray-600 mb-2">
                Jumlah PK
            </label>
            <input type="text" wire:model.live="amount_pk"  @disabled($this->isOnTrip()) class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('amount_pk')
                <p class="font-light text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="">
            <label class="block text-sm font-medium text-gray-600 mb-2">
                Jumlah PB
            </label>
            <input type="text" wire:model.live="amount_pb"  @disabled($this->isOnTrip()) class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            @error('amount_pb')
                <p class="font-light text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- LOKASI --}}
    <div
        x-data="{
            loading: false,
            getLocation() {
                this.loading = true

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        $wire.setLocation(
                            pos.coords.latitude,
                            pos.coords.longitude
                        )
                        this.loading = false
                    },
                    () => {
                        alert('Gagal mendeteksi lokasi')
                        this.loading = false
                    }
                )
            }
        }"
        class="space-y-2"
    >

        <label class="block text-sm font-medium text-gray-600">
            Lokasi GPS
        </label>

        <button
            type="button"
            @click="getLocation()"
            class="bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-lg text-sm"
            :disabled="loading"
        >
            <span x-show="!loading">📍 Ambil Lokasi</span>
            <span x-show="loading">Mendeteksi...</span>
        </button>

        <div class="text-xs text-gray-600">
            {{ $locationStatus }}
        </div>

        @if($latitude && $longitude)
            <div class="mt-4 rounded-xl overflow-hidden shadow-md">
                <iframe
                    width="100%"
                    height="250"
                    style="border:0"
                    loading="lazy"
                    allowfullscreen
                    src="https://maps.google.com/maps?q={{ $latitude }},{{ $longitude }}&z=17&output=embed">
                </iframe>
            </div>
        @endif

        @error('latitude')
            <p class="font-light text-sm text-red-500">{{ $message }}</p>
        @enderror

        @if($latitude)
            <div class="text-xs text-gray-500">
                Lat: {{ $latitude }} <br>
                Lng: {{ $longitude }}
            </div>
        @endif

    </div>

    {{-- TOMBOL --}}
    <div class="grid grid-cols-2 gap-4 pt-4">
        <button
            wire:click="berangkat"
            @disabled(!$school_id || !$this->canDepart())
            class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-xl shadow-md disabled:bg-gray-300 disabled:cursor-not-allowed transition">
            🚚 Berangkat
        </button>
    
        <button
            wire:click="tiba"
            @disabled(!$school_id || !$this->canArrive())
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-xl shadow-md disabled:bg-gray-300 disabled:cursor-not-allowed transition">
            📍 Tiba
        </button>
    </div>
    

    {{-- RIWAYAT --}}
    <div class="pt-6 border-t">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">
            Riwayat Log
        </h3>

        @if(count($logs) === 0)
            <p class="text-sm text-gray-400 text-center">
                Belum ada riwayat
            </p>
        @else
            <div class="space-y-3 max-h-64 overflow-y-auto pr-2">
                @foreach($logs as $log)
                    <div class="p-3 rounded-xl border bg-gray-50 flex justify-between items-center">

                        <div>
                            <p class="font-medium text-gray-700">
                                {{ ucfirst($log['category']->label()) }} - {{ $log->school->school_name }}
                            </p>
                            <p class="font-light text-gray-700 text-sm">
                                PK ({{ $log->amount_pk }}) - PB ({{ $log->amount_pb }})
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ Carbon::parse($log['timestamp'])->translatedFormat('l, d F Y - H:i') }}
                            </p>
                        </div>

                        <span class="text-sm font-semibold
                            {{ $log['flow']->label() === 'Berangkat' ? 'text-green-600' : 'text-blue-600' }}">
                            {{ $log['flow']->label() }}
                        </span>

                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
