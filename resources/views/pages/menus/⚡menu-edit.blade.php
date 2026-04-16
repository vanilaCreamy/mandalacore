<?php

use Livewire\Component;
use App\Models\Recipe;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\MenuPortion;
use App\Models\MenuExtraMaterial;
use App\Models\PortionBase;
use App\Models\Material;

new class extends Component
{
    public $breadcrumbs;

    public Menu $menu;

    public $name;
    public $date;

    public $selectedRecipes = [];
    public $portions = [];
    public $extraMaterials = [];

    public $extra_material_id;
    public $extra_qty_pk;
    public $extra_qty_pb;

    public function mount(Menu $menu)
    {
        $this->menu = $menu;

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Menu', 'link' => route('menu.index')],
            ['label' => 'Edit Menu']
        ];

        // === LOAD BASIC ===
        $this->name = $menu->name;
        $this->date = $menu->date;

        // === LOAD RECIPES ===
        $this->selectedRecipes = $menu->items()
            ->pluck('recipe_id')
            ->toArray();

        // === INIT PORTIONS ===
        foreach (PortionBase::all() as $base) {
            $this->portions[$base->id] = 0;
        }

        foreach ($menu->portions as $portion) {
            $this->portions[$portion->portion_base_id] = $portion->total_portions;
        }

        // === LOAD EXTRA MATERIALS ===
        $pk = PortionBase::where('code', 'PK')->first();
        $pb = PortionBase::where('code', 'PB')->first();

        foreach ($menu->extraMaterials as $extra) {

            $index = collect($this->extraMaterials)
                ->search(fn($e) => $e['material_id'] == $extra->material_id);

            if ($index === false) {
                $this->extraMaterials[] = [
                    'material_id' => $extra->material_id,
                    'material_name' => $extra->material->name,
                    'qty_pk' => 0,
                    'qty_pb' => 0,
                ];
                $index = count($this->extraMaterials) - 1;
            }

            if ($extra->portion_base_id == $pk->id) {
                $this->extraMaterials[$index]['qty_pk'] = $extra->qty_gram;
            }

            if ($extra->portion_base_id == $pb->id) {
                $this->extraMaterials[$index]['qty_pb'] = $extra->qty_gram;
            }
        }
    }

    public function getRecipesProperty()
    {
        return Recipe::orderBy('name')->get();
    }

    public function getPortionBasesProperty()
    {
        return PortionBase::all();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'date' => 'required|date',
            'selectedRecipes' => 'required|array|min:1',
        ]);

        // === UPDATE MENU ===
        $this->menu->update([
            'name' => $this->name,
            'date' => $this->date,
        ]);

        // ❗ DELETE ALL RELATIONS FIRST
        $this->menu->items()->delete();
        $this->menu->portions()->delete();
        $this->menu->extraMaterials()->delete();

        // === INSERT BACK ===
        foreach ($this->selectedRecipes as $recipeId) {
            MenuItem::create([
                'menu_id' => $this->menu->id,
                'recipe_id' => (int) $recipeId,
            ]);
        }

        foreach ($this->portions as $portionBaseId => $total) {
            if ((int)$total > 0) {
                MenuPortion::create([
                    'menu_id' => $this->menu->id,
                    'portion_base_id' => (int) $portionBaseId,
                    'total_portions' => (int)$total,
                ]);
            }
        }

        $pk = PortionBase::where('code', 'PK')->first();
        $pb = PortionBase::where('code', 'PB')->first();

        foreach ($this->extraMaterials as $extra) {

            if ($extra['qty_pk'] > 0) {
                MenuExtraMaterial::create([
                    'menu_id' => $this->menu->id,
                    'material_id' => $extra['material_id'],
                    'portion_base_id' => $pk->id,
                    'qty_gram' => $extra['qty_pk'],
                ]);
            }

            if ($extra['qty_pb'] > 0) {
                MenuExtraMaterial::create([
                    'menu_id' => $this->menu->id,
                    'material_id' => $extra['material_id'],
                    'portion_base_id' => $pb->id,
                    'qty_gram' => $extra['qty_pb'],
                ]);
            }
        }

        return redirect()->route('menu.index');
    }

    public function addExtraMaterial()
    {
        $material = Material::find($this->extra_material_id);

        $this->extraMaterials[] = [
            'material_id' => $material->id,
            'material_name' => $material->name,
            'qty_pk' => $this->extra_qty_pk ?? 0,
            'qty_pb' => $this->extra_qty_pb ?? 0,
        ];

        $this->reset(['extra_material_id', 'extra_qty_pk', 'extra_qty_pb']);
    }

    public function removeExtraMaterial($index)
    {
        unset($this->extraMaterials[$index]);
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Buat Menu Baru" subtitle="Pilih resep dan tentukan jumlah PK / PB" separator>
        <x-slot:actions>
            <x-button label="Kembali" link="{{ route('menu.index') }}" class="btn-dash" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="save" class="space-y-6">

        {{-- Informasi Menu --}}
        <x-card title="Informasi Menu" separator>
            <div class="grid grid-cols-2 gap-4">
                <x-input label="Nama Menu" wire:model="name" />
                <x-input type="date" label="Tanggal" wire:model="date" />
            </div>
        </x-card>

        {{-- Pilih Resep --}}
        <x-card title="Resep di Menu Ini" subtitle="Centang resep yang akan dimasak" separator>
            <div class="grid grid-cols-3 gap-3">
                @foreach($this->recipes as $recipe)
                    <x-checkbox 
                        :label="$recipe->name"
                        :value="$recipe->id"
                        wire:model="selectedRecipes" />
                @endforeach
            </div>
        </x-card>

        {{-- Jumlah Porsi --}}
        <x-card title="Jumlah Anak Dilayani" subtitle="Isi jumlah PK dan PB" separator>
            <div class="grid grid-cols-2 gap-4">
                @foreach($this->portionBases as $base)
                    <x-input
                        type="number"
                        min="0"
                        :label="$base->name"
                        wire:model="portions.{{ $base->id }}"
                    />
                @endforeach
            </div>
        </x-card>

        <div class="mt-6 border-t pt-4">
            <h3 class="font-semibold mb-2">Buah / Tambahan (di luar resep)</h3>
        
            <div class="flex gap-2 mb-3">
                <x-select
                    placeholder="Pilih bahan"
                    :options="\App\Models\Material::all()->map(fn($m) => ['id'=>$m->id,'name'=>$m->name])"
                    wire:model="extra_material_id"
                />
        
                <x-input type="number" placeholder="Gram PK" wire:model="extra_qty_pk" />
                <x-input type="number" placeholder="Gram PB" wire:model="extra_qty_pb" />
        
                <x-button label="Tambah"
                          wire:click="addExtraMaterial"
                          class="btn-primary btn-sm" />
            </div>
        
            <table class="table-auto w-full text-sm">
                <thead>
                    <tr>
                        <th>Bahan</th>
                        <th>PK (g)</th>
                        <th>PB (g)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($extraMaterials as $i => $extra)
                        <tr>
                            <td>{{ $extra['material_name'] }}</td>
                            <td>{{ $extra['qty_pk'] }}</td>
                            <td>{{ $extra['qty_pb'] }}</td>
                            <td>
                                <x-button icon="o-trash"
                                          wire:click="removeExtraMaterial({{ $i }})"
                                          class="btn-ghost btn-sm" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

        <x-slot:actions>
            <x-button type="submit" label="Simpan Menu" class="btn-primary" />
        </x-slot:actions>
    </x-form>
</div>
