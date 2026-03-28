<?php

use Livewire\Component;
use App\Models\DistributionRoute;
use App\Models\School;
use App\Models\SchoolRoute;
use App\Models\Posyandu;
use App\Models\PosyanduRoute;

new class extends Component
{
    public $breadcrumbs;

    public $routes;
    public $schools;
    public $posyandus;
    public $isSorting = false;
    public $isAddingSchool = false;
    public $isAddingPosyandu = false;

    public $addSchoolModal = false;
    public $addPosyanduModal = false;

    public $availableSchools = [];
    public $availablePosyandus = [];

    public $selectedRoute = null;

    public $selectedSchools = [];
    public $selectedPosyandus = [];

    public function mount()
    {
        $this->routes = DistributionRoute::orderBy('route_name')->get();
        $this->schools = School::orderBy('school_name')->get();
        $this->posyandus = Posyandu::orderBy('posyandu_name')->get();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Manajemen Distribusi', 'link' => route('distribution.index')],
            ['label' => 'Rute Distribusi', 'link' => route('distribution.route-index')],
            ['label' => 'Assign Item Route'],
        ];
    }

    public function openAddSchoolModal()
    {
        $this->availableSchools = School::whereNotIn('id', $this->selectedSchools)
            ->orderBy('school_name')
            ->get();

        $this->addSchoolModal = true;
    }

    public function openAddPosyanduModal()
    {
        $this->availablePosyandus = Posyandu::whereNotIn('id', $this->selectedPosyandus)
            ->orderBy('posyandu_name')
            ->get();

        $this->addPosyanduModal = true;
    }

    public function toggleSortMode()
    {
        $this->isSorting = !$this->isSorting;
    }


    public function updatedSelectedRoute()
    {
        if (!$this->selectedRoute) return;

        $route = DistributionRoute::with(['schools', 'posyandus'])->find($this->selectedRoute);

        $this->selectedSchools = $route->schools
            ->sortBy('pivot.delivery_order')
            ->pluck('id')
            ->values()
            ->toArray();

        $this->selectedPosyandus = $route->posyandus
            ->sortBy('pivot.delivery_order')
            ->pluck('id')
            ->values()
            ->toArray();
    }

    public function reorderSchools($id, $position)
    {
        $route = DistributionRoute::find($this->selectedRoute);

        // Ambil semua school id berdasarkan urutan sekarang
        $schools = $route->schools()
            ->orderBy('delivery_order')
            ->pluck('schools.id')
            ->toArray();

        // Hapus item yang dipindah
        $schools = array_values(array_diff($schools, [$id]));

        // Masukkan kembali ke posisi baru
        array_splice($schools, $position, 0, $id);

        // Update database sesuai urutan baru
        foreach ($schools as $index => $schoolId) {
            SchoolRoute::where('route_id', $this->selectedRoute)
                ->where('school_id', $schoolId)
                ->update([
                    'delivery_order' => $index + 1
                ]);
        }

        // Update state Livewire supaya tidak reset
        $this->selectedSchools = $schools;
    }

    public function reorderPosyandus($id, $position)
    {
        $route = DistributionRoute::find($this->selectedRoute);

        // Ambil semua posyandu id berdasarkan urutan sekarang
        $posyandus = $route->posyandus()
            ->orderBy('delivery_order')
            ->pluck('posyandus.id')
            ->toArray();

        // Hapus item yang dipindah
        $posyandus = array_values(array_diff($posyandus, [$id]));

        // Masukkan kembali ke posisi baru
        array_splice($posyandus, $position, 0, $id);

        // Update database sesuai urutan baru
        foreach ($posyandus as $index => $posyanduId) {
            PosyanduRoute::where('route_id', $this->selectedRoute)
                ->where('posyandu_id', $posyanduId)
                ->update([
                    'delivery_order' => $index + 1
                ]);
        }

        // Update state Livewire supaya tidak reset
        $this->selectedPosyandus = $posyandus;
    }

    public function addSchool($schoolId)
    {
        if (!in_array($schoolId, $this->selectedSchools)) {

            $this->selectedSchools[] = $schoolId;

            SchoolRoute::create([
                'route_id' => $this->selectedRoute,
                'school_id' => $schoolId,
                'delivery_order' => count($this->selectedSchools),
            ]);

            $this->updatedSelectedRoute();
        }

        $this->openAddSchoolModal();
    }


    public function save()
    {
        $this->validate([
            'selectedRoute' => 'required'
        ]);

        $route = DistributionRoute::find($this->selectedRoute);

        $syncData = [];

        foreach ($this->selectedSchools as $index => $schoolId) {
            $syncData[$schoolId] = [
                'delivery_order' => $index + 1
            ];
        }

        $route->schools()->sync($syncData);
    }

    public function removeSchool($schoolId)
    {
        SchoolRoute::where('route_id', $this->selectedRoute)
            ->where('school_id', $schoolId)
            ->delete();

        $this->selectedSchools = array_values(
            array_diff($this->selectedSchools, [$schoolId])
        );

        $this->save();
    }

    public function addPosyandu($posyanduId)
    {
        if (!in_array($posyanduId, $this->selectedPosyandus)) {

            $this->selectedPosyandus[] = $posyanduId;

            PosyanduRoute::create([
                'route_id' => $this->selectedRoute,
                'posyandu_id' => $posyanduId,
                'delivery_order' => count($this->selectedPosyandus),
            ]);

            $this->updatedSelectedRoute(); // refresh urutan
        }

        $this->openAddPosyanduModal(); // refresh isi modal
    }
};
?>

