<?php

use Livewire\Component;
use App\Models\Posyandu;

new class extends Component
{
    public $posyandus;

    public function mount()
    {
        $this->loadPosyandu();
    }

    public function loadPosyandu()
    {
        $this->posyandus = Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->get();
    }

    public function delete_posyandu($id)
    {
        $deleted_posyandu = Posyandu::findOrFail($id);
        $deleted_posyandu->delete();
        $this->loadPosyandu();
    }
};
?>

<div class="">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-2 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Daftar Posyandu
            </h1>
            <p class="text-sm text-slate-500">
                Data posyandu terdaftar
            </p>
        </div>

        <div class="flex gap-2 items-center">
            <a href="{{ route('posyandu.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                + Tambah Posyandu
            </a>
            <a href="{{ route('posyandu.portion') }}"
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
                    <th class="px-4 py-3 text-left">Nama Posyandu</th>
                    <th class="px-4 py-3 text-left">Bumil</th>
                    <th class="px-4 py-3 text-center">Busui</th>
                    <th class="px-4 py-3 text-center">Balita</th>
                    <th class="px-4 py-3 text-left">Kader</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @forelse ($posyandus as $posyandu)

                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-4 py-3 font-medium text-nowrap">
                            {{ $posyandu->posyandu_code }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $posyandu->posyandu_name }}
                            <p class="text-sm font-light">{{ $posyandu->address }}</p>
                        </td>

                        <td class="px-4 py-3">
                            {{ $posyandu->portions_sum_bumil_portions }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $posyandu->portions_sum_busui_portions }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            {{ $posyandu->portions_sum_balita_portions }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="font-medium text-nowrap">
                                {{ $posyandu->cadre_name }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ $posyandu->cadre_phone_number }}
                            </div>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('posyandu.detail', ['posyandu_id' => $posyandu->id]) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('posyandu.edit', ['posyandu_id' => $posyandu->id]) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                                <button 
                                    wire:click="delete_posyandu({{ $posyandu->id }})"
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
                            Belum ada data posyandu
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>
    </div>



    {{-- CARD (Mobile) --}}
    <div class="md:hidden space-y-4">

        @forelse ($posyandus as $posyandu)

            <div class="bg-white shadow rounded-xl p-4 space-y-2">

                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="font-semibold">
                            {{ $posyandu->posyandu_name }}
                            <p class="text-sm font-light">{{ $posyandu->address }}</p>
                        </h2>
                        <p class="text-xs text-slate-500">
                            {{ $posyandu->posyandu_code }}
                        </p>
                    </div>

                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded">
                        {{ $posyandu->posyandu_level->label() }}
                    </span>
                </div>

                <div class="grid grid-cols-2 text-sm gap-2 pt-2">
                    <div>
                        <span class="text-slate-500 text-xs">BUMIL</span>
                        <div class="font-medium">{{ $posyandu->portions_sum_bumil_portions }}</div>
                    </div>

                    <div>
                        <span class="text-slate-500 text-xs">BUSUI</span>
                        <div class="font-medium">{{ $posyandu->portions_sum_busui_portions }}</div>
                    </div>

                    <div>
                        <span class="text-slate-500 text-xs">BALITA</span>
                        <div class="font-medium">{{ $posyandu->portions_sum_balita_portions }}</div>
                    </div>
                </div>

                <div class="pt-2 border-t text-sm">
                    <div class="font-medium">{{ $posyandu->cadre_name }}</div>
                    <div class="text-xs text-slate-500">
                        {{ $posyandu->cadre_phone_number }}
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <a href="{{ route('posyandu.detail', ['posyandu_id' => $posyandu->id]) }}" class="text-blue-600 hover:underline text-xs">View</a>
                    <a href="{{ route('posyandu.edit', ['posyandu_id' => $posyandu->id]) }}" class="text-yellow-600 hover:underline text-xs">Edit</a>
                    <button 
                        wire:click="delete_posyandu({{ $posyandu->id }})"
                        wire:confirm="Yakin mau hapus sekolah ini?"
                        class="text-red-600 hover:underline text-xs"
                    >
                        Hapus
                    </button>
                </div>

            </div>

        @empty
            <div class="text-center text-slate-400 py-6">
                Belum ada data posyandu
            </div>
        @endforelse

    </div>

</div>
