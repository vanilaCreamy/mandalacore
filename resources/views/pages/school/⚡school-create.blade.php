<?php

use Livewire\Component;
use App\Models\School;
use App\Enums\SchoolLevel;
use Carbon\Carbon;

new class extends Component
{
    public $breadcrumbs;

    public $school_code;
    public $school_name;
    public $address;
    public $school_level;

    public $pic_name;
    public $pic_position;
    public $pic_phone_number;
    public $pic_email;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Sekolah', 'link' => route('school.index')],
            ['label' => 'Buat Sekolah Baru']
        ];
    }

    protected function rules()
    {
        return [
            'school_code' => 'required|string|max:50|unique:schools,school_code',
            'school_name' => 'required|string|max:255',
            'address' => 'required|string',
            'school_level' => 'required|string',

            'pic_name' => 'required|string|max:255',
            'pic_position' => 'nullable|string|max:255',
            'pic_phone_number' => 'nullable|string|max:20',
            'pic_email' => 'nullable|email'
        ];
    }

    private function generateSchoolCode()
    {
        // Ambil level
        $level = $this->school_level;

        if (!$level) {
            return null;
        }

        // Hitung jumlah sekolah dengan level yang sama
        $count = School::withTrashed()->where('school_level', $level)->count();

        $index = $count + 1;
        // Format jadi 3 digit
        $indexFormatted = str_pad($index, 3, '0', STR_PAD_LEFT);

        // Konversi enum name ke angka romawi
        $roman = $level;

        $year = Carbon::now()->year;

        return "{$indexFormatted}/{$roman}/SKL-CPK2/{$year}";
    }

    public function updatedSchoolLevel($value)
    {
        // Contoh: auto generate preview kode sekolah
        $this->school_code = $this->generateSchoolCode();
    }

    public function save()
    {
        $this->validate();

        School::create([
            'school_code' => $this->school_code,
            'school_name' => $this->school_name,
            'address' => $this->address,
            'school_level' => $this->school_level,
            'pic_name' => $this->pic_name,
            'pic_position' => $this->pic_position,
            'pic_phone_number' => $this->pic_phone_number,
            'pic_email' => $this->pic_email
        ]);

        return redirect()->route('school.index')
            ->with('success', 'Sekolah berhasil ditambahkan.');
    }
};
?>

<div class="space-y-6">
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Tambah Sekolah Baru" subtitle="Input data sekolah" separator>
        <x-slot:actions>
            <x-button link="{{ route('school.index') }}" route="school.index" icon="o-arrow-left" label="Kembali" class="btn-dash" />
        </x-slot:actions>
    </x-header>

    <form wire:submit.prevent="save" class="space-y-8">

        {{-- INFORMASI SEKOLAH --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">
            <h2 class="font-semibold border-b pb-2">Informasi Sekolah</h2>

            <div class="grid md:grid-cols-2 gap-2">

                <div>
                    <label class="text-xs text-slate-500">Kode Sekolah (Auto)</label>
                    <input type="text" wire:model="school_code"
                           class="w-full border-b border-green-500 px-3 py-2" disabled>
                    @error('school_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Nama Sekolah</label>
                    <input type="text" wire:model="school_name"
                           class="w-full border rounded-lg px-3 py-2">
                    @error('school_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Alamat</label>
                    <textarea wire:model="address"
                              class="w-full border rounded-lg px-3 py-2"></textarea>
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs text-slate-500">Level Sekolah</label>
                    <select wire:model.live="school_level"
                            class="w-full border rounded-lg px-3 py-2">
                        <option value="">Pilih Level</option>
                        @foreach (SchoolLevel::cases() as $item)
                            <option value="{{ $item->name }}">{{ $item->label() }}</option>
                        @endforeach
                    </select>
                    @error('school_level') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>


        {{-- INFORMASI PIC --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">
            <h2 class="font-semibold border-b pb-2">Informasi PIC</h2>

            <div class="grid md:grid-cols-3 gap-6">

                <div>
                    <label class="text-xs text-slate-500">Nama PIC</label>
                    <input type="text" wire:model="pic_name"
                           class="w-full border rounded-lg px-3 py-2">
                    @error('pic_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs text-slate-500">Jabatan PIC</label>
                    <input type="text" wire:model="pic_position"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-xs text-slate-500">No HP PIC</label>
                    <input type="text" wire:model="pic_phone_number"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-xs text-slate-500">Email PIC</label>
                    <input type="email" wire:model="pic_email"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                Simpan Sekolah
            </button>
        </div>

    </form>

</div>
