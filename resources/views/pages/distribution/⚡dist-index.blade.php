<?php

use Livewire\Component;
use App\Models\User;
use App\Models\Posyandu;
use App\Models\School;
use App\Models\PosyanduDelivery;
use App\Models\SchoolDelivery;


new class extends Component
{
    public $selectedDate;
    public $breadcrumbs;

    public $schools;
    public $school_log;

    public $posyandus;
    public $posyandu_log;

    public function mount()
    {
        $this->selectedDate = now()->toDateString();

        $this->schools = School::all();
        $this->posyandus = Posyandu::all();
        $this->loadLogs();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Distribusi'],
        ];
    }
    
    public function loadLogs()
    {
        $this->school_log = SchoolDelivery::whereDate('created_at', $this->selectedDate)
            ->latest()->get();
        $this->posyandu_log = PosyanduDelivery::whereDate('created_at', $this->selectedDate)
            ->latest()->get();
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    
    <x-header title="Dashboard Distribusi" subtitle="Monitoring distribusi porsi MBG" separator>
        <x-slot:actions>
            @if (Auth::user()->role->name == 'ASLAP')
            <x-button link="{{ route('distribution.driver-location') }}" label="Lokasi Driver" />
            <x-button link="{{ route('distribution.route-index') }}" label="Rute Distribusi" />
            @endif
            @if (Auth::user()->role->name == 'DISTRIBUSI')
            <x-button link="{{ route('distribution.school-log-index') }}" label="Pengiriman Sekolah" class="btn-primary" />
            <x-button link="{{ route('distribution.posyandu-log-index') }}" label="Pengiriman Posyandu" class="btn-primary" />
            @endif
        </x-slot:actions>
    </x-header>

    <x-collapse separator>
        <x-slot:heading>
            Ringkasan Pengiriman Ke Sekolah Hari Ini
        </x-slot:heading>
        <x-slot:content>
            <div wire:poll.10s class="space-y-3">
                @php
                    $totalSchools = $schools->count();

                    $delivered = $schools->filter(function ($school) {
                        return $school->school_logs
                            ->where('flow', 'ARRIVE')
                            ->first(fn($log) => $log->created_at->isToday());
                    })->count();

                    $notDelivered = $totalSchools - $delivered;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-stat
                        title="Total Sekolah"
                        value="{{ $totalSchools }}"
                        icon="o-building-office"
                        tooltip="Jumlah seluruh sekolah hari ini"
                        color="text-primary" />
                
                    <x-stat
                        title="Terkirim"
                        value="{{ $delivered }}"
                        icon="o-check-circle"
                        tooltip="Sekolah yang sudah menerima hari ini"
                        color="text-green-500" />
                
                    <x-stat
                        title="Belum Dikirim"
                        value="{{ $notDelivered }}"
                        icon="o-x-circle"
                        tooltip="Sekolah yang belum menerima hari ini"
                        color="text-red-500" />
                </div>
                
                @foreach ($schools as $school)
                <x-card>
                    @php
                        $todayLogs = $school->school_logs
                            ->where('flow', 'ARRIVE')
                            ->filter(fn($log) => $log->created_at->isToday());
                    @endphp

                    <div class="flex items-center justify-between border-b-2 p-2">
                        <div>
                            <h3 class="font-bold text-lg">
                                {{ $school->school_name }}
                            </h3>
                
                            <div class="flex gap-2 mt-1 items-center">
                                <x-badge value="{{ $school->school_code }}" class="badge-outline badge-sm" />
                            </div>
                        </div>
                        <div class="">
                            @if ($todayLogs->first())
                            <span class="p-2 rounded-xl bg-green-500 text-white">Terkirim</span>
                            @else
                            <span class="p-2 rounded-xl bg-red-500 text-white">Belum Dikirim</span>
                            @endif
                        </div>
                    </div>
        
                    @foreach ($todayLogs as $item)
                    <div class="border-b py-2 text-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold"><x-icon name="o-user" />{{ $item->driver->name }}</p>
                                <p class="text-xs text-gray-400">
                                    <x-icon name="o-truck" class="w-3 h-3" />{{ $item->prev_log?->created_at?->format('H:i') }} → 
                                    <x-icon name="o-sparkles" class="w-3 h-3" />{{ $item->created_at->format('H:i') }}
                                </p>
                            </div>
        
                            <div class="flex gap-3 text-center">
                                <div>
                                    <p class="text-xs text-gray-400">PK</p>
                                    <p class="font-bold text-primary">{{ $item->amount_pk }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">PB</p>
                                    <p class="font-bold text-secondary">{{ $item->amount_pb }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </x-card>
                @endforeach
            </div>
        </x-slot:content>
    </x-collapse>

    <br>

    <x-collapse separator>
        <x-slot:heading>
            Ringkasan Pengiriman Ke Posyandu Hari Ini
        </x-slot:heading>
        <x-slot:content>
            <div wire:poll.10s class="space-y-3">
                @php
                    $totalPosyandu = $posyandus->count();

                    $delivered = $posyandus->filter(function ($posyandu) {
                        return $posyandu->posyandu_logs
                            ->where('flow', 'ARRIVE')
                            ->first(fn($log) => $log->created_at->isToday());
                    })->count();

                    $notDelivered = $totalPosyandu - $delivered;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <x-stat
                        title="Total Sekolah"
                        value="{{ $totalPosyandu }}"
                        icon="o-building-office"
                        tooltip="Jumlah seluruh sekolah hari ini"
                        color="text-primary" />
                
                    <x-stat
                        title="Terkirim"
                        value="{{ $delivered }}"
                        icon="o-check-circle"
                        tooltip="Sekolah yang sudah menerima hari ini"
                        color="text-green-500" />
                
                    <x-stat
                        title="Belum Dikirim"
                        value="{{ $notDelivered }}"
                        icon="o-x-circle"
                        tooltip="Sekolah yang belum menerima hari ini"
                        color="text-red-500" />
                </div>
                
                @foreach ($posyandus as $posyandu)
                <x-card>
                    @php
                        $todayLogs = $posyandu->posyandu_logs
                            ->where('flow', 'ARRIVE')
                            ->filter(fn($log) => $log->created_at->isToday());
                    @endphp

                    <div class="flex items-center justify-between border-b-2 p-2">
                        <div>
                            <h3 class="font-bold text-lg">
                                {{ $posyandu->posyandu_name }}
                            </h3>
                
                            <div class="flex gap-2 mt-1 items-center">
                                <x-badge value="{{ $posyandu->posyandu_code }}" class="badge-outline badge-sm" />
                            </div>
                        </div>
                        <div class="">
                            @if ($todayLogs->first())
                            <span class="p-2 rounded-xl bg-green-500 text-white">Terkirim</span>
                            @else
                            <span class="p-2 rounded-xl bg-red-500 text-white">Belum Dikirim</span>
                            @endif
                        </div>
                    </div>
        
                    @foreach ($todayLogs as $item)
                    <div class="border-b py-2 text-sm">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="font-semibold"><x-icon name="o-user" />{{ $item->driver->name }}</p>
                                <p class="text-xs text-gray-400">
                                    <x-icon name="o-truck" class="w-3 h-3" />{{ $item->prev_log?->created_at?->format('H:i') }} → 
                                    <x-icon name="o-sparkles" class="w-3 h-3" />{{ $item->created_at->format('H:i') }}
                                </p>
                            </div>
        
                            <div class="flex gap-3 text-center">
                                <div>
                                    <p class="text-xs text-gray-400">PK</p>
                                    <p class="font-bold text-primary">{{ $item->amount_pk }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">PB</p>
                                    <p class="font-bold text-secondary">{{ $item->amount_pb }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </x-card>
                @endforeach
            </div>
        </x-slot:content>
    </x-collapse>

    <div class="min-h-screen">

    </div>
</div>