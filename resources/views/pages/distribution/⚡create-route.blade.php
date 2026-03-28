<?php

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;
use App\Models\DistributionRoute;
use App\Models\Posyandu;
use App\Models\School;

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

    public function toggleStatus($id)
    {
        $route = DistributionRoute::findOrFail($id);
        $route->is_active = ! $route->is_active;
        $route->save();

        $this->dispatch('notify',
            type: 'success',
            message: 'Status rute diperbarui'
        );
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
                icon="o-arrow-left"
                label="Kembali"
                class="btn-dash"
                link="{{ route('distribution.index') }}"
            />

            <x-button
                icon="o-map"
                label="Assign Titik Rute"
                link="{{ route('distribution.route-assign') }}"
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

                <div class="flex items-center justify-between border rounded-lg p-2 mb-2">

                    <div>
                        <div class="font-semibold">
                            {{ $route->route_name }}
                        </div>

                        <div class="text-sm text-gray-500">
                            Route ID : {{ $route->id }}
                        </div>

                    </div>

                    <div class="text-sm text-gray-500">
                        {{ $route->posyandus()->count() + $route->schools()->count() }} titik kirim
                    </div>

                    <div class="flex items-center gap-2">
                        <x-button
                            :icon="$route->is_active ? 'o-lock-open' : 'o-lock-closed'"
                            :label="$route->is_active ? 'Aktif' : 'Nonaktif'"
                            :class="$route->is_active ? 'btn-sm btn-primary btn-ghost' : 'btn-sm btn-secondary btn-ghost'"
                            wire:click="toggleStatus({{ $route->id }})"
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
