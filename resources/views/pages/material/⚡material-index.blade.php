<?php

use Livewire\Component;
use App\Models\Material;
use App\Models\MaterialCategory;

new class extends Component
{
    public $breadcrumbs;

    public $material_modal;

    public $edit_id = null;

    public $search = '';
    public $selected_categories = null;

    public $categories;

    public $material_category_id;
    public $name;
    public $description;
    public $display_unit;
    public $conversion;


    public function mount()
    {
        $this->getMaterialsProperty();
        
        $this->categories = MaterialCategory::all()
            ->map(fn ($value) => [
                'id'=> $value->id,
                'name' => $value->name
            ]);

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Bahan Baku']
        ];
    }

    public function rules()
    {
        return [
            'material_category_id' => 'required',
            'name' => 'required|unique:materials,name,' . $this->edit_id,
            'description' => 'nullable',
            'display_unit' => 'required',
            'conversion' => 'required|numeric',
        ];
    }

    public function getMaterialsProperty()
    {
        return Material::with('category')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%');
            })
            ->when($this->selected_categories, function ($q) {
                $q->where('material_category_id', $this->selected_categories);
            })
            ->orderBy('material_category_id')
            ->get();
    }

    public function resetForm()
    {
        $this->reset([
            'edit_id',
            'material_category_id',
            'name',
            'description',
            'display_unit',
            'conversion',
            'material_modal',
        ]);
    }

    public function save()
    {
        $this->validate();

        Material::updateOrCreate(
            ['id' => $this->edit_id],
            [
                'material_category_id' => $this->material_category_id,
                'name' => $this->name,
                'description' => $this->description,
                'display_unit' => $this->display_unit,
                'conversion' => $this->conversion,
            ]
        );

        $this->resetForm();
    }

    public function edit($id)
    {
        $material = Material::findOrFail($id);

        $this->edit_id = $id;
        $this->material_category_id = $material->material_category_id;
        $this->name = $material->name;
        $this->description = $material->description;
        $this->display_unit = $material->display_unit;
        $this->conversion = $material->conversion;

        $this->material_modal = true;
    }
};
?>


<div>
    <x-modal wire:model="material_modal" :title="$edit_id ? 'Edit Bahan Baku' : 'Buat Bahan Baku'" @close="$wire.resetForm()" class="backdrop-blur">
        <x-form wire:submit.prevent="save">
            <x-select
                label="Kategori"
                wire:model="material_category_id"
                :options="$this->categories"
                placeholder="Pilih Kategori"
            />
            <x-input label="Nama" wire:model="name" />
            <div class="grid grid-cols-6 gap-2">
                <span class="col-span-2"><x-input label="Unit Satuan" wire:model="display_unit" /></span>
                <span class="col-span-4"><x-input label="Konversi" wire:model="conversion" /></span>
            </div>
            <x-textarea label="Deskripsi" wire:model="description" placeholder=""  rows="3" />
    
            <x-slot:actions>
                <x-button :label="$edit_id ? 'Update' : 'Tambah'" type="submit" class="btn-primary" spinner="save" />
                <x-button label="Cancel" wire:click="resetForm" />
            </x-slot:actions>
        </x-form>
    </x-modal>
    
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Bahan Baku" subtitle="..." separator>
        <x-slot:actions>
            <x-button link="{{ route('category.index') }}" label="Kategori" />
            <x-button @click="$wire.material_modal = true" icon="o-plus" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- Filter & Search Section --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6">

        <div class="grid grid-cols-6 gap-4 items-end">

            {{-- Search --}}
            <span class="col-span-6 md:col-span-4">
                <x-input label="Cari Sekolah" icon="o-magnifying-glass" placeholder="Ketik nama bahan" wire:model.live.debounce.500ms="search"  clearable>
                    <x-slot:append>
                        {{-- Add `join-item` to all appended elements --}}
                        <x-button icon="o-magnifying-glass" class="join-item btn-primary"  />
                    </x-slot:append>
                </x-input>
                
            </span>

            {{-- Filter Level --}}
            <span class="col-span-6 md:col-span-2">
                <x-select
                    label="Filter Kategori"
                    wire:model.live="selected_categories"
                    :options="$this->categories"
                    placeholder="Semua Kategori"
                />
            </span>

        </div>

    </div>
    
    <div class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-2">

        @forelse ($this->materials as $material)
        
        <x-list-item :item="$material"
            class="bg-slate-100 rounded-2x rounded-lg hover:shadow-md transition-all duration-200 p-4">
        
            {{-- MAIN INFO --}}
            <x-slot:value>
                <div class="space-y-1 border-b border-slate-200">
        
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $material->id }}/{{ $material->category->abbr }}
                        </span>
        
                        <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
        
                        <span class="text-xs text-white bg-blue-500 rounded-xl p-1">
                            {{ $material->category->name }}
                        </span>
                    </div>
        
                    <h3 class="text-lg font-semibold text-slate-800 leading-tight">
                        {{ $material->name }}
                    </h3>
        
                </div>
            </x-slot:value>
        
            {{-- STATS + PIC --}}
            <x-slot:sub-value>
                <div class="flex flex-col md:flex-row md:items-center gap-6 mt-3">
        
                    {{-- STAT CARD --}}
                    <div class="flex gap-4">
        
                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                Stok
                            </div>
                            <div class="text-lg font-semibold text-primary">
                                0
                            </div>
                        </div>
        
                        {{-- <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                PB
                            </div>
                            <div class="text-lg font-semibold text-secondary">
                                {{ $bigFinal }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                TP / @if ($big != 0) PB @else PK @endif
                            </div>
                            <div class="text-lg font-semibold text-secondary">
                                {{ $tambahan }}
                            </div>
                        </div> --}}
        
                    </div>
        
                    {{-- PIC INFO --}}
                    {{-- <div class="text-xs text-right md:text-left">
                        <div class="text-slate-400 uppercase tracking-wide text-[10px]">
                            PIC
                        </div>
                        <div class="font-medium text-slate-700">
                            {{ $material->pic_name }}
                        </div>
                        <div class="text-slate-400">
                            {{ $material->pic_phone_number }}
                        </div>
                    </div> --}}
        
                </div>
            </x-slot:sub-value>
        
            {{-- ACTIONS --}}
            <x-slot:actions>
                <x-dropdown>
                    
                    <x-slot:trigger>
                        <x-button 
                            icon="o-ellipsis-vertical" 
                            class="btn-circle btn-sm btn-ghost" 
                        />
                    </x-slot:trigger>

                    <x-menu-item 
                        title="Detail"
                        icon="o-eye"
                        {{-- link="{{ route('material.view', ['school_id' => $material->id]) }}" --}}
                    />

                    <x-menu-item 
                        title="Edit"
                        icon="o-pencil"
                        wire:click="edit({{ $material->id }})"
                    />

                </x-dropdown>
            </x-slot:actions>

        
        </x-list-item>
        
        @empty
        
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 text-center py-12 text-slate-400">
            Belum ada data bahan baku
        </div>
        
        @endforelse
        
    </div>
    
    
</div>