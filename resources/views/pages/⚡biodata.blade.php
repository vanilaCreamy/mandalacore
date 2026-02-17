<?php

use Livewire\Component;

new class extends Component
{
    public $user;

    public $activeTab = 'personal';

    public array $informasi_personal = [
        'NIK' => '3207023011010001',
        'Nomor KK' => '3207023453450004',
        'Nama Lengkap' => 'Dani Nugraha',
        'Gelar Belakang' => 'S.Ak.',
        'Pendidikan' => 'D-iv/s-1 Akuntansi',
        'Posisi' => 'Penata Layanan Operasional Keuangan',
        'Tempat, Tgl Lahir' => 'Kabupaten Ciamis, 30 November 2001',
        'Agama' => 'Islam',
        'Jenis Kelamin' => 'Pria',
        'Status Kawin' => 'Belum Kawin',
        'NPWP' => '3207023011010001',
        'No Hp' => '085624611146',
        'Ukuran Baju' => 'L',
        'Email' => 'nugrahaadani563@gmail.com',
        'Alamat Sesuai KTP' => 'Dusun Ranji Rata Rt18/Rw06, Desa Cimari, Kecamatan Cikoneng, Kabupaten Ciamis, Provinsi Jawa Barat',
        'Alamat Domisili' => 'Dusun Ranji Rata Rt18/Rw06, Desa Cimari, Kecamatan Cikoneng, Kabupaten Ciamis, Provinsi Jawa Barat',
    ];

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function mount()
    {
        $this->user = Auth::user();
    }
};
?>

<div class="max-w-6xl mx-auto shadow-xl rounded-2xl space-y-6">
    
    {{-- BANNER --}}
    <div class="bg-white">
        <div class="w-full relative overflow-hidden h-56 flex justify-center items-center text-2xl bg-gray-200 font-medium text-gray-400">
            <img src="{{ asset('images/bg_v2.webp') }}" alt="banner" height="150" class="block w-full h-full object-cover">
            <p class="absolute top-0 right-0 px-2 opacity-35 z-50 text-xs text-slate-700">Terakhir Diperbarui {{ $user->updated_at }}</p>
        </div>
        <div class="flex items-center gap-6 px-6">
            <img src="{{ asset('images/avatars.png') }}" alt="LOGO" height="150" width="150" class="bg-gray-200 rounded-md -translate-y-8">
            <div class="w-full text-xs">
                <h2 class="font-medium text-2xl mb-2">{{ $user->name }}</h2>
                <ul class="flex items-center gap-2">
                    <li class="w-full p-2 flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                        <p>3207023011010001</p>
                    </li>
                    <li class="w-full p-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <p>{{ $user->role->label() }}</p>
                    </li>
                    <li class="w-full p-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                        </svg>                          
                        <p>{{ $user->created_at }}</p>
                    </li>
                </ul>
            </div>
            <div class="w-fit">
                <button class="bg-amber-500 text-white px-3 py-1 rounded-md flex items-center gap-2 text-sm whitespace-nowrap shadow-md hover:bg-amber-600 active:bg-amber-700">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         fill="none" 
                         viewBox="0 0 24 24" 
                         stroke-width="1.5" 
                         stroke="currentColor" 
                         class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
            
                    <a href="/biodata/update">Pembaruan Data</a>
            
                </button>
            </div>
        </div>
        
    </div>

    {{-- TAB --}}
    <div class="w-full bg-white">

        {{-- TAB HEADER --}}
        <div class="border-gray-200 bg-slate-200">
            <nav class="flex flex-wrap">
    
                @php
                    $tabs = [
                        'personal' => 'Informasi Personal',
                        'education' => 'Pendidikan',
                        'family' => 'Keluarga',
                        'sppg' => 'SPPG',
                        'payroll' => 'Payroll',
                        'document' => 'Dokumen',
                    ];
                @endphp
    
                @foreach ($tabs as $key => $label)
                    <button
                        wire:click="setTab('{{ $key }}')"
                        class="px-4 py-2 text-sm font-medium transition
                        {{ $activeTab === $key
                            ? 'bg-white text-slate-700'
                            : 'text-gray-600 hover:text-slate-700 hover:bg-gray-100' }}">
                        {{ $label }}
                    </button>
                @endforeach
    
            </nav>
        </div>
    
        {{-- TAB CONTENT --}}
        <div class="p-6 bg-white border border-gray-300 rounded-b-lg shadow-sm">
    
            @if ($activeTab === 'personal')
            <div>
                <ul class="text-sm grid grid-cols-2 gap-4">
                    @foreach ($informasi_personal as $key => $value)
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">{{ $key }}</h5>
                        <span class="text-md">{{ $value }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
    
            @if ($activeTab === 'education')
                <div>
                    <h2 class="text-lg font-semibold mb-4">Pendidikan</h2>
                    <p>Data pendidikan...</p>
                </div>
            @endif
    
            @if ($activeTab === 'family')
                <div>
                    <h2 class="text-lg font-semibold mb-4">Keluarga</h2>
                    <p>Data keluarga...</p>
                </div>
            @endif
    
            @if ($activeTab === 'sppg')
                <div>
                    <ul class="text-sm">
                        <li>
                            <h5 class="text-slate-500 text-sm">ID SPPG</h5>
                            <span class="">ZBBERJFS</span>
                        </li>
                    </ul>
                    <ul class="text-sm">
                        <li>
                            <h5 class="text-slate-500 text-sm">No SK</h5>
                            <span class="">235.1.2025 SPECTRO - 7553</span>
                        </li>
                    </ul>
                </div>
            @endif
    
            @if ($activeTab === 'payroll')
                <div>
                    <h2 class="text-lg font-semibold mb-4">Payroll</h2>
                    <p>Data payroll...</p>
                </div>
            @endif
    
            @if ($activeTab === 'document')
                <div>
                    <h2 class="text-lg font-semibold mb-4">Dokumen</h2>
                    <p>Upload dan kelola dokumen...</p>
                </div>
            @endif
    
        </div>
    
    </div>
</div>