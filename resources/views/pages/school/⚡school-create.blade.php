<?php

use Livewire\Component;
use App\Models\School;
use App\enum\SchoolLevel;

new class extends Component
{
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
            'pic_email' => 'nullable|email',

            'hm_name' => 'nullable|string|max:255',
            'hm_phone_number' => 'nullable|string|max:20',
            'hm_email' => 'nullable|email',
        ];
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
            'pic_email' => $this->pic_email,
            'hm_name' => $this->hm_name,
            'hm_phone_number' => $this->hm_phone_number,
            'hm_email' => $this->hm_email,
        ]);

        return redirect()->route('school.view')
            ->with('success', 'Sekolah berhasil ditambahkan.');
    }
};
?>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Tambah Sekolah Baru
            </h1>
            <p class="text-sm text-slate-500">
                Input data sekolah
            </p>
        </div>

        <a href="{{ route('school.view') }}"
           class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg text-sm">
            ← Kembali
        </a>
    </div>


    <form wire:submit.prevent="save" class="space-y-8">

        {{-- INFORMASI SEKOLAH --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">
            <h2 class="font-semibold border-b pb-2">Informasi Sekolah</h2>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="text-xs text-slate-500">Kode Sekolah</label>
                    <input type="text" wire:model="school_code"
                           class="w-full border rounded-lg px-3 py-2">
                    @error('school_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
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
                    <select wire:model="school_level"
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


        {{-- INFORMASI KEPALA SEKOLAH --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">
            <h2 class="font-semibold border-b pb-2">
                Informasi Kepala Sekolah (Head Master)
            </h2>

            <div class="grid md:grid-cols-3 gap-6">

                <div>
                    <label class="text-xs text-slate-500">Nama Kepala Sekolah</label>
                    <input type="text" wire:model="hm_name"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-xs text-slate-500">No HP</label>
                    <input type="text" wire:model="hm_phone_number"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-xs text-slate-500">Email</label>
                    <input type="email" wire:model="hm_email"
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
