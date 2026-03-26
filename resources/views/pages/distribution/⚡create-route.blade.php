<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\DistributionRoute;

new class extends Component
{
    use WithPagination;

    public $breadcrumbs;
    public $distribution_route_modal = false;

    #[Validate('required|min:3')]
    public $route_name;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Manajemen Distribusi', 'link' => route('distribution.index')],
            ['label' => 'Rute Distribusi'],
        ];
    }

    public function getRoutesProperty()
    {
        return DistributionRoute::latest()->paginate(10);
    }

    public function save()
    {
        $this->validate();

        DistributionRoute::create([
            'route_name' => $this->route_name,
            'is_active' => true,
        ]);

        $this->reset('route_name');
        $this->distribution_route_modal = false;

        $this->dispatch('notify', type: 'success', message: 'Rute berhasil dibuat');
    }
};
?>

<div class="space-y-6">

    {{-- MODAL --}}
    <x-modal wire:model="distribution_route_modal" title="Buat Rute Baru">
        <x-form no-separator>

            <x-input
                label="Nama Rute"
                wire:model="route_name"
            />

            <x-slot:actions>
                <div class="flex justify-between w-full">

                    <x-button
                        label="Batal"
                        class="btn-ghost"
                        @click="$wire.distribution_route_modal = false"
                    />

                    <x-button
                        label="Simpan"
                        class="btn-primary"
                        wire:click="save"
                        spinner
                    />

                </div>
            </x-slot:actions>

        </x-form>
    </x-modal>


    {{-- BREADCRUMBS --}}
    <x-breadcrumbs :items="$breadcrumbs" />


    {{-- HEADER --}}
    <x-header
        title="Rute Distribusi"
        subtitle="Optimisasi rute pengiriman"
        separator
    >
        <x-slot:actions>

            <x-button
                link="{{ route('distribution.index') }}"
                label="Menu Distribusi"
            />

            <x-button
                @click="$wire.distribution_route_modal = true"
                icon="o-plus"
                label="Tambah Rute"
                class="btn-primary"
            />

        </x-slot:actions>
    </x-header>


    {{-- ROUTE LIST --}}
    <x-card>

        <div class="">

            @foreach ($this->routes as $route)

                <div class="flex items-center justify-between border rounded-lg p-2">

                    <div>
                        <div class="font-semibold">
                            {{ $route->route_name }}
                        </div>

                        <div class="text-sm text-gray-500">
                            Route ID : {{ $route->id }}
                        </div>
                    </div>

                    <div class="flex items-center gap-2">

                        @if ($route->is_active)
                            <x-badge value="Aktif" class="badge-success" />
                        @else
                            <x-badge value="Nonaktif" class="badge-ghost" />
                        @endif

                        <x-button
                            icon="o-eye"
                            class="btn-sm btn-ghost"
                        />

                        <x-button
                            icon="o-pencil"
                            class="btn-sm btn-ghost"
                        />

                    </div>

                </div>

            @endforeach

        </div>

        <div class="mt-4">
            {{ $this->routes->links() }}
        </div>

    </x-card>

</div>
