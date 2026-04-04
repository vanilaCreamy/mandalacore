<?php

use Livewire\Component;
use App\Models\Posyandu;
use App\Enums\PosyanduLevel;

new class extends Component
{
    public $breadcrumbs = [];

    public $posyandu;

    public $posyandu_code;
    public $posyandu_name;
    public $address;

    public $cadre_name;
    public $cadre_phone_number;
    public $cadre_email;

    public function mount($posyandu_id)
    {
        $this->posyandu = Posyandu::findOrFail($posyandu_id);
        $this->posyandu_code = $this->posyandu->posyandu_code;
        $this->posyandu_name = $this->posyandu->posyandu_name;
        $this->address = $this->posyandu->address;
        $this->cadre_name = $this->posyandu->cadre_name;
        $this->cadre_phone_number = $this->posyandu->cadre_phone_number;
        $this->cadre_email = $this->posyandu->cadre_email;


        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Posyandu', 'link' => route('posyandu.index')],
            ['label' => $this->posyandu->posyandu_name, 'link' => route('posyandu.view', $this->posyandu->id)],
            ['label' => 'Perbarui'],
        ];
    }

    protected function rules()
    {
        return [
            'posyandu_code' => 'required|string|max:50',
            'posyandu_name' => 'required|string|max:255',
            'address' => 'required|string',
            'cadre_name' => 'required|string|max:255',
            'cadre_phone_number' => 'nullable|string|max:20',
            'cadre_email' => 'nullable|email',
        ];
    }

        public function save()
        {
            $this->validate();

            $this->posyandu->update([
                'posyandu_code' => $this->posyandu_code,
                'posyandu_name' => $this->posyandu_name,
                'address' => $this->address,
                'cadre_name' => $this->cadre_name,
                'cadre_phone_number' => $this->cadre_phone_number,
                'cadre_email' => $this->cadre_email,
            ]);

            return redirect()->route('posyandu.view', ['posyandu_id' => $this->posyandu->id])
                ->with('success', 'Posyandu berhasil ditambahkan.');
        }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Pembaruan Data Posyandu" subtitle="Edit data posyandu" separator>
        <x-slot:actions>
            <x-button link="{{ route('posyandu.view', $this->posyandu->id) }}" route="posyandu.view" icon="o-arrow-left" label="Kembali" class="btn-dash" />
            <x-button link="{{ route('posyandu.index') }}" route="posyandu.index" label="Daftar Sekolah" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="save">
        
        {{-- INFORMASI SEKOLAH --}}
        <h2 class="font-semibold border-b pb-2">Informasi Sekolah</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input label="Kode Sekolah" wire:model="posyandu_code" />
            <x-input label="Nama Sekolah" wire:model="posyandu_name" />
            <span class="md:col-span-2">
                <x-textarea label="Alamat" wire:model="address" rows="4" />
            </span>
        </div>
        
        {{-- INFORMASI KADER --}}
        <h2 class="font-semibold border-b pb-2">Informasi Kader</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input label="Nama Kader" wire:model="cadre_name" />
            <x-input label="No HP Kader" wire:model="cadre_phone_number" />
            <x-input label="Email Kader" wire:model="cadre_email" />
        </div>
        
        <x-slot:actions>
            <x-button label="Simpan Perubahan" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
