<?php

use Livewire\Component;
use App\Models\Posyandu;
use App\Models\PosyanduPortion;

new class extends Component
{
    public $breadcrumbs = [];

    public $posyandu;
    public $posyandu_portions;

    public function mount($posyandu_id)
    {
        $this->posyandu = Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->find($posyandu_id);

        $this->posyandu_portions = PosyanduPortion::where('posyandu_id', $posyandu_id)->latest()->get();

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Posyandu', 'link' => route('posyandu.index')],
            ['label' => $this->posyandu->posyandu_name,],
        ];
    }
};
?>

<div class="space-y-6">
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Detail Posyandu" subtitle="Informasi lengkap posyandu" separator>
        <x-slot:actions>
            <x-button link="{{ route('posyandu.index') }}" route="posyandu.index" icon="o-arrow-left" label="Kembali" class="btn-dash" />
            <x-button link="{{ route('posyandu.portion') }}" route="posyandu.portion" label="Histori Porsi" />
            <x-button link="{{ route('posyandu.edit', $this->posyandu->id) }}" route="posyandu.edit" icon="o-pencil" label="Edit Posyandu" class="btn-primary" />
        </x-slot:actions>
    </x-header>


    {{-- CARD UTAMA --}}
    <div class="bg-white shadow rounded-2xl p-6 space-y-6">

        {{-- INFORMASI SEKOLAH --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Informasi Posyandu
            </h2>

            <div class="grid md:grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="text-slate-500 text-xs">Kode Posyandu</p>
                    <p class="font-medium">{{ $posyandu->posyandu_code }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Nama Posyandu</p>
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
                    <p class="font-medium">{{ $posyandu->cadre_name }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">No. HP</p>
                    <p class="font-medium">{{ $posyandu->cadre_phone_number ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Email</p>
                    <p class="font-medium">{{ $posyandu->cadre_email ?? '-' }}</p>
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
                        {{ $posyandu->portions_sum_bumil ?? 0 }}
                    </p>
                </div>

                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Porsi Busui</p>
                    <p class="text-xl font-bold text-blue-700">
                        {{ $posyandu->portions_sum_busui ?? 0 }}
                    </p>
                </div>

                <div class="bg-green-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Total Balita</p>
                    <p class="text-xl font-bold text-green-700">
                        {{ $posyandu->portions_sum_balita ?? 0 }}
                    </p>
                </div>
            </div>
        </div>

        {{-- History --}}
        <div class="">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Histori Perubahan Porsi
            </h2>

            {{-- Log Porsi --}}
            <ul class="space-y-3">
                @foreach ($posyandu_portions as $item)
                    <li class="bg-white p-4 rounded-lg shadow-sm">

                        {{-- Header --}}
                        <div class="mb-3">
                            <h5 class="text-xs text-slate-500">
                                {{ $item->created_at->format('D, d M Y H:i') }}
                            </h5>
                        </div>

                        {{-- Portion Grid --}}
                        <div class="grid grid-cols-3 gap-4 text-sm">

                            @foreach ([
                                'Bumil' => $item->bumil,
                                'Busui' => $item->busui,
                                'Balita' => $item->balita
                            ] as $label => $port)

                                <div class="flex items-center gap-2">

                                    {{-- POSITIF --}}
                                    @if ($port > 0)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-4 h-4 text-green-500">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                        </svg>

                                    {{-- NOL --}}
                                    @elseif ($port == 0)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-4 h-4 text-slate-400">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M5 12h14" />
                                        </svg>

                                    {{-- NEGATIF --}}
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.5"
                                            stroke="currentColor"
                                            class="w-4 h-4 text-red-500">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m4.5 4.5 15 15m0 0V8.25m0 11.25H8.25" />
                                        </svg>
                                    @endif

                                    <div>
                                        <span class="font-medium">{{ $label }}:</span>
                                        <span class="
                                            {{ $port > 0 ? 'text-green-600' : ($port < 0 ? 'text-red-600' : 'text-slate-600') }}
                                        ">
                                            {{ $port > 0 ? '+' . $port : $port }}
                                        </span>
                                    </div>

                                </div>

                            @endforeach

                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