<div class="max-w-6xl mx-auto">

    <x-modal wire:model="addSchoolModal" title="Tambah Sekolah ke Rute">

        <div class="space-y-2 max-h-[400px] overflow-y-auto">
    
            @foreach($availableSchools as $school)
                <div class="p-3 border rounded-lg flex justify-between items-start">
    
                    <div>
                        <div class="font-semibold">
                            {{ $school->school_code }} — {{ $school->school_name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $school->address }}
                        </div>
                    </div>
    
                    <x-button
                        label="Tambah"
                        class="btn-sm btn-primary"
                        wire:click="addSchool({{ $school->id }})"
                    />
    
                </div>
            @endforeach
    
        </div>
    
    </x-modal>
    <x-modal wire:model="addPosyanduModal" title="Tambah Posyandu ke Rute">

        <div class="space-y-2 max-h-[400px] overflow-y-auto">
    
            @foreach($availablePosyandus as $posyandu)
                <div class="p-3 border rounded-lg flex justify-between items-start">
    
                    <div>
                        <div class="font-semibold">
                            {{ $posyandu->posyandu_code }} — {{ $posyandu->posyandu_name }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $posyandu->address }}
                        </div>
                    </div>
    
                    <x-button
                        label="Tambah"
                        class="btn-sm btn-primary"
                        wire:click="addPosyandu({{ $posyandu->id }})"
                    />
    
                </div>
            @endforeach
    
        </div>
    
    </x-modal>

    {{-- BREADCRUMBS --}}
    <x-breadcrumbs :items="$breadcrumbs" />
        
    {{-- HEADER --}}
    <div class="mb-2 bg-white p-4 rounded-xl">
        <h1 class="text-2xl font-bold text-gray-800">
            Assign Sekolah & Posyandu ke Rute
        </h1>
        <p class="text-gray-500 text-sm">
            Atur skenario distribusi untuk setiap rute
        </p>
    </div>

    {{-- SUCCESS ALERT --}}
    @if(session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- PILIH RUTE --}}
    <div class="mb-2 bg-white p-4 rounded-xl">
        <label class="text-sm text-gray-600">Pilih Rute</label>
        <select wire:model.live="selectedRoute"
            class="w-full mt-1 p-2 border rounded-lg">
            <option value="">-- Pilih Rute --</option>
            @foreach($routes as $route)
                <option value="{{ $route->id }}">
                    {{ $route->route_name }}
                </option>
            @endforeach
        </select>
    </div>

    @if($selectedRoute)

    <div class="grid md:grid-cols-2 gap-6">

        {{-- =========================
             SEKOLAH
        ==========================--}}
        <div class="bg-white p-4 rounded-xl shadow">

            <div class="flex justify-between items-center mb-3">
                <h2 class="font-semibold">
                    Urutan Sekolah
                </h2>

                {{-- <button wire:click="$toggle('isAddingSchool')"
                    class="text-sm px-3 py-1 rounded-lg border bg-green-100">
                    Tambah Sekolah
                </button> --}}
                <x-button wire:click="openAddSchoolModal">Menu Sekolah</x-button>
            </div>

            {{-- LIST SEKOLAH --}}
            <ul wire:sort="reorderSchools" class="space-y-3">

                @foreach($selectedSchools as $schoolId)

                    @php
                        $school = $schools->firstWhere('id', $schoolId);
                    @endphp

                    @if($school)
                        <li wire:key="school-{{ $school->id }}"
                            wire:sort:item="{{ $school->id }}"
                            class="p-3 bg-gray-50 rounded-xl border flex items-center justify-between">

                            <div class="flex gap-2 items-center">
                                <span wire:sort:handle
                                      class="cursor-move p-2 text-gray-500">
                                      ☰
                                </span>

                                <div>
                                    <p class="font-semibold">
                                        {{ $school->school_name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $school->address }}
                                    </p>
                                </div>
                            </div>

                            <button wire:click="removeSchool({{ $school->id }})"
                                class="text-red-500 text-sm cursor-pointer">
                                Hapus
                            </button>

                        </li>
                    @endif

                @endforeach

            </ul>

            {{-- TAMBAH SEKOLAH --}}
            @if($isAddingSchool)
                <div class="mt-4 border-t pt-4 space-y-2 max-h-60 overflow-y-auto">

                    @foreach($schools->whereNotIn('id', $selectedSchools) as $school)
                        <div class="flex justify-between items-center p-2 border rounded">
                            <span>{{ $school->school_name }}</span>

                            <button wire:click="addSchool({{ $school->id }})"
                                class="text-sm px-2 py-1 bg-blue-600 text-white rounded">
                                Tambah
                            </button>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>


        {{-- =========================
             POSYANDU
        ==========================--}}
        <div class="bg-white p-4 rounded-xl shadow">

            <div class="flex justify-between items-center mb-3">
                <h2 class="font-semibold">
                    Urutan Posyandu
                </h2>

                {{-- <button wire:click="$toggle('isAddingPosyandu')"
                    class="text-sm px-3 py-1 rounded-lg border bg-green-100">
                    Tambah Posyandu
                </button> --}}
                <button wire:click="openAddPosyanduModal">
            </div>

            {{-- LIST POSYANDU --}}
            <ul wire:sort="reorderPosyandus" class="space-y-3">

                @foreach($selectedPosyandus as $posyanduId)

                    @php
                        $posyandu = $posyandus->firstWhere('id', $posyanduId);
                    @endphp

                    @if($posyandu)
                        <li wire:key="posyandu-{{ $posyandu->id }}"
                            wire:sort:item="{{ $posyandu->id }}"
                            class="p-3 bg-gray-50 rounded-xl border flex items-center justify-between">

                            <div class="flex gap-2 items-center">
                                <span wire:sort:handle
                                      class="cursor-move p-2 text-gray-500">
                                      ☰
                                </span>

                                <div>
                                    <p class="font-semibold">
                                        {{ $posyandu->posyandu_name }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ $posyandu->address }}
                                    </p>
                                </div>
                            </div>

                            <button wire:click="removePosyandu({{ $posyandu->id }})"
                                class="text-red-500 text-sm cursor-pointer">
                                Hapus
                            </button>

                        </li>
                    @endif

                @endforeach

            </ul>

            {{-- TAMBAH POSYANDU --}}
            @if($isAddingPosyandu)
                <div class="mt-4 border-t pt-4 space-y-2 max-h-60 overflow-y-auto">

                    @foreach($posyandus->whereNotIn('id', $selectedPosyandus) as $posyandu)
                        <div class="flex justify-between items-center p-2 border rounded">
                            <span>{{ $posyandu->posyandu_name }}</span>

                            <button wire:click="addPosyandu({{ $posyandu->id }})"
                                class="text-sm px-2 py-1 bg-blue-600 text-white rounded">
                                Tambah
                            </button>
                        </div>
                    @endforeach

                </div>
            @endif

        </div>

    </div>
    @endif

</div>

