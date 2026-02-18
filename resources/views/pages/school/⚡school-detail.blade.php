<?php

use Livewire\Component;
use App\Models\School;

new class extends Component
{
    public $school;

    public function mount($school_id)
    {
        $this->school = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->find($school_id);
    }
};
?>

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Detail Sekolah
            </h1>
            <p class="text-sm text-slate-500">
                Informasi lengkap sekolah
            </p>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('school.view') }}"
               class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded-lg text-sm">
                ← Kembali
            </a>

            <a href="{{ route('school.edit', ['school_id' => $school->id]) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
                Edit Sekolah
            </a>
        </div>
    </div>


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
                    <p class="font-medium">{{ $school->school_code }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Nama Sekolah</p>
                    <p class="font-medium">{{ $school->school_name }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Level Sekolah</p>
                    <p class="font-medium">{{ $school->school_level->label() }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Alamat</p>
                    <p class="font-medium">{{ $school->address }}</p>
                </div>

            </div>
        </div>


        {{-- INFORMASI PIC --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Penanggung Jawab (PIC)
            </h2>

            <div class="grid md:grid-cols-3 gap-6 text-sm">

                <div>
                    <p class="text-slate-500 text-xs">Nama PIC</p>
                    <p class="font-medium">{{ $school->pic_name }}</p>
                    <p class="font-light text-sm">{{ $school->pic_position }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">No. HP</p>
                    <p class="font-medium">{{ $school->pic_phone_number ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Email</p>
                    <p class="font-medium">{{ $school->pic_email ?? '-' }}</p>
                </div>

            </div>
        </div>

        {{-- INFORMASI Kepala Sekolah --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Kepala Sekolah
            </h2>

            <div class="grid md:grid-cols-3 gap-6 text-sm">

                <div>
                    <p class="text-slate-500 text-xs">Nama Kepala Sekolah</p>
                    <p class="font-medium">{{ $school->hm_name }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">No. HP</p>
                    <p class="font-medium">{{ $school->hm_phone_number ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-slate-500 text-xs">Email</p>
                    <p class="font-medium">{{ $school->hm_email ?? '-' }}</p>
                </div>

            </div>
        </div>


        {{-- INFORMASI PORSI --}}
        <div>
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Informasi Porsi
            </h2>

            <div class="grid md:grid-cols-4 gap-6 text-sm">

                <div class="bg-slate-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Porsi Kecil Siswa</p>
                    <p class="text-xl font-bold">
                        {{ $small }}
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Porsi Besar Siswa</p>
                    <p class="text-xl font-bold">
                        {{ $big }}
                    </p>
                </div>

                <div class="bg-blue-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Total Porsi Kecil</p>
                    <p class="text-xl font-bold text-blue-700">
                        {{ $smallFinal }}
                    </p>
                </div>

                <div class="bg-green-50 p-4 rounded-xl">
                    <p class="text-slate-500 text-xs">Total Porsi Besar</p>
                    <p class="text-xl font-bold text-green-700">
                        {{ $bigFinal }}
                    </p>
                </div>

            </div>

            <div class="mt-4 text-xs text-slate-500">
                * Porsi Guru: {{ $teacher }} |
                Porsi Non-Guru: {{ $nonTeacher }}
            </div>
        </div>

    </div>

</div>
