<?php

use Livewire\Component;
use App\Models\DistributionRoute;

new class extends Component
{
    public $distribution_routes;
    public $route_name;
    public $showModal = false;

    protected $rules = [
        'route_name' => 'required|min:3'
    ];

    public function mount()
    {
        $this->loadRoutes();
    }

    public function loadRoutes()
    {
        $this->distribution_routes = DistributionRoute::withCount([
            'schools',
            'posyandus'
        ])->latest()->get();
    }

    public function save()
    {
        $this->validate();

        DistributionRoute::create([
            'route_name' => $this->route_name,
            'is_active' => true
        ]);

        $this->reset(['route_name', 'showModal']);
        $this->resetValidation();

        $this->loadRoutes();

        session()->flash('success', 'Rute berhasil dibuat!');
    }

    public function delete_route($id)
    {
        $route = DistributionRoute::find($id);

        if ($route !== null) {
            $route->delete();
        }
    }
};
?>

<div class=""
x-data="{ open: @entangle('showModal') }"
x-cloak>

    {{-- Make Route Modal --}}
    {{-- Overlay --}}
    <div 
        x-show="open"
        x-transition.opacity
        class="fixed inset-0 bg-black/40 backdrop-blur-sm z-40"
    ></div>

    {{-- Modal --}}
    <div 
        x-show="open"
        x-transition
        @keydown.escape.window="open = false"
        class="fixed inset-0 flex items-center justify-center z-50 p-4"
    >
        <div 
            @click.outside="open = false"
            class="bg-white w-full max-w-md p-6 rounded-2xl shadow-xl"
        >

            <h2 class="text-lg font-semibold mb-4">
                Buat Rute Baru
            </h2>

            <div class="mb-4">
                <label class="text-sm text-gray-600">
                    Nama Rute
                </label>

                <input 
                    wire:model.defer="route_name"
                    type="text"
                    class="w-full mt-1 p-2 border rounded-lg focus:ring focus:ring-blue-200 focus:outline-none"
                >

                @error('route_name')
                    <span class="text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <button 
                    @click="open = false"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition"
                >
                    Batal
                </button>

                <button 
                    wire:click="save"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition"
                >
                    Simpan
                </button>
            </div>

        </div>
    </div>


    
    {{-- HEADER --}}
    <div class="mb-4 flex justify-between items-center bg-white p-2 rounded-xl">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Manajemen Rute Distribusi
            </h1>
            <p class="text-gray-500 text-sm">
                Monitoring rute distribusi secara efektif
            </p>
        </div>
    
        <div class="">
            <button wire:click="$set('showModal', true)"
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                + Buat Rute
            </button>
            <a href="{{ route('distribution.road-route-assign') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
                <span>Assign Rute</span>
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    

    {{-- List Rute --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($distribution_routes as $item)
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-md transition">
    
                <div class="flex justify-between items-center mb-3">
                    <h3 class="font-semibold text-gray-800">
                        {{ $item->route_name }}
                    </h3>
    
                    <div class="flex gap-2 items-center">
                        @if ($item->is_active)
                            <span class="text-xs px-3 py-1 bg-green-100 text-green-700 rounded-full">
                                Aktif
                            </span>
                        @else
                            <span class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded-full">
                                Non Aktif
                            </span>
                        @endif
                        <button wire:click="delete_route({{ $item->id }})" class="bg-red-500 p-1 cursor-pointer rounded-md hover:bg-red-600 active:bg-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </div>
                </div>
    
                <div class="grid grid-cols-2 gap-3 text-sm text-gray-600">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-400">Sekolah</p>
                        <p class="text-lg font-bold">
                            {{ $item->schools_count }}
                        </p>
                    </div>
    
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-xs text-gray-400">Posyandu</p>
                        <p class="text-lg font-bold">
                            {{ $item->posyandus_count }}
                        </p>
                    </div>
                </div>
    
            </div>
        @endforeach
    </div>

    <livewire:buttons.button variant="primary">TEST</livewire:buttons.button>
    <livewire:buttons.button variant="outline">TEST</livewire:buttons.button>
    <livewire:buttons.button variant="filled">TEST</livewire:buttons.button>
    <livewire:buttons.button variant="danger">TEST</livewire:buttons.button>
    <livewire:buttons.button variant="ghost">TEST</livewire:buttons.button>
    <livewire:buttons.button variant="subtle">TEST</livewire:buttons.button>

</div>