<?php

use Livewire\Component;
use App\Models\Posyandu;
use App\Models\PosyanduPortion;

new class extends Component
{
    public $selectedPosyandu = null;

    public $bumil = 0;
    public $busui = 0;
    public $balita = 0;

    public $histories = [];

    /*
    |--------------------------------------------------------------------------
    | COMPUTED: Schools with SUM (AUTO REFRESH)
    |--------------------------------------------------------------------------
    */
    public function getPosyanduProperty()
    {
        return Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD HISTORI SAAT SELECT BERUBAH
    |--------------------------------------------------------------------------
    */
    public function updatedSelectedPosyandu()
    {
        $this->loadHistories();
    }

    public function loadHistories()
    {
        if (!$this->selectedPosyandu) {
            $this->histories = [];
            return;
        }

        $this->histories = PosyanduPortion::where('posyandu_id', $this->selectedPosyandu)
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */
    public function rules()
    {
        return [
            'selectedPosyandu' => 'required|exists:posyandu,id',
            'bumil' => 'required|integer',
            'busui' => 'required|integer',
            'balita' => 'required|integer',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE HISTORI (DELTA STYLE)
    |--------------------------------------------------------------------------
    */
    public function save()
    {
        $this->validate();

        PosyanduPortion::create([
            'posyandu_id' => $this->selectedPosyandu,
            'bumil' => $this->bumil,
            'busui' => $this->busui,
            'balita' => $this->balita,
        ]);

        $this->reset([
            'bumil',
            'busui',
            'balita',
        ]);

        $this->loadHistories();
    }
};
?>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Histori Porsi
            </h1>
            <p class="text-sm text-slate-500">
                Log perubahan porsi
            </p>
        </div>

        <div class="flex gap-2 items-center">
            <a href="{{ route('posyandu.view') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                Daftar Posyandu
            </a>
            <a href="{{ route('posyandu.log-portion') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                Log Porsi
            </a>
        </div>
    </div>

    {{-- ===================== --}}
    {{-- SECTION PILIH Posyandu --}}
    {{-- ===================== --}}
    <div class="bg-white p-6 rounded-xl shadow space-y-6">

        <div>
            <h2 class="text-lg font-semibold mb-4">Pilih Posyandu</h2>

            <select wire:model.live="selectedPosyandu"
                    class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Posyandu --</option>
                @foreach($this->posyandu as $pos)
                    <option value="{{ $pos->id }}">
                        {{ $pos->posyandu_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DETAIL Posyandu --}}
        @if($selectedPosyandu)

            @php
                $selected = $this->posyandu->firstWhere('id', $selectedPosyandu);
            @endphp

            <div class="border-t pt-6">
                <h3 class="font-semibold text-md mb-4">Detail Posyandu</h3>

                <div class="grid grid-cols-3 gap-6 text-sm">

                    <div>
                        <div class="text-slate-500 text-xs font-semibold">Kode Posyandu</div>
                        <div class="text-md">{{ $selected->posyandu_code }}</div>
                    </div>

                    <div class="col-span-2">
                        <div class="text-slate-500 text-xs font-semibold">Alamat</div>
                        <div class="text-md">{{ $selected->address }}</div>
                    </div>

                </div>

                {{-- TOTAL PORTION (HASIL SUM DELTA) --}}
                <div class="mt-6 border-t pt-4 text-sm space-y-1">
                    <ul class="grid grid-cols-3 md:grid-cols-3">
                        <li>
                            <p>Porsi Kecil</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->portions_sum_bumil ?? 0 }}
                            </span>
                        </li>
                        <li>
                            <p>Porsi Besar</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->portions_sum_busui ?? 0 }}
                            </span>
                        </li>
                        <li>
                            <p>Porsi Guru</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->portions_sum_balita ?? 0 }}
                            </span>
                        </li>
                    </ul>
                </div>

            </div>
        @endif

    </div>


    {{-- ===================== --}}
    {{-- INPUT HISTORI --}}
    {{-- ===================== --}}
    @if($selectedPosyandu)

    <div class="bg-white p-6 rounded-xl shadow space-y-6">

        <h2 class="text-lg font-semibold">Tambah Histori Porsi</h2>

        <div class="grid grid-cols-3 md:grid-cols-3 gap-6">

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Bumil (+ / -)</label>
                <input type="number"
                       wire:model="bumil"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Busui (+ / -)</label>
                <input type="number"
                       wire:model="busui"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Balita (+ / -)</label>
                <input type="number"
                       wire:model="balita"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

        </div>

        <div class="pt-4">
            <button wire:click="save"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Simpan Histori
            </button>
        </div>

    </div>


    {{-- ===================== --}}
    {{-- LOG HISTORI --}}
    {{-- ===================== --}}
    <div class="bg-white p-6 rounded-xl shadow space-y-4">

        <h2 class="text-lg font-semibold">
            Log Histori (Terbaru → Terlama)
        </h2>

        @forelse($histories as $history)
            <div class="border rounded-lg p-4 text-sm space-y-1">

                <div class="text-slate-500">
                    {{ $history->created_at->format('d M Y H:i') }}
                </div>

                <div>
                    Bumil: {{ $history->bumil }} |
                    Busui: {{ $history->busui }} |
                    Balita: {{ $history->balita }} |
                </div>

            </div>
        @empty
            <div class="text-sm text-gray-500">
                Belum ada histori.
            </div>
        @endforelse

    </div>

    @endif

</div>
