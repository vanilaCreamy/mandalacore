<?php

use Livewire\Component;
use App\Models\Vendor;
use App\Models\Material;

new class extends Component
{
    public $breadcrumbs;

    public $vendor_modal = false;
    public $vendor_material_modal = false;

    public $edit_id = null;
    public $selected_vendor_id = null;

    public $name;
    public $contact_person;
    public $phone;
    public $address;
    public $bank_name;
    public $bank_account_number;
    public $is_active = true;
    public $note;

    // Material Management
    public $allMaterials = [];
    public $vendorMaterialIds = [];

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Suplier']
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Computed
    |--------------------------------------------------------------------------
    */

    public function getVendorsProperty()
    {
        return Vendor::with('materials')
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Vendor CRUD
    |--------------------------------------------------------------------------
    */

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ];
    }

    public function create()
    {
        $this->resetForm();
        $this->vendor_modal = true;
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);

        $this->edit_id = $vendor->id;
        $this->name = $vendor->name;
        $this->contact_person = $vendor->contact_person;
        $this->phone = $vendor->phone;
        $this->address = $vendor->address;
        $this->bank_name = $vendor->bank_name;
        $this->bank_account_number = $vendor->bank_account_number;
        $this->note = $vendor->note;
        $this->is_active = $vendor->is_active;

        $this->vendor_modal = true;
    }

    public function save()
    {
        $this->validate();

        Vendor::updateOrCreate(
            ['id' => $this->edit_id],
            [
                'name' => $this->name,
                'contact_person' => $this->contact_person,
                'phone' => $this->phone,
                'address' => $this->address,
                'bank_name' => $this->bank_name,
                'bank_account_number' => $this->bank_account_number,
                'note' => $this->note,
                'is_active' => $this->is_active ?? true,
            ]
        );

        $this->resetForm();
        $this->vendor_modal = false;
    }

    public function toggleActivation($id)
    {
        $vendor = Vendor::findOrFail($id);

        $vendor->update([
            'is_active' => !$vendor->is_active
        ]);
    }

    public function resetForm()
    {
        $this->reset([
            'edit_id',
            'name',
            'contact_person',
            'phone',
            'address',
            'bank_name',
            'bank_account_number',
            'note',
            'is_active',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Material Management
    |--------------------------------------------------------------------------
    */

    public function openMaterialModal($vendorId)
    {
        $this->selected_vendor_id = $vendorId;

        $vendor = Vendor::with('materials')->findOrFail($vendorId);

        $this->vendorMaterialIds = $vendor->materials
            ->pluck('id')
            ->toArray();

        $this->allMaterials = Material::orderBy('name')->get();

        $this->vendor_material_modal = true;
    }

    public function addMaterial($materialId)
    {
        Vendor::find($this->selected_vendor_id)
            ->materials()
            ->syncWithoutDetaching([$materialId]);

        $this->vendorMaterialIds[] = $materialId;
    }

    public function removeMaterial($materialId)
    {
        Vendor::find($this->selected_vendor_id)
            ->materials()
            ->detach($materialId);

        $this->vendorMaterialIds = array_values(
            array_diff($this->vendorMaterialIds, [$materialId])
        );
    }
};
?>
<div>

    {{-- MODAL VENDOR --}}
    <x-modal wire:model="vendor_modal" 
             :title="$edit_id ? 'Edit Vendor' : 'Buat Vendor'" 
             class="backdrop-blur">

        <x-form wire:submit.prevent="save">

            <x-input label="Nama" wire:model="name" />
            <x-input label="Narahubung" wire:model="contact_person" />
            <x-input label="No Telepon" wire:model="phone" />
            <x-textarea label="Alamat" wire:model="address" rows="3" />

            <div class="grid grid-cols-6 gap-2">
                <span class="col-span-1">
                    <x-input label="Bank" wire:model="bank_name" />
                </span>
                <span class="col-span-5">
                    <x-input label="Nomor Rekening" wire:model="bank_account_number" />
                </span>
            </div>

            <x-slot:actions>
                <x-button type="submit"
                          :label="$edit_id ? 'Update' : 'Tambah'"
                          class="btn-primary" />
                <x-button label="Cancel" wire:click="resetForm" />
            </x-slot:actions>

        </x-form>
    </x-modal>


    {{-- MODAL MATERIAL --}}
    <x-modal wire:model="vendor_material_modal"
             title="Kelola Supply Material"
             class="backdrop-blur">

        <div class="max-h-[400px] overflow-y-auto space-y-2">

            @foreach ($allMaterials as $material)
                <div class="flex justify-between items-center border p-2 rounded">

                    <span>{{ $material->name }}</span>

                    @if (in_array($material->id, $vendorMaterialIds))
                        <x-button
                            label="Remove"
                            class="btn-error btn-sm"
                            wire:click="removeMaterial({{ $material->id }})" />
                    @else
                        <x-button
                            label="Add"
                            class="btn-primary btn-sm"
                            wire:click="addMaterial({{ $material->id }})" />
                    @endif

                </div>
            @endforeach

        </div>

    </x-modal>

    <x-breadcrumbs :items="$breadcrumbs" />

    {{-- HEADER --}}
    <x-header title="Suplier" separator>
        <x-slot:actions>
            <x-button wire:click="create"
                      icon="o-plus"
                      class="btn-primary" />
        </x-slot:actions>
    </x-header>


    {{-- LIST VENDOR --}}
    @foreach ($this->vendors as $vendor)

        <x-list-item :item="$vendor">

            <x-slot:value>
                {{ $vendor->name }}

                @if ($vendor->is_active)
                    <x-badge value="Aktif"
                             class="badge-success badge-soft" />
                @else
                    <x-badge value="Non-Aktif"
                             class="badge-error badge-soft" />
                @endif
            </x-slot:value>


            <x-slot:sub-value>

                {{ $vendor->address }}

                <div class="grid grid-cols-1 md:grid-cols-2 border-b pb-2 mt-2">

                    <div class="flex flex-col gap-2">
                        <span>{{ $vendor->contact_person }}</span>
                        <span>{{ $vendor->phone }}</span>
                    </div>

                    <div>
                        ({{ $vendor->bank_name }})
                        - {{ $vendor->bank_account_number }}
                    </div>

                </div>

                <div class="mt-2 space-x-1">
                    @foreach ($vendor->materials as $material)
                        <x-badge value="{{ $material->name }}" class="badge-soft badge-xs" />
                    @endforeach
                </div>

            </x-slot:sub-value>


            <x-slot:actions>
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button icon="o-ellipsis-vertical"
                                  class="btn-circle" />
                    </x-slot:trigger>

                    <x-menu-item
                        title="Kelola Material"
                        icon="o-plus"
                        wire:click="openMaterialModal({{ $vendor->id }})" />

                    <x-menu-item
                        title="Edit"
                        icon="o-pencil"
                        wire:click="edit({{ $vendor->id }})" />

                    <x-menu-item
                        title="Toggle"
                        :icon="$vendor->is_active ? 'o-x-circle' : 'o-check-circle'"
                        wire:click="toggleActivation({{ $vendor->id }})" />
                </x-dropdown>
            </x-slot:actions>

        </x-list-item>

    @endforeach

</div>
