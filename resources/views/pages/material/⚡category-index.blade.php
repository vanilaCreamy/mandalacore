<?php

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\MaterialCategory;

new class extends Component
{
    public $breadcrumbs;
    public $category_modal;
    public $edit_mode = false;
    public $selected_categ;

    public $cat_name;
    public $cat_abbr;
    public $cat_description;

    public function mount()
    {
        $this->material_categories = MaterialCategory::all();

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Bahan Baku', 'link' => route('material.index')],
            ['label' => 'Kategori Bahan Baku'],
        ];
    }
    
    public function getMaterialCategoriesProperty()
    {
        return MaterialCategory::latest()->get();
    }

    public function rules()
    {
        $id = $this->selected_categ ?? 'NULL';

        return [
            'cat_name' => 'required|max:255|unique:material_categories,name,' . $id,
            'cat_abbr' => 'required|max:3|unique:material_categories,abbr,' . $id,
            'cat_description' => 'nullable',
        ];
    }

    public function OpenModal($id = null)
    {
        // RESET dulu supaya bersih
        $this->reset([
            'cat_name',
            'cat_abbr',
            'cat_description',
        ]);

        if ($id) {
            // MODE EDIT
            $cat = MaterialCategory::findOrFail($id);

            $this->edit_mode = true;
            $this->selected_categ = $id;

            $this->cat_name = $cat->name;
            $this->cat_abbr = $cat->abbr;
            $this->cat_description = $cat->description;
        } else {
            // MODE CREATE
            $this->edit_mode = false;
            $this->selected_categ = null;
        }

        $this->category_modal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->edit_mode) {
            MaterialCategory::find($this->selected_categ)->update([
                'name' => $this->cat_name,
                'abbr' => $this->cat_abbr,
                'description' => $this->cat_description,
            ]);
        } else {
            MaterialCategory::create([
                'name' => $this->cat_name,
                'abbr' => $this->cat_abbr,
                'description' => $this->cat_description,
            ]);
        }

        $this->reset([
            'cat_name',
            'cat_abbr',
            'cat_description',
        ]);

        $this->dispatch('category-created');

        $this->edit_mode = false;
        $this->selected_categ = null;
        $this->category_modal = false;
    }
};
?>

<div>
    <x-modal wire:model="category_modal" :title="$edit_mode ? 'Edit Kategori' : 'Buat Kategori Baru'" class="backdrop-blur">
        <x-form wire:submit.prevent="save">
            <x-input label="Nama" wire:model="cat_name" />
            <x-input label="Singkatan" wire:model="cat_abbr" />
            <x-textarea label="Biography" wire:model="cat_description" placeholder=""  rows="3" />
    
            <x-slot:actions>
                <x-button :label="$edit_mode ? 'Perbarui' : 'Tambah'" type="submit" class="btn-primary" spinner="save" />
                <x-button label="Cancel" @click="$wire.category_modal = false" />
            </x-slot:actions>
        </x-form>
    </x-modal>
    
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Kategori Bahan Baku" subtitle="..." separator>
        <x-slot:actions>
            <x-button link="{{ route('material.index') }}" icon="o-arrow-left" label="Kembali" class="btn-dash" />
            <x-button @click="$wire.OpenModal()" icon="o-plus" label="Tambah" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    @foreach ($this->materialCategories as $category)
        <x-list-item :item="$category">
            <x-slot:avatar>
                <x-badge value="{{ $category->abbr }}" class="badge-primary badge-soft" />
            </x-slot:avatar>
            <x-slot:value>
                {{ $category->name }}
            </x-slot:value>
            <x-slot:sub-value>
                {{ $category->description }}
            </x-slot:sub-value>
            <x-slot:actions>
                <x-button icon="o-pencil" class="btn-sm" wire:click="OpenModal({{ $category->id }})" spinner />
            </x-slot:actions>
        </x-list-item>
    @endforeach
</div>