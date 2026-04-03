<?php

use Livewire\Component;
use App\Models\UserInformation;

new class extends Component
{
    public $breadcrumbs = [];
    public $selectedTab = 'umum';

    public $user;
    public $user_information;

    public $activeTab = 'personal';
    
    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function mount()
    {
        $this->user = Auth::user();

        $this->user_information = UserInformation::where('user_id', $this->user->id)->first();

        if ($this->user_information === null){
            $this->user_information = UserInformation::updateOrCreate(['user_id'=>$this->user->id]);
        }

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Biodata', 'link' => route('biodata')],
        ];

        // $this->selectedTab   
    }
};
?>

<div class="rounded-2xl">
    <x-breadcrumbs :items="$breadcrumbs" />
    
    {{-- BANNER --}}
    <div class="">
        <div class="w-full relative overflow-hidden h-56 flex justify-center items-center text-2xl bg-gray-200 font-medium text-gray-400">
            <img src="{{ asset('images/bg_v2.webp') }}" alt="banner" height="150" class="block w-full h-full object-cover">
            <p class="absolute top-0 right-0 px-2 opacity-35 text-xs text-slate-700">{{ $this->user_information->updated_at }} {{ $user->updated_at }}</p>
        </div>
        <div class="flex flex-col items-center md:flex-row gap-2 md:gap-6 px-6">
            {{-- <img src="{{ asset('images/avatars.png') }}" alt="LOGO" height="150" width="150" class="bg-gray-200 rounded-md -translate-y-8"> --}}
            @php
                $user = auth()->user();
                $jpg = 'profile/' . $user->id . '.jpg';
                $png = 'profile/' . $user->id . '.png';
            @endphp

            <img 
            src="{{ 
                Storage::disk('public')->exists($jpg) 
                    ? asset('storage/'.$jpg) 
                    : (Storage::disk('public')->exists($png) 
                        ? asset('storage/'.$png) 
                        : asset('images/ava-md.png')) 
            }}" 
            alt="Profile" 
            height="150" 
            width="150" 
            class="bg-gray-200 rounded-md -translate-y-8 object-cover">

            <div class="w-full text-xs">
                <div class="flex flex-col gap-1 md:flex-row md:gap-2">
                    <h2 class="font-medium text-2xl mb-2 text-center md:text-left">{{ $user->name }}</h2>
                    <x-button link="{{ route('form.biodata') }}" icon="o-pencil" label="Update" class="btn-warning btn-xs btn-outline" />
                </div>
                <ul class="flex flex-col md:flex-row items-center gap-2">
                    <li class="w-full p-2 flex gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z" />
                        </svg>
                        <p>{{ $this->user_information->nik }}</p>
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
                        <p>{{ $user_information->joined_date ?? '-' }}</p>
                    </li>
                </ul>
            </div>
        </div>
        
    </div>

    <x-tabs wire:model="selectedTab">
        <x-tab name="umum" label="Data Personal" icon="o-users">
            <div>
                <ul class="text-sm grid grid-cols-2 gap-4">
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">NIK</h5>
                        <span class="text-md">{{ $user_information->nik ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Nomor KK</h5>
                        <span class="text-md">{{ $user_information->nomor_kk ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Nama Lengkap</h5>
                        <span class="text-md">{{ $user_information->fullname ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Pendidikan</h5>
                        <span class="text-md">{{ $user_information->education ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Tempat Lahir</h5>
                        <span class="text-md">{{ $user_information->place_of_birth ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Tanggal Lahir</h5>
                        <span class="text-md">{{ $user_information->date_of_birth ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Nomor Handphone</h5>
                        <span class="text-md">{{ $user_information->phone_number ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Ukuran Baju</h5>
                        <span class="text-md">{{ $user_information->shirt_size ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Jenis Kelamin</h5>
                        <span class="text-md">{{ $user_information->gender?->label() ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Agama</h5>
                        <span class="text-md">{{ $user_information->religion?->label() ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Status Kawin</h5>
                        <span class="text-md">{{ $user_information->maried_status?->label() ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Provinsi</h5>
                        <span class="text-md">{{ $user_information->province ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Kabupaten</h5>
                        <span class="text-md">{{ $user_information->regency ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Kecamatan</h5>
                        <span class="text-md">{{ $user_information->subdistrict ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Desa</h5>
                        <span class="text-md">{{ $user_information->village ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Alamat</h5>
                        <span class="text-md">{{ $user_information->address ?? '-' }}</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Tanggal Masuk</h5>
                        <span class="text-md">{{ $user_information->joined_date ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </x-tab>
        <x-tab name="sppg" label="SPPG" icon="o-sparkles">
            <div>
                <ul class="text-sm grid grid-cols-2 gap-4">
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">ID SPPG</h5>
                        <span class="text-md">ZBBERJFS</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">No SK</h5>
                        <span class="text-md">235.1.2025 Mandala - 7553</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">SPPG</h5>
                        <span class="text-md">SPPG Ciamis Panjalu Kertamandala 2</span>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Alamat SPPG</h5>
                        <span class="text-md">Kertamandala, Kecamatan Panjalu, Kabupaten Ciamis, Provinsi Jawa Barat</span>
                    </li>
                    <li>
                        {{-- <h5 class="text-slate-500 text-xs font-semibold">Status</h5> --}}
                        <span class="text-md bg-lime-500 text-white rounded-md px-2 py-1">AKTIF</span>
                    </li>
                </ul>
            </div>
        </x-tab>
        <x-tab name="payroll" label="Payroll" icon="o-banknotes">
            <div>
                <ul class="text-sm grid grid-cols-1 gap-4">
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Nama Bank</h5>
                        <div class=" flex items-center justify-between p-1 max-w-xl border border-slate-500 rounded-md">
                            <span class="text-md">BANK REPUBLIK INDONESIA (BRI)</span>
                            <img src="{{ asset('/images/logo_bri.png') }}" alt="" class="w-10">
                        </div>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Nomor Rekening</h5>
                        <div class=" flex items-center justify-between p-1 max-w-xl border border-slate-500 rounded-md">
                            <span class="text-md">{{ $user_information->account_number ?? '-' }}</span>
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 8.25V6a2.25 2.25 0 0 0-2.25-2.25H6A2.25 2.25 0 0 0 3.75 6v8.25A2.25 2.25 0 0 0 6 16.5h2.25m8.25-8.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-7.5A2.25 2.25 0 0 1 8.25 18v-1.5m8.25-8.25h-6a2.25 2.25 0 0 0-2.25 2.25v6" />
                                </svg>                                  
                            </button>
                        </div>
                    </li>
                    <li>
                        <h5 class="text-slate-500 text-xs font-semibold">Nama Pemilik Rekening</h5>
                        <div class=" flex items-center justify-between p-1 max-w-xl border border-slate-500 rounded-md">
                            <span class="text-md">{{ $user_information->account_owner_name ?? '-' }}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </x-tab>
    </x-tabs>


    <div class="h-screen"></div>

</div>