<?php

use Livewire\Component;
use App\Models\posyandu;

new class extends Component
{
    public $posyandu;

    public function mount($posyandu_id)
    {
        $this->posyandu = Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->find($posyandu_id);
    }
};
?>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Detail Posyandu
            </h1>
            <p class="text-sm text-slate-500">
                Informasi lengkap posyandu
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('posyandu.view') }}"
               class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg text-sm">
                ← Kembali
            </a>

            <a href="{{ route('posyandu.edit', ['posyandu_id' => $posyandu->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                Edit Postandu
            </a>
        </div>
    </div>


    {{-- CARD UTAMA --}}
    <div class="bg-white shadow rounded-2xl p-6 space-y-6">

        {{-- INFORMASI SEKOLAH --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Informasi Sekolah
            </h2>

            <div class="grid md:grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="text-slate-500 text-xs">Kode Sekolah</p>
                    <p class="font-medium">{{ $posyandu->posyandu_code }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Nama Sekolah</p>
                    <p class="font-medium">{{ $posyandu->posyandu_name }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Alamat</p>
                    <p class="font-medium">{{ $posyandu->address }}</p>
                </div>

            </div>
        </div>


        {{-- INFORMASI PIC --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Penanggung Jawab (Kader)
            </h2>

            <div class="grid md:grid-cols-3 gap-6 text-sm">

                <div>
                    <p class="text-slate-500 text-xs">Nama Kader</p>
                    <p class="font-medium">{{ $posyandu->pic_name }}</p>
                    <p class="font-light text-sm">{{ $posyandu->pic_position }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">No. HP</p>
                    <p class="font-medium">{{ $posyandu->pic_phone_number ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Email</p>
                    <p class="font-medium">{{ $posyandu->pic_email ?? '-' }}</p>
                </div>

            </div>
        </div>

        {{-- INFORMASI PORSI --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Informasi Porsi
            </h2>

            <div class="grid md:grid-cols-3 gap-6 text-sm">

                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Porsi Bumil</p>
                    <p class="text-xl font-bold text-blue-700">
                        {{ $posyandu->portions_sum_bumil_portions ?? 0 }}
                    </p>
                </div>

                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Porsi Busui</p>
                    <p class="text-xl font-bold text-blue-700">
                        {{ $posyandu->portions_sum_busui_portions ?? 0 }}
                    </p>
                </div>

                <div class="bg-green-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Total Balita</p>
                    <p class="text-xl font-bold text-green-700">
                        {{ $posyandu->portions_sum_balita_portions ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
