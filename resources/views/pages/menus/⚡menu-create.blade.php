<?php

use Livewire\Component;
use App\Models\Material;

new class extends Component
{
    public $breadcrumbs;

    public $materials;

    public $menu_name;
    public $menu_description;

    public $items = [];

    public function mount()
    {
        $this->materials = Material::all()
            ->map(fn($item) => [
                'id' => $item->id,
                'name' => $item->name
            ]);

        // bikin 15 baris kosong
        for ($i = 0; $i < 15; $i++) {
            $this->items[] = [
                'material_id' => null,
                'gramasi' => null,
                'hasil' => null,
                'harga' => null,
                'total' => null,
            ];
        }

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Menu', 'link' => route('menu.index')],
            ['label' => 'Buat Menu']
        ];
    }

    public function updatedItems($value, $key)
    {
        [$loop->index, $field] = explode('.', $key);

        if (in_array($field, ['gramasi', 'harga'])) {
            $gramasi = $this->items[$loop->index]['gramasi'] ?? 0;
            $harga   = $this->items[$loop->index]['harga'] ?? 0;

            $this->items[$loop->index]['total'] = $gramasi * $harga;
        }
    }

    public function getGrandTotalProperty()
    {
        return collect($this->items)->sum('total');
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Menu" subtitle="..." separator>
        <x-slot:actions>
            <x-button label="Kembali" link="{{ route('menu.index') }}" class="btn-dash" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit="save">
        <x-input label="Nama Menu" wire:model="menu_name" />
        <x-textarea label="Deskripsi" wire:model="menu_description" placeholder="Deskripsi menu" rows="3" />
    
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Buat" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>

        {{-- Menu Items --}}
        <div>
        @foreach ($this->items as $item)
            <div class="grid grid-cols-4 items-center gap-2">
                <x-select label="Nama Bahan" wire:model="items.{{ $loop->index }}.material_id" placeholder="pilih bahan" :options="$this->materials" icon="o-user" />
                <div class="grid grid-cols-2 items-center gap-1">
                    <x-input label="Gramasi" wire:model="items.{{ $loop->index }}.gramasi" type="number" />
                    <x-input label="Hasil {}" wire:model="items.{{ $loop->index }}.hasil" type="number" />
                </div>
                <x-input label="Harga" wire:model="items.{{ $loop->index }}.harga" prefix="Rp" locale="id-ID" money />
                <x-input label="Total Per Item" wire:model="items.{{ $loop->index }}.total" prefix="Rp" locale="id-ID" money />
            </div>  
        @endforeach
        </div>

        <div class="grid grid-cols-4">
            <div class="col-span-3"></div>
            <div class="flex flex-col gap-4">
                <x-input label="Total" prefix="Rp" locale="id-ID" money inline />
                <x-input label="Anggaran" prefix="Rp" locale="id-ID" money inline />
                <x-input label="d" prefix="Rp" locale="id-ID" hint="Surplus/Defisit" money inline />
            </div>
        </div>
    </x-form>
</div>