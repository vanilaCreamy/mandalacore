<?php

use Livewire\Component;
use App\Models\School;
use App\Models\SchoolPortion;

new class extends Component
{
    public $school;
    public $school_portions;

    public function mount($school_id)
    {
        $this->school = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->find($school_id);

        $this->school_portions = SchoolPortion::where('school_id', $school_id)->latest()->get();
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

        $small = $school->portions_sum_small_portions ?? 0;
        $big = $school->portions_sum_big_portions ?? 0;

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

        {{-- History --}}
        <div class="">
            <h2 class="text-lg font-semibold mb-4 border-b pb-2">
                Histori Perubahan Porsi
            </h2>

            {{-- Log Porsi --}}
            <ul class="space-y-3">
                @foreach ($school_portions as $item)
                    <li class="bg-white p-4 rounded-lg shadow-sm">

                        {{-- Header --}}
                        <div class="mb-3">
                            <h5 class="text-xs text-slate-500">
                                {{ $item->created_at->format('D, d M Y H:i') }}
                            </h5>
                        </div>

                        {{-- Portion Grid --}}
                        <div class="grid grid-cols-4 gap-4 text-sm">

                            @foreach ([
                                'Kecil' => $item->small_portions,
                                'Besar' => $item->big_portions,
                                'Guru' => $item->teacher_portions,
                                'Non Guru' => $item->non_teacher_portions
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
