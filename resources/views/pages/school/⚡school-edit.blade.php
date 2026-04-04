<?php

use Livewire\Component;
use App\Models\School;
use App\Enums\SchoolLevel;

new class extends Component
{
    public $breadcrumbs = [];

    public $school;

    public $school_code;
    public $school_name;
    public $address;
    public $school_level;

    public $pic_name;
    public $pic_position;
    public $pic_phone_number;
    public $pic_email;

    public $hm_name;
    public $hm_phone_number;
    public $hm_email;

    public function mount($school_id)
    {
        $this->school = School::findOrFail($school_id);
        $this->school_code = $this->school->school_code;
        $this->school_name = $this->school->school_name;
        $this->address = $this->school->address;
        $this->school_level = $this->school->school_level->name;
        $this->pic_name = $this->school->pic_name;
        $this->pic_position = $this->school->pic_position;
        $this->pic_phone_number = $this->school->pic_phone_number;
        $this->pic_email = $this->school->pic_email;
        $this->hm_name = $this->school->hm_name;
        $this->hm_phone_number = $this->school->hm_phone_number;
        $this->hm_email = $this->school->hm_email;


        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Sekolah', 'link' => route('school.index')],
            ['label' => $this->school->school_name, 'link' => route('school.view', $this->school->id)],
            ['label' => 'Perbarui'],
        ];
    }

    protected function rules()
    {
        return [
            'school_code' => 'required|string|max:50',
            'school_name' => 'required|string|max:255',
            'address' => 'required|string',
            'school_level' => 'required|string',

            'pic_name' => 'required|string|max:255',
            'pic_position' => 'nullable|string|max:255',
            'pic_phone_number' => 'nullable|string|max:20',
            'pic_email' => 'nullable|email',

            'hm_name' => 'nullable|string|max:255',
            'hm_phone_number' => 'nullable|string|max:20',
            'hm_email' => 'nullable|email',
        ];
    }

    public function getLevelOptionsProperty()
    {
        return collect(SchoolLevel::cases())->map(fn ($level) => [
            'value' => $level->name,
            'label' => $level->label(),
        ]);
    }

        public function save()
        {
            $this->validate();

            $this->school->update([
                'school_code' => $this->school_code,
                'school_name' => $this->school_name,
                'address' => $this->address,
                'school_level' => $this->school_level,
                'pic_name' => $this->pic_name,
                'pic_position' => $this->pic_position,
                'pic_phone_number' => $this->pic_phone_number,
                'pic_email' => $this->pic_email,
                'hm_name' => $this->hm_name,
                'hm_phone_number' => $this->hm_phone_number,
                'hm_email' => $this->hm_email,
            ]);

            return redirect()->route('school.view', ['school_id' => $this->school->id])
                ->with('success', 'Sekolah berhasil ditambahkan.');
        }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Pembaruan Data Sekolah" subtitle="Edit data sekolah" separator>
        <x-slot:actions>
            <x-button link="{{ route('school.view', $this->school->id) }}" route="school.view" icon="o-arrow-left" label="Kembali" class="btn-dash" />
            <x-button link="{{ route('school.index') }}" route="school.index" label="Daftar Sekolah" />
        </x-slot:actions>
    </x-header>

    <x-form wire:submit.prevent="save">
        
        {{-- INFORMASI SEKOLAH --}}
        <h2 class="font-semibold border-b pb-2">Informasi Sekolah</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input label="Kode Sekolah" wire:model="school_code" />
            <x-input label="Nama Sekolah" wire:model="school_name" />
            <span class="md:col-span-2">
                <x-textarea label="Alamat" wire:model="address" rows="4" />
            </span>
            <x-select label="Tingkatan" wire:model="school_level" :options="$this->levelOptions" option-value="value" option-label="label" placeholder="Semua Tingkatan" />
        </div>
        
        {{-- INFORMASI PIC --}}
        <h2 class="font-semibold border-b pb-2">Informasi PIC</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input label="Nama PIC" wire:model="pic_name" />
            <x-input label="Jabatan PIC" wire:model="pic_position" />
            <x-input label="No HP PIC" wire:model="pic_phone_number" />
            <x-input label="Email PIC" wire:model="pic_email" />
        </div>
        
        <x-slot:actions>
            <x-button label="Simpan Perubahan" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
