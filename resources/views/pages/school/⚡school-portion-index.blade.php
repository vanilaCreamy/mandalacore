<?php

use Livewire\Component;
use App\Models\School;
use App\Models\SchoolPortion;

new class extends Component
{
    public $selectedSchool = null;

    public $small_portions = 0;
    public $big_portions = 0;
    public $teacher_portions = 0;
    public $non_teacher_portions = 0;

    public $histories = [];

    /*
    |--------------------------------------------------------------------------
    | COMPUTED: Schools with SUM (AUTO REFRESH)
    |--------------------------------------------------------------------------
    */
    public function getSchoolsProperty()
    {
        return School::withSum('portions as total_small', 'small_portions')
            ->withSum('portions as total_big', 'big_portions')
            ->withSum('portions as total_teacher', 'teacher_portions')
            ->withSum('portions as total_non_teacher', 'non_teacher_portions')
            ->orderBy('school_name')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | LOAD HISTORI SAAT SELECT BERUBAH
    |--------------------------------------------------------------------------
    */
    public function updatedSelectedSchool()
    {
        $this->loadHistories();
    }

    public function loadHistories()
    {
        if (!$this->selectedSchool) {
            $this->histories = [];
            return;
        }

        $this->histories = SchoolPortion::where('school_id', $this->selectedSchool)
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
            'selectedSchool' => 'required|exists:schools,id',
            'small_portions' => 'required|integer',
            'big_portions' => 'required|integer',
            'teacher_portions' => 'required|integer',
            'non_teacher_portions' => 'required|integer',
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

        SchoolPortion::create([
            'school_id' => $this->selectedSchool,
            'small_portions' => $this->small_portions,
            'big_portions' => $this->big_portions,
            'teacher_portions' => $this->teacher_portions,
            'non_teacher_portions' => $this->non_teacher_portions,
        ]);

        $this->reset([
            'small_portions',
            'big_portions',
            'teacher_portions',
            'non_teacher_portions',
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
            <a href="{{ route('school.view') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                Daftar Sekolah
            </a>
            <a href="{{ route('school.log-portion') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                Log Porsi
            </a>
        </div>
    </div>

    {{-- ===================== --}}
    {{-- SECTION PILIH SEKOLAH --}}
    {{-- ===================== --}}
    <div class="bg-white p-6 rounded-xl shadow space-y-6">

        <div>
            <h2 class="text-lg font-semibold mb-4">Pilih Sekolah</h2>

            <select wire:model.live="selectedSchool"
                    class="w-full border rounded-lg px-3 py-2">
                <option value="">-- Pilih Sekolah --</option>
                @foreach($this->schools as $school)
                    <option value="{{ $school->id }}">
                        {{ $school->school_name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- DETAIL SEKOLAH --}}
        @if($selectedSchool)

            @php
                $selected = $this->schools->firstWhere('id', $selectedSchool);
            @endphp

            <div class="border-t pt-6">
                <h3 class="font-semibold text-md mb-4">Detail Sekolah</h3>

                <div class="grid grid-cols-2 gap-6 text-sm">

                    <div>
                        <div class="text-slate-500 text-xs font-semibold">Kode Sekolah</div>
                        <div class="text-md">{{ $selected->school_code }}</div>
                    </div>

                    <div>
                        <div class="text-slate-500 text-xs font-semibold">Level Sekolah</div>
                        <div class="text-md">{{ $selected->school_level?->label() ?? '-' }}</div>
                    </div>

                    <div class="col-span-2">
                        <div class="text-slate-500 text-xs font-semibold">Alamat</div>
                        <div class="text-md">{{ $selected->address }}</div>
                    </div>

                </div>

                {{-- TOTAL PORTION (HASIL SUM DELTA) --}}
                <div class="mt-6 border-t pt-4 text-sm space-y-1">
                    <ul class="grid grid-cols-4">
                        <li>
                            <p>Porsi Kecil</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->total_small ?? 0 }}
                            </span>
                        </li>
                        <li>
                            <p>Porsi Besar</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->total_big ?? 0 }}
                            </span>
                        </li>
                        <li>
                            <p>Porsi Guru</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->total_teacher ?? 0 }}
                            </span>
                        </li>
                        <li>
                            <p>Porsi Non Guru</p>
                            <span class="block font-semibold text-lg">
                                {{ $selected->total_non_teacher ?? 0 }}
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
    @if($selectedSchool)

    <div class="bg-white p-6 rounded-xl shadow space-y-6">

        <h2 class="text-lg font-semibold">Tambah Histori Porsi</h2>

        <div class="grid grid-cols-4 gap-6">

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Kecil (+ / -)</label>
                <input type="number"
                       wire:model="small_portions"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Besar (+ / -)</label>
                <input type="number"
                       wire:model="big_portions"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Guru (+ / -)</label>
                <input type="number"
                       wire:model="teacher_portions"
                       class="w-full border rounded-lg px-3 py-2">
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-slate-600">Porsi Non Guru (+ / -)</label>
                <input type="number"
                       wire:model="non_teacher_portions"
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
                    Kecil: {{ $history->small_portions }} |
                    Besar: {{ $history->big_portions }} |
                    Guru: {{ $history->teacher_portions }} |
                    Non Guru: {{ $history->non_teacher_portions }}
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
