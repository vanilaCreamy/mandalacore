<?php

use Livewire\Component;
use App\Models\Recipe;
use App\Models\Material;
use App\Models\RecipeMaterial;

new class extends Component
{
    public $breadcrumbs;

    public $recipe_modal = false;
    public $edit_id;

    public $name;

    // recipe materials state
    public $materials = [];
    public $material_id;
    public $qty_gram;

    protected function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Resep'],
        ];
    }

    public function getRecipesProperty()
    {
        return Recipe::latest()->get();
    }

    public function resetForm()
    {
        $this->reset(['name', 'edit_id', 'material_id', 'qty_gram', 'materials']);
        $this->recipe_modal = false;
    }

    public function openModal($id = null)
    {
        $this->resetForm();

        if ($id) {
            $recipe = Recipe::findOrFail($id);
            $this->edit_id = $recipe->id;
            $this->name = $recipe->name;
            $this->loadMaterials();
        }

        $this->recipe_modal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->edit_id) {
            Recipe::find($this->edit_id)->update([
                'name' => $this->name,
            ]);
        } else {
            $recipe = Recipe::create([
                'name' => $this->name,
            ]);

            $this->edit_id = $recipe->id;
        }

        $this->loadMaterials();
    }

    public function loadMaterials()
    {
        $this->materials = RecipeMaterial::with('material')
            ->where('recipe_id', $this->edit_id)
            ->get();
    }

    public function addMaterial()
    {
        $this->validate([
            'material_id' => 'required',
            'qty_gram' => 'required|numeric|min:0.001',
        ]);

        RecipeMaterial::create([
            'recipe_id' => $this->edit_id,
            'material_id' => $this->material_id,
            'qty_gram' => $this->qty_gram,
        ]);

        $this->reset(['material_id', 'qty_gram']);
        $this->loadMaterials();
    }

    public function deleteMaterial($id)
    {
        RecipeMaterial::find($id)?->delete();
        $this->loadMaterials();
    }
};
?>

<div>
    {{-- MODAL RESEP --}}
    <x-modal wire:model="recipe_modal"
             :title="$edit_id ? 'Edit Resep & Bahan' : 'Buat Resep'"
             @close="$wire.resetForm()"
             class="backdrop-blur">

        <x-form wire:submit.prevent="save">
            <x-input label="Nama Resep" wire:model="name" />

            <x-slot:actions>
                <x-button :label="$edit_id ? 'Simpan' : 'Buat'"
                          type="submit"
                          class="btn-primary"
                          spinner="save" />
                <x-button label="Tutup" wire:click="resetForm" />
            </x-slot:actions>
        </x-form>

        {{-- Jika sudah ada resep, tampilkan bahan --}}
        @if($edit_id)
            <div class="mt-6 border-t pt-4">

                <h3 class="font-semibold mb-2">Bahan Resep (per porsi SD)</h3>

                <table class="table-auto w-full text-sm mb-3">
                    <thead>
                        <tr>
                            <th class="text-left">Bahan</th>
                            <th class="text-left">Gram</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materials as $rm)
                            <tr>
                                <td>{{ $rm->material->name }}</td>
                                <td>{{ $rm->qty_gram }}</td>
                                <td>
                                    <x-button icon="o-trash"
                                              wire:click="deleteMaterial({{ $rm->id }})"
                                              class="btn-ghost btn-sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="flex gap-2">
                    <x-select
                        placeholder="Pilih bahan"
                        :options="Material::all()->map(fn ($item) => ['id' => $item->id, 'name' => $item->name])"
                        wire:model="material_id"
                    />

                    <x-input
                        placeholder="Gram"
                        type="number"
                        wire:model="qty_gram"
                    />

                    <x-button label="Tambah"
                              wire:click="addMaterial"
                              class="btn-primary btn-sm" />
                </div>

            </div>
        @endif
    </x-modal>

    {{-- HEADER --}}
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Resep" subtitle="Kelola resep dan bahan per porsi" separator>
        <x-slot:actions>
            <x-button label="Kembali"
                      icon="o-arrow-left"
                      link="{{ route('menu.index') }}"
                      class="btn-dash" />
            <x-button label="Buat Resep"
                      wire:click="openModal"
                      class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- LIST RESEP --}}
    @foreach($this->recipes as $recipe)
        <x-collapse separator>
            <x-slot:heading>
                <div class="flex justify-between items-center">
                    <span>{{ $recipe->name }}</span>
                </div>
            </x-slot:heading>

            <x-slot:content>
                <x-button icon="o-pencil" wire:click="openModal({{ $recipe->id }})" class="btn-ghost btn-sm" />
                <table class="table-auto w-full text-sm">
                    <thead>
                        <tr>
                            <th class="text-left">Bahan</th>
                            <th class="text-left">Gramasi</th>
                            <th class="text-left">Gram / Porsi SD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipe->recipe_materials as $rm)
                            <tr>
                                <td>{{ $rm->material->name }}</td>
                                <td>{{ $rm->qty_gram }}</td>
                                <td>{{ $rm->qty_gram / $rm->material->conversion }} {{ $rm->material->display_unit }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-slot:content>
        </x-collapse>
    @endforeach
</div>
