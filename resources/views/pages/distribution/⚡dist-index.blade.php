<?php

use Livewire\Component;
use App\Models\Posyandu;
use App\Models\School;
use App\Models\PosyanduDelivery;
use App\Models\SchoolDelivery;

new class extends Component
{
    public $selectedDate;

    public function mount()
    {
        $this->selectedDate = now()->toDateString();
    }

    public function getPosyandusProperty()
    {
        return Posyandu::orderBy('posyandu_name')->get();
    }

    public function getSchoolsProperty()
    {
        return School::orderBy('school_name')->get();
    }

    /* ======================
       STATUS CHECKER
    =======================*/

    public function getPosyanduStatus($posyanduId)
    {
        $logs = PosyanduDelivery::where('posyandu_id', $posyanduId)
            ->whereDate('timestamp', $this->selectedDate)
            ->get();

        if ($logs->isEmpty()) {
            return 'belum';
        }

        $hasBerangkat = $logs->where('flow', 'berangkat')->count();
        $hasTiba = $logs->where('flow', 'tiba')->count();

        if ($hasBerangkat && $hasTiba) {
            return 'terkirim';
        }

        return 'diperjalanan';
    }

    public function getSchoolStatus($schoolId)
    {
        $logs = SchoolDelivery::where('school_id', $schoolId)
            ->whereDate('timestamp', $this->selectedDate)
            ->get();

        if ($logs->isEmpty()) {
            return 'belum';
        }

        $hasBerangkat = $logs->where('flow', 'berangkat')->count();
        $hasTiba = $logs->where('flow', 'tiba')->count();

        if ($hasBerangkat && $hasTiba) {
            return 'terkirim';
        }

        return 'diperjalanan';
    }
};
?>

<div 
    x-data="{ tab: 'posyandu' }"
    class="p-4 sm:p-6 md:p-8 bg-gray-50 min-h-screen">

    <x-header title="Default size" subtitle="With subtitle and separator" />
    <x-breadcrumbs :items="[['label' => 'Home','icon' => 's-home'],['label' => 'Distribusi'], ['label' => 'Daftar']]" separator="o-slash" />
    <x-breadcrumbs :items="[['label' => 'Home'],['label' => 'Distribusi'], ['label' => 'Daftar']]" />
    <x-breadcrumbs :items="[['label' => 'Home'],['label' => 'Distribusi'], ['label' => 'Daftar']]" />
    <x-breadcrumbs :items="[['label' => 'Home'],['label' => 'Distribusi'], ['label' => 'Daftar']]" />

    {{-- HEADER --}}
    <div class="mb-6 grid grid-cols-2 items-center">
        <div class="">
            <h1 class="text-xl md:text-2xl font-bold text-gray-800">
                Manajemen Distribusi
            </h1>
            <p class="text-gray-500 text-sm">
                Monitoring status pengiriman berdasarkan tanggal
            </p>
        </div>
        <div class="flex items-center gap-2 justify-end">
            <a href="{{ route('distribution.road-route') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
                <span>Rute Distribusi</span>
            </a>
        </div>
    </div>

    {{-- DATE INPUT --}}
    <div class="mb-6">
        <input type="date"
            wire:model.live="selectedDate"
            class="border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        {{-- TAB HEADER --}}
        <div class="flex border-b border-gray-100">
            <button 
                @click="tab = 'posyandu'"
                :class="tab === 'posyandu' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'text-gray-500'"
                class="px-6 py-4 font-medium border-b-2 transition">
                Posyandu
            </button>

            <button 
                @click="tab = 'school'"
                :class="tab === 'school' ? 'border-blue-600 text-blue-600 bg-blue-50' : 'text-gray-500'"
                class="px-6 py-4 font-medium border-b-2 transition">
                Sekolah
            </button>
        </div>

        <div class="p-6">

            {{-- POSYANDU --}}
            <div x-show="tab === 'posyandu'" x-transition>
                <div class="space-y-3">
                    @foreach ($this->posyandus as $posyandu)

                        @php $status = $this->getPosyanduStatus($posyandu->id); @endphp

                        <div class="flex justify-between items-center p-4 border rounded-xl">

                            <span class="font-medium text-gray-800">
                                {{ $posyandu->posyandu_name }}
                            </span>

                            @if ($status === 'belum')
                                <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                    Belum Dikirim
                                </span>
                            @elseif ($status === 'diperjalanan')
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Diperjalanan
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Terkirim
                                </span>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SCHOOL --}}
            <div x-show="tab === 'school'" x-transition>
                <div class="space-y-3">
                    @foreach ($this->schools as $school)

                        @php $status = $this->getSchoolStatus($school->id); @endphp

                        <div class="flex justify-between items-center p-4 border rounded-xl">

                            <span class="font-medium text-gray-800">
                                {{ $school->school_name }}
                            </span>

                            @if ($status === 'belum')
                                <span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">
                                    Belum Dikirim
                                </span>
                            @elseif ($status === 'diperjalanan')
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700">
                                    Diperjalanan
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">
                                    Terkirim
                                </span>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
