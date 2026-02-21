<?php

use Livewire\Component;
use App\Models\School;

new class extends Component
{
    public $schools;

    public function mount()
    {
        $this->loadSchools();
    }

    public function loadSchools()
    {
        $this->schools = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->get();
    }

    public function delete_school($id)
    {
        $deleted_school = School::findOrFail($id);
        $deleted_school->delete();
        $this->loadSchools();
    }
};
?>

<div class="">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Daftar Sekolah
            </h1>
            <p class="text-sm text-slate-500">
                Data sekolah terdaftar
            </p>
        </div>

        <div class="flex gap-2 items-center">
            <a href="{{ route('school.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                + Tambah Sekolah
            </a>
            <a href="{{ route('school.portion') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                + Histori Porsi
            </a>
        </div>
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
                            <p class="text-sm font-light">{{ $school->address }}</p>
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
