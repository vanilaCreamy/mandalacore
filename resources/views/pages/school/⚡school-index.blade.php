<?php

use Livewire\Component;
use App\Models\School;
use App\Models\SchoolPortion;
use App\Enums\SchoolLevel;

new class extends Component
{
    public $small_portions;
    public $big_portions;
    public $teacher_portions;
    public $non_teacher_portions;

    public $school_portion_modal = false;
    public $selected_school;

    public $breadcrumbs = [];
    public $search = '';
    public $level = '';

    public function mount()
    {
        $this->schools = School::withSum('portions', 'small_portions')
        ->withSum('portions', 'big_portions')
        ->withSum('portions', 'teacher_portions')
        ->withSum('portions', 'non_teacher_portions')
        ->get();
        
        $this->school_portions = SchoolPortion::all();
        
        $this->breadcrumbs = [
            ['icon' => 's-home', 'link' => route('dashboard')],
            ['label' => 'Sekolah'],
        ];
    }

    public function savePortion($id)
    {
        SchoolPortion::create([
            'school_id' => $id,
            'small_portions' => $this->small_portions ?? 0 ,
            'big_portions' => $this->big_portions ?? 0,
            'teacher_portions' => $this->teacher_portions ?? 0,
            'non_teacher_portions' => $this->non_teacher_portions ?? 0,
        ]);

        
        $this->reset([
            'small_portions',
            'big_portions',
            'teacher_portions',
            'non_teacher_portions',
        ]);

        $this->selected_school = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->find($id);
    }

    public function delete_school($id)
    {
        $sch = School::find($id);

        $sch->delete();
    }

    public function getSchoolsProperty()
    {
        return School::query()
            ->when($this->search, function ($query) {
                $query->where('school_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->level, function ($query) {
                $query->where('school_level', $this->level);
            })
            ->withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->get();
    }

    public function getLevelOptionsProperty()
    {
        return collect(SchoolLevel::cases())->map(fn ($level) => [
            'value' => $level->name,
            'label' => $level->label(),
        ]);
    }

    public function getSchoolPortionsProperty()
    {
        return SchoolPortion::query()
            ->when($this->search, function ($query) {
                $query->whereHas('school', function ($q) {
                    $q->where('school_name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->level, function ($query) {
                $query->whereHas('school', function ($q) {
                    $q->where('school_level', $this->level);
                });
            })
            ->get();
    }

    public function openModal($id)
    {
        $this->school_portion_modal = true;
        $this->selected_school = School::withSum('portions', 'small_portions')
            ->withSum('portions', 'big_portions')
            ->withSum('portions', 'teacher_portions')
            ->withSum('portions', 'non_teacher_portions')
            ->find($id);
    }
};
?>

<div>
    {{-- MODAL --}}
    <x-modal wire:model="school_portion_modal" title="Update Porsi" subtitle="{{ $selected_school?->school_name ?? 'Tidak ada sekolah' }}">
        <x-form no-separator>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1">

                {{-- Porsi Kecil --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Porsi Kecil
                    </div>

                    <x-input 
                        type="number"
                        wire:model="small_portions"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold text-primary">
                            {{ $selected_school?->portions_sum_small_portions ?? 0 }}
                        </span>
                    </div>
                </div>

                {{-- Porsi Besar --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Porsi Besar
                    </div>

                    <x-input 
                        type="number"
                        wire:model="big_portions"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold text-secondary">
                            {{ $selected_school?->portions_sum_big_portions ?? 0 }}
                        </span>
                    </div>
                </div>

                {{-- Porsi Guru --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Porsi Guru
                    </div>

                    <x-input 
                        type="number"
                        wire:model="teacher_portions"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold">
                            {{ $selected_school?->portions_sum_teacher_portions ?? 0 }}
                        </span>
                    </div>
                </div>

                {{-- Porsi Non Guru --}}
                <div class="bg-slate-50 rounded-xl p-1 space-y-2">
                    <div class="text-xs uppercase tracking-wide text-slate-400">
                        Porsi Non Guru
                    </div>

                    <x-input 
                        type="number"
                        wire:model="non_teacher_portions"
                        icon="o-chevron-up-down"
                        placeholder="0"
                    />

                    <div class="text-xs text-slate-500">
                        Saat ini:
                        <span class="font-semibold">
                            {{ $selected_school?->portions_sum_non_teacher_portions ?? 0 }}
                        </span>
                    </div>
                </div>

            </div>

            <x-slot:actions>
                <div class="flex justify-between w-full">

                    <x-button 
                        label="Cancel" 
                        class="btn-ghost"
                        @click="$wire.school_portion_modal = false" 
                    />

                    <x-button 
                        label="Simpan Perubahan" 
                        class="btn-primary"
                        wire:click="savePortion({{ $selected_school?->id }})"
                        spinner
                    />

                </div>
            </x-slot:actions>

        </x-form>

    </x-modal>

    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Sekolah" subtitle="Daftar sekolah penerima manfaat" separator>
        <x-slot:actions>
            <x-button link="{{ route('school.portion') }}" route="school.portion" label="Histori Porsi" />
            <x-button link="{{ route('school.create') }}" route="school.create" icon="o-plus" label="Tambah Sekolah" class="btn-primary" />
        </x-slot:actions>
    </x-header>

    {{-- Filter & Search Section --}}
    <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-100 mb-6">

        <div class="grid md:grid-cols-4 gap-4 items-start">

            {{-- Search --}}
            <span class="col-span-3">
                <x-input label="Cari Sekolah" icon="o-magnifying-glass" placeholder="Ketik nama sekolah..." wire:model="search" hint="{{ str(count($this->schools)) . ' sekolah ditemukan' }}" clearable>
                    <x-slot:append>
                        {{-- Add `join-item` to all appended elements --}}
                        <x-button icon="o-magnifying-glass" class="join-item btn-primary" wire:click="getSchoolPortionsProperty" />
                    </x-slot:append>
                </x-input>
                
            </span>

            {{-- Filter Level --}}
            <x-select
                label="Filter Tingkatan"
                wire:model.live="level"
                :options="$this->levelOptions"
                option-value="value"
                option-label="label"
                placeholder="Semua Tingkatan"
            />

        </div>

    </div>

    {{-- TABLE (Desktop) --}}
    
    <div class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-2">

        @forelse ($this->schools as $school)
        
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
        
        <x-list-item :item="$school"
            class="bg-slate-100 rounded-2xl border border-slate-100 hover:shadow-md transition-all duration-200 p-4">
        
            {{-- LEVEL BADGE --}}
            {{-- <x-slot:avatar>
                <div class="flex items-center justify-center w-16">
                    <x-badge 
                        value="{{ $school->school_level->label() }}" 
                        class="badge-primary badge-soft text-xs px-3 py-2" 
                    />
                </div>
            </x-slot:avatar> --}}
        
            {{-- MAIN INFO --}}
            <x-slot:value>
                <div class="space-y-1">
        
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-400 font-medium">
                            {{ $school->school_code }}
                        </span>
        
                        <div class="w-1 h-1 bg-slate-300 rounded-full"></div>
        
                        <span class="text-xs text-white bg-blue-500 rounded-xl p-1">
                            {{ $school->school_level->label() }}
                        </span>
                    </div>
        
                    <h3 class="text-base font-semibold text-slate-800 leading-tight">
                        {{ $school->school_name }}
                    </h3>
        
                    <p class="text-xs text-slate-500 leading-snug max-w-xl text-wrap">
                        {{ $school->address }}
                    </p>
        
                </div>
            </x-slot:value>
        
            {{-- STATS + PIC --}}
            <x-slot:sub-value>
                <div class="flex flex-col md:flex-row md:items-center gap-6 mt-3">
        
                    {{-- STAT CARD --}}
                    <div class="flex gap-4">
        
                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                PK
                            </div>
                            <div class="text-lg font-semibold text-primary">
                                {{ $smallFinal }}
                            </div>
                        </div>
        
                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                PB
                            </div>
                            <div class="text-lg font-semibold text-secondary">
                                {{ $bigFinal }}
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl px-4 py-3 text-center min-w-[80px]">
                            <div class="text-[10px] uppercase tracking-wide text-slate-400">
                                TP / @if ($big != 0) PB @else PK @endif
                            </div>
                            <div class="text-lg font-semibold text-secondary">
                                {{ $tambahan }}
                            </div>
                        </div>
        
                    </div>
        
                    {{-- PIC INFO --}}
                    <div class="text-xs text-right md:text-left">
                        <div class="text-slate-400 uppercase tracking-wide text-[10px]">
                            PIC
                        </div>
                        <div class="font-medium text-slate-700">
                            {{ $school->pic_name }}
                        </div>
                        <div class="text-slate-400">
                            {{ $school->pic_phone_number }}
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
                        link="{{ route('school.view', ['school_id' => $school->id]) }}"
                    />

                    <x-menu-item 
                        title="Edit"
                        icon="o-pencil"
                        link="{{ route('school.edit', ['school_id' => $school->id]) }}"
                    />

                    <x-menu-item 
                        title="Update Porsi"
                        icon="o-cursor-arrow-ripple"
                        wire:click="openModal({{ $school->id }})"
                    />
                    
                    <x-menu-item 
                        title="Hapus"
                        icon="o-trash"
                        wire:click="delete_school({{ $school->id }})"
                        wire:confirm="Yakin mau hapus sekolah ini?"
                        class="text-error"
                    />

                </x-dropdown>
            </x-slot:actions>

        
        </x-list-item>
        
        @empty
        
        <div class="bg-white rounded-2xl border border-dashed border-slate-200 text-center py-12 text-slate-400">
            Belum ada data sekolah
        </div>
        
        @endforelse
        
    </div>

</div>