<?php

use Livewire\Component;
use App\Models\Menu;

new class extends Component
{
    public $breadcrumbs;
    public $poMaterials = [];
    public $showPoModal = false;

    public function mount()
    {

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Menu']
        ];
    }

    public function getMenusProperty()
    {
        return Menu::with([
            'items.recipe',
            'portions.portion_base'
        ])
        ->orderByDesc('date')
        ->get();
    }

    public function showPo($menuId)
    {
        $menu = Menu::with([
            'items.recipe.recipe_materials.material',
            'portions.portion_base'
        ])->findOrFail($menuId);

        $this->poMaterials = $menu->generateMaterialNeeds();
        $this->showPoModal = true;
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Menu" subtitle="Daftar menu harian dapur" separator>
        <x-slot:actions>
            <x-button label="Resep" link="{{ route('recipe.index') }}" />
            <x-button label="Buat Menu" link="{{ route('menu.create') }}" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <x-card>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Menu</th>
                        <th>Resep</th>
                        <th>PK / PB</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->menus as $menu)
                        <tr>
                            {{-- Tanggal --}}
                            <td>
                                {{ \Carbon\Carbon::parse($menu->date)->format('d M Y') }}
                            </td>

                            {{-- Nama --}}
                            <td class="font-semibold">
                                {{ $menu->name }}
                            </td>

                            {{-- Resep --}}
                            <td>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($menu->items as $item)
                                        <x-badge :value="$item->recipe->name" class="badge-dash" />
                                    @endforeach
                                </div>
                            </td>

                            {{-- PK / PB --}}
                            <td>
                                <div class="flex gap-2">
                                    @foreach($menu->portions as $portion)
                                        <x-badge 
                                            :value="$portion->portion_base->code . ': ' . $portion->total_portions" 
                                            class="badge-outline" />
                                    @endforeach
                                </div>
                            </td>

                            {{-- Action --}}
                            <td>
                                <x-dropdown>
                                    <x-slot:trigger>
                                        <x-button icon="o-ellipsis-vertical" class="btn-circle" />
                                    </x-slot:trigger>
                                    <x-button icon="o-pencil" label="Edit" class="btn-sm" link="{{ route('menu.edit', $menu->id) }}"/>
                                    <x-button icon="o-document-text" label="Draft PO" class="btn-sm" wire:click="showPo({{ $menu->id }})"/>
                                </x-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <x-modal wire:model="showPoModal" title="Draft Purchase Order" separator>
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Bahan</th>
                                <th>Total Gram</th>
                                <th>Total Beli</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($poMaterials as $mat)
                                <tr>
                                    <td>{{ $mat['material_name'] }}</td>
                                    <td>{{ number_format($mat['total_gram'], 0) }} g</td>
                                    <td class="font-semibold">
                                        {{ $mat['total_display'] }} {{ $mat['display_unit'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            
                {{-- <x-slot:actions>
                    <x-button label="Tutup" @click="$wire.showPoModal = false" />
                    <x-button label="Buat PO" class="btn-primary" />
                </x-slot:actions> --}}
            </x-modal>
            
            
        </div>
    </x-card>
</div>
