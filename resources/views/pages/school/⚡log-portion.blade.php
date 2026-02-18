<?php

use Livewire\Component;
use App\Models\SchoolPortion;

new class extends Component
{
    public $portions;

    public function mount()
    {
        $this->portions = SchoolPortion::latest()->get();
    }
};
?>

<div>
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Log Porsi
            </h1>
            <p class="text-sm text-slate-500">
                Data log porsi
            </p>
        </div>

        <div class="flex gap-2 items-center">
            <a href="{{ route('school.view') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                Daftar Sekolah  
            </a>
            <a href="{{ route('school.portion') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                + Histori Porsi
            </a>
        </div>
    </div>

    {{-- Log Porsi --}}
    <ul class="space-y-3">
        @foreach ($portions as $item)
            <li class="bg-white p-4 rounded-lg shadow-sm">

                {{-- Header --}}
                <div class="mb-3">
                    <h5 class="text-xs text-slate-500">
                        {{ $item->created_at->format('d M Y H:i') }}
                    </h5>

                    <h2 class="font-semibold">
                        {{ $item->school->school_name }}
                        <span class="text-sm font-light">
                            ({{ $item->school->school_code }})
                        </span>
                    </h2>

                    <p class="text-sm font-light text-slate-600">
                        {{ $item->school->address }}
                    </p>
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