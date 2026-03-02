<?php

use Livewire\Component;
use App\Models\School;
use App\Models\SchoolPortion;

new class extends Component
{
    public $breadcrumbs = [];

    public $schools;
    public $school_portions;

    // table
    public $headers = [
        ['key' => '']  
    ];

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Sekolah'],
        ];

        $this->schools = School::all();
        $this->school_portions = SchoolPortion::all();
    }

    public function refreshChart()
    {
        $this->mount();
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" class="mb-3" />

    <x-header title="Sekolah" subtitle="Daftar Sekolah terdata" separator>
        <x-slot:actions>
            <x-button link="{{ route('school.view') }}" route="school.view" label="Daftar Sekolah" />
            <x-button link="{{ route('school.portion') }}" route="school.portion" label="Histori Porsi" />
            <x-button link="{{ route('school.create') }}" route="school.create" icon="o-plus" label="Tambah Sekolah" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    <div class="grid grid-cols-1 justify-center bg-white p-2 items-center gap-2 md:grid-cols-2 lg:grid-cols-4">
        <x-stat
            title="Total Sekolah"
            description="Terdata"
            value="{{ count($schools) }}"
            icon="o-academic-cap"
            color="text-primary" />

        <x-stat
            title="Porsi Kecil"
            description="Dibawah Kelas 4 Sd"
            value="{{ $school_portions->sum('small_portions') }}"
            icon="s-users"
            color="text-lime-500"/>

        <x-stat
            title="Porsi Besar"
            description="Diatas Kelas 3 Sd"
            value="{{ $school_portions->sum('big_portions') }}"
            icon="s-users"
            color="text-sky-500" />

        <x-stat
            title="Total Siswa"
            description="Jumlah Keseluruhan"
            value="{{ $school_portions->sum('small_portions') + $school_portions->sum('big_portions') }}"
            icon="o-bolt"
            color="text-yellow-500" />
    </div>

    {{-- TABLE (Desktop) --}}
    <div class="hidden md:block bg-white shadow rounded-xl overflow-hidden">

        <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Kode</th>
                    <th class="px-4 py-3 text-left">Nama Sekolah</th>
                    <th class="px-4 py-3 text-left">Level</th>
                    <th class="px-4 py-3 text-center">PK</th>
                    <th class="px-4 py-3 text-center">PB</th>
                    <th class="px-4 py-3 text-left">PIC</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse ($schools as $school)

                @php
                    $teacher = $school->portions_sum_teacher_portions ?? 0;
                    $nonTeacher = $school->portions_sum_non_teacher_portions ?? 0;
                    $tambahan = $teacher + $nonTeacher;

                    $small = $school->portions_sum_small_portions;
                    $big = $school->portions_sum_big_portions;

                    if ($big != 0) {
                        $bigFinal = $big + $tambahan;
                        $smallFinal = $small;
                    } else {
                        $smallFinal = $small + $tambahan;
                        $bigFinal = $big;
                    }
                @endphp

                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-medium text-nowrap">
                            {{ $school->school_code }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $school->school_name }}
                            <p class="text-xs font-light">{{ $school->address }}</p>
                        </td>

                        <td class="px-4 py-3">
                            {{ $school->school_level->label() }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $smallFinal ?? 0 }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $bigFinal ?? 0 }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-medium text-nowrap">
                                {{ $school->pic_name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $school->pic_phone_number }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <x-button icon="o-eye" class="btn-circle" link="{{ route('school.detail', ['school_id' => $school->id]) }}" />    
                                <x-button icon="o-eye" class="btn-circle" />    
                                {{-- <a href="{{ route('school.detail', ['school_id' => $school->id]) }}" class="text-blue-600 hover:underline text-xs">
                                </a>
                                <a href="{{ route('school.edit', ['school_id' => $school->id]) }}" class="text-yellow-600 hover:underline text-xs">
                                    <X-icon name="o-eye"     />    
                                </a> --}}
                                <button 
                                    wire:click="delete_school({{ $school->id }})"
                                    wire:confirm="Yakin mau hapus sekolah ini?"
                                    class="text-red-600 hover:underline text-xs"
                                >
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-6 text-slate-400">
                            Belum ada data sekolah
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>



    {{-- CARD (Mobile) --}}
    <div class="md:hidden space-y-4">

        @forelse ($schools as $school)

            @php
                $teacher = $school->portions_sum_teacher_portions ?? 0;
                $nonTeacher = $school->portions_sum_non_teacher_portions ?? 0;
                $tambahan = $teacher + $nonTeacher;

                $small = $school->portions_sum_small_portions;
                $big = $school->portions_sum_big_portions;

                if ($big != 0) {
                    $bigFinal = $big + $tambahan;
                    $smallFinal = $small;
                } else {
                    $smallFinal = $small + $tambahan;
                    $bigFinal = $big;
                }
            @endphp

            <div class="bg-white shadow rounded-xl p-4 space-y-2">

                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="font-semibold">
                            {{ $school->school_name }}
                            <p class="text-sm font-light">{{ $school->address }}</p>
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ $school->school_code }}
                        </p>
                    </div>

                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                        {{ $school->school_level->label() }}
                    </span>
                </div>

                <div class="grid grid-cols-2 text-sm gap-2 pt-2">
                    <div>
                        <span class="text-slate-500 text-xs">PK</span>
                        <div class="font-medium">{{ $smallFinal }}</div>
                    </div>

                    <div>
                        <span class="text-slate-500 text-xs">PB</span>
                        <div class="font-medium">{{ $bigFinal }}</div>
                    </div>
                </div>

                <div class="pt-2 border-t text-sm">
                    <div class="font-medium">{{ $school->pic_name }}</div>
                    <div class="text-xs text-slate-500">
                        {{ $school->pic_phone_number }}
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <a href="{{ route('school.detail', ['school_id' => $school->id]) }}" class="text-blue-600 hover:underline text-xs">View</a>
                    <a href="{{ route('school.edit', ['school_id' => $school->id]) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                    <button 
                        wire:click="delete_school({{ $school->id }})"
                        wire:confirm="Yakin mau hapus sekolah ini?"
                        class="text-red-600 hover:underline text-xs"
                    >
                        Hapus
                    </button>
                </div>

            </div>

        @empty
            <div class="text-center text-slate-400 py-6">
                Belum ada data sekolah
            </div>
        @endforelse

    </div>

</div>