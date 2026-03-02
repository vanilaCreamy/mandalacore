<?php

use Livewire\Component;
use App\Models\Posyandu;

new class extends Component
{
    public $posyandu_code;
    public $posyandu_name;
    public $address;

    public $cadre_name;
    public $cadre_phone_number;
    public $cadre_email;

    public function mount()
    {
        $this->posyandu_code = $this->generatePosyanduCode();
    }

    private function generatePosyanduCode()
    {
        $count = Posyandu::count();
        $index = $count + 1;

        $indexFormatted = sprintf('%03d', $index);

        $year = now()->year;

        return "{$indexFormatted}/PSY-CPK2/{$year}";
    }


    protected function rules()
    {
        return [
            'posyandu_code' => 'required|string|max:50|unique:posyandu,posyandu_code',
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

        Posyandu::create([
            'posyandu_code' => $this->posyandu_code,
            'posyandu_name' => $this->posyandu_name,
            'address' => $this->address,
            'cadre_name' => $this->cadre_name,
            'cadre_phone_number' => $this->cadre_phone_number,
            'cadre_email' => $this->cadre_email,
        ]);

        return redirect()->route('posyandu.view')
            ->with('success', 'Posyandu berhasil ditambahkan.');
    }
};
?>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Tambah Posyandu Baru
            </h1>
            <p class="text-sm text-slate-500">
                Input data Posyandu
            </p>
        </div>

        <a href="{{ route('posyandu.view') }}"
           class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg text-sm">
            ← Kembali
        </a>
    </div>


    <form wire:submit.prevent="save" class="space-y-8">

        {{-- INFORMASI Posyandu --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">
            <h2 class="font-semibold border-b pb-2">Informasi Posyandu</h2>

            <div class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="text-xs text-slate-500">Kode Posyandu (Auto)</label>
                    <input type="text" wire:model="posyandu_code"
                           class="w-full border-b border-green-500 px-3 py-2" disabled>
                    @error('posyandu_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Nama Posyandu</label>
                    <input type="text" wire:model="posyandu_name"
                           class="w-full border rounded-lg px-3 py-2">
                    @error('posyandu_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="text-xs text-slate-500">Alamat</label>
                    <textarea wire:model="address"
                              class="w-full border rounded-lg px-3 py-2"></textarea>
                    @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

            </div>
        </div>


        {{-- INFORMASI PIC --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">
            <h2 class="font-semibold border-b pb-2">Informasi Kader</h2>

            <div class="grid md:grid-cols-3 gap-6">

                <div>
                    <label class="text-xs text-slate-500">Nama Kader</label>
                    <input type="text" wire:model="cadre_name"
                           class="w-full border rounded-lg px-3 py-2">
                    @error('cadre_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="text-xs text-slate-500">No HP Kader</label>
                    <input type="text" wire:model="cadre_phone_number"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

                <div>
                    <label class="text-xs text-slate-500">Email Kader</label>
                    <input type="email" wire:model="cadre_email"
                           class="w-full border rounded-lg px-3 py-2">
                </div>

            </div>
        </div>


        {{-- SUBMIT --}}
        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow">
                Simpan Posyandu
            </button>
        </div>

    </form>

</div>
