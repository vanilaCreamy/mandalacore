<?php

use Livewire\Component;
use App\Models\School;
use App\Models\SchoolPortion;

new class extends Component
{
    public $breadcrumbs = [];

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Sekolah', 'link' => route('school.index')],
            ['label' => 'Porsi Sekolah'],
        ];
    }

    public function getSchoolPortionsProperty()
    {
        return SchoolPortion::with([
            'school' => function ($q) {
                $q->withTrashed();
            }
        ])->latest()->get();

    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" class="mb-3" />

    <x-header title="Histori Porsi" subtitle="Log Perubahan Porsi" separator>
        <x-slot:actions>
            <x-button link="{{ route('school.index') }}" route="school.index" label="Daftar Sekolah" />
        </x-slot:actions>
    </x-header>

    {{-- Filter & Search Section --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6">

        <div class="grid md:grid-cols-4 gap-4 items-start">

            {{-- Search --}}
            <span class="col-span-1 md:col-span-2">
                <x-input label="Cari Sekolah" icon="o-magnifying-glass" placeholder="Ketik nama sekolah..." wire:model="search" clearable>
                    <x-slot:append>
                        {{-- Add `join-item` to all appended elements --}}
                        <x-button icon="o-magnifying-glass" class="join-item btn-primary" wire:click="getSchoolPortionsProperty" />
                    </x-slot:append>
                </x-input>
                
            </span>

        </div>

    </div>

    {{-- Log Porsi --}}
    <ul class="space-y-3">
        @foreach ($this->school_portions as $item)
            <li class="bg-white p-4 rounded-lg shadow-sm">

                {{-- Header --}}
                <div class="mb-3">
                    <h3>
                        @if ($item->school->trashed())
                        {{ $item->school->school_name }} - {{ $item->school->school_code }} <span class="font-light text-sm text-red-500">(Sekolah Tidak Aktif)</span>
                        @else
                        {{ $item->school->school_name }} - {{ $item->school->school_code }}
                        @endif
                    </h3>
                    <h5 class="text-xs text-slate-500">
                        {{ $item->created_at->format('D, d M Y H:i') }}
                    </h5>
                </div>

                {{-- Portion Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">

                    @foreach ([
                        'Kecil' => $item->small_portions,
                        'Besar' => $item->big_portions,
                        'Guru' => $item->teacher_portions,
                        'Non Guru' => $item->non_teacher_portions
                    ] as $label => $port)

                    {{-- POSITIF --}}
                    @if ($port > 0)
                        <x-stat
                        title="{{ $label }} - Naik"
                        value="{{ $port > 0 ? '+' . $port : $port }}"
                        icon="o-arrow-trending-up"
                        color="text-green-500" />

                    {{-- NOL --}}
                    @elseif ($port == 0)
                        <x-stat
                        title="{{ $label }} - Tetap"
                        value="{{ $port > 0 ? '+' . $port : $port }}"
                        icon="o-minus"
                        color="text-gray-500" />

                    {{-- NEGATIF --}}
                    @else
                        <x-stat
                        title="{{ $label }} - Turun"
                        value="{{ $port > 0 ? '+' . $port : $port }}"
                        icon="o-arrow-trending-down"
                        color="text-red-500" />
                    @endif

                    @endforeach

                </div>
            </li>
        @endforeach
    </ul>
</div>
