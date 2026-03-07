<?php

use Livewire\Component;
use App\Models\Posyandu;
use App\Models\PosyanduPortion;

new class extends Component
{
    public $posyandu_portion_modal = false;
    public $selected_posyandu;

    public $breadcrumbs = [];
    public $search = '';

    public function mount()
    {
        $this->posyandus = Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->get();

        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Posyandu'],
        ];
    }

    public function getPosyandusProperty()
    {
        return Posyandu::query()
            ->when($this->search, function ($query) {
                $query->where('posyandu_name', 'like', '%' . $this->search . '%');
            })
            ->withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->get();
    }

    public function getPosyanduPortionsProperty()
    {
        return PosyanduPortion::query()
            ->when($this->search, function ($query) {
                $query->whereHas('posyandu', function ($q) {
                    $q->where('posyandu_name', 'like', '%' . $this->search . '%');
                });
            })
            ->get();
    }

    Public function openModal($id)
    {
        $this->posyandu_portion_modal = true;
        $this->selected_posyandu = Posyandu::withSum('portions', 'bumil')
            ->withSum('portions', 'busui')
            ->withSum('portions', 'balita')
            ->find($id);
    }
};
?>

<div class="">
    {{-- MODAL --}}
    <x-modal wire:model="posyandu_portion_modal" title="Update Porsi" subtitle="{{ $selected_posyandu?->posyandu_name ?? 'Tidak ada sekolah' }}">
        <x-form no-separator>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-1">

                {{-- Porsi Ibu Hamil --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Busui
                    </div>

                    <x-input 
                        type="number"
                        wire:model="busui"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold text-primary">
                            {{ $selected_posyandu?->portions_sum_busui ?? 0 }}
                        </span>
                    </div>
                </div>

                {{-- Porsi Ibu Menyusui --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Bumil
                    </div>

                    <x-input 
                        type="number"
                        wire:model="bumil"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold text-secondary">
                            {{ $selected_posyandu?->portions_sum_bumil ?? 0 }}
                        </span>
                    </div>
                </div>

                {{-- Porsi Balita --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Porsi Balita
                    </div>

                    <x-input 
                        type="number"
                        wire:model="balita"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold">
                            {{ $selected_posyandu?->portions_sum_balita ?? 0 }}
                        </span>
                    </div>
                </div>

            </div>

            <x-slot:actions>
                <div class="flex justify-between w-full">

                    <x-button 
                        label="Cancel" 
                        class="btn-ghost"
                        @click="$wire.posyandu_portion_modal = false" 
                    />

                    <x-button 
                        label="Simpan Perubahan" 
                        class="btn-primary"
                        wire:click="updatePortions"
                        spinner
                    />

                </div>
            </x-slot:actions>

        </x-form>

    </x-modal>

    <x-breadcrumbs :items="$breadcrumbs" />

    {{-- Header --}}
    <x-header title="Posyandu" subtitle="Daftar posyandu penerima manfaat" separator>
        <x-slot:actions>
            <x-button link="{{ route('posyandu.portion') }}" route="posyandu.portion" label="Histori Porsi" />
            <x-button link="{{ route('posyandu.create') }}" route="posyandu.create" icon="o-plus" label="Tambah Posyandu" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- Filter & Search Section --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6">
        <x-input label="Cari Sekolah" icon="o-magnifying-glass" placeholder="Ketik nama sekolah..." wire:model="search" hint="{{ str(count($this->posyandus)) . ' posyandu ditemukan' }}" clearable>
            <x-slot:append>
                <x-button icon="o-magnifying-glass" class="join-item btn-primary" wire:click="getPosyanduPortionsProperty" />
            </x-slot:append>
        </x-input>
    </div>

    {{-- CARD ITEM --}}
    <div class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-2">
        @forelse ($this->posyandus as $posyandu)
        
        @php
            $bumil = $posyandu->portions_sum_bumil ?? 0;
            $busui = $posyandu->portions_sum_busui ?? 0;
            $balita = $posyandu->portions_sum_balita ?? 0;
        @endphp

        <x-list-item :item="$posyandu"
            class="bg-slate-100 rounded-2xl border border-slate-100 hover:shadow-md transition-all duration-200 p-4">

            {{-- MAIN INFO --}}
            <x-slot:value>
                <div class="space-y-1">
        
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $posyandu->posyandu_code }}
                        </span>
                    </div>
        
                    <h3 class="text-base font-semibold text-slate-800 leading-tight">
                        {{ $posyandu->posyandu_name }}
                    </h3>
        
                    <p class="text-xs text-slate-500 leading-snug max-w-xl text-wrap">
                        {{ $posyandu->address }}
                    </p>
        
                </div>
            </x-slot:value>

            {{-- STATS + KADER --}}
            <x-slot:sub-value>
                <div class="flex flex-col md:flex-row md:items-center gap-6 mt-3">
        
                    {{-- STAT CARD --}}
                    <div class="flex gap-4">
        
                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                BUMIL
                            </div>
                            <div class="text-lg font-semibold text-primary">
                                {{ $bumil }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                BUSUI
                            </div>
                            <div class="text-lg font-semibold text-primary">
                                {{ $busui }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                BALITA
                            </div>
                            <div class="text-lg font-semibold text-primary">
                                {{ $balita }}
                            </div>
                        </div>
        
                    </div>
        
                    {{-- KADER INFO --}}
                    <div class="text-xs text-right md:text-left">
                        <div class="text-slate-400 uppercase tracking-wide text-[10px]">
                            Kader
                        </div>
                        <div class="font-medium text-slate-700">
                            {{ $posyandu->cadre_name }}
                        </div>
                        <div class="text-slate-400">
                            {{ $posyandu->cadre_phone_number }}
                        </div>
                    </div>
        
                </div>
            </x-slot:sub-value>

            {{-- ACTIONS --}}
            <x-slot:actions>
                <x-dropdown>
                    
                    <x-slot:trigger>
                        <x-button 
                            icon="o-ellipsis-vertical" 
                            class="btn-circle btn-sm btn-ghost" 
                        />
                    </x-slot:trigger>

                    <x-menu-item 
                        title="Detail"
                        icon="o-eye"
                        link="{{ route('posyandu.detail', ['posyandu_id' => $posyandu->id]) }}"
                    />

                    <x-menu-item 
                        title="Edit"
                        icon="o-pencil"
                        link="{{ route('posyandu.edit', ['posyandu_id' => $posyandu->id]) }}"
                    />

                    <x-menu-item 
                        title="Update Porsi"
                        icon="o-cursor-arrow-ripple"
                        wire:click="openModal({{ $posyandu->id }})"
                    />
                    
                    <x-menu-item 
                        title="Hapus"
                        icon="o-trash"
                        wire:click="delete_posyandu({{ $posyandu->id }})"
                        wire:confirm="Yakin mau hapus sekolah ini?"
                        class="text-error"
                    />

                </x-dropdown>
            </x-slot:actions>
        


        </x-list-item>
        
        @empty
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 text-center py-12 text-slate-400">
            Belum ada data posyandu
        </div>
        @endforelse
    </div>

</div>
