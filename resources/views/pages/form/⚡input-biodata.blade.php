<?php

use Livewire\Component;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use App\enum\Gender;
use App\enum\Religion;
use App\enum\MarriedStatus;


new class extends Component
{
    public $breadcrumbs =[];

    public $nik;
    public $nomor_kk;
    public $fullname;
    public $education;
    public $place_of_birth;
    public $date_of_birth;
    public $phone_number;
    public $shirt_size;
    public $gender;
    public $religion;
    public $maried_status;
    public $province;
    public $regency;
    public $subdistrict;
    public $village;
    public $address;
    public $joined_date;

    public $isEdit = false;

    public function mount()
    {
        $biodata = UserInformation::where('user_id', Auth::id())->first();

        if ($biodata) {
            $this->fill($biodata->toArray());
            $this->isEdit = true;
        }

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'biodata', 'link' => route('biodata')],
            ['label' => 'Update'],
        ];
    }

    public function save()
    {
        
        $this->validate([
            'nik' => 'nullable|numeric|digits:16|unique:user_informations,nik,'. Auth::id(),
            'nomor_kk' => 'nullable|numeric|digits:16',
            'fullname' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable|string|max:15',
            'gender' => 'nullable',
            'religion' => 'nullable',
            'maried_status' => 'nullable',
            'province' => 'nullable',
            'regency' => 'nullable',
            'subdistrict' => 'nullable',
            'village' => 'nullable',
            'address' => 'nullable',
            'joined_date' => 'nullable',
        ]) ;

        UserInformation::updateOrCreate(
            ['user_id' => Auth::id()], // 1 user hanya 1 biodata
            [
                'nik' => $this->nik,
                'nomor_kk' => $this->nomor_kk,
                'fullname' => $this->fullname,
                'education' => $this->education,
                'place_of_birth' => $this->place_of_birth,
                'date_of_birth' => $this->date_of_birth,
                'phone_number' => $this->phone_number,
                'shirt_size' => $this->shirt_size,
                'gender' => $this->gender,
                'religion' => $this->religion,
                'maried_status' => $this->maried_status,
                'province' => $this->province,
                'regency' => $this->regency,
                'subdistrict' => $this->subdistrict,
                'village' => $this->village,
                'address' => $this->address,
                'joined_date' => $this->joined_date,
            ]
        );

        session()->flash('success', 'Biodata berhasil disimpan.');
        $this->isEdit = true;

        redirect('/biodata');
    }
};
?>

<div class="">
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Edit Biodata" subtitle="Lengkapi data diri anda dengan benar" />

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-4">
        <x-input label="NIK" wire:model="nik" placeholder="320..." icon="o-credit-card" hint="16 Digit Nomor Induk Kependudukan" />
        <x-input label="Nomor kk" wire:model="nik" placeholder="320..." icon="o-credit-card" hint="Nomor Kartu Keluarga" />
        <div class="col-span-2">
            <x-input label="Nama Lengkap" wire:model="fullname" placeholder="..." icon="o-user" hint="Nama lengkap sesuai dengan yang ada pada ktp" />
        </div>
        <x-input label="Tempat Lahir" wire:model="place_of_birth" placeholder="..." icon="o-map-pin" />
        <x-datetime label="Tanggal Lahir" wire:model="date_of_birth" icon="o-calendar-days" />
    
        <div>
            <label>Tanggal Lahir</label>
            <input type="date" wire:model="date_of_birth" class="w-full border rounded-lg p-2">
            @error('date_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>No HP</label>
            <input type="text" wire:model="phone_number" class="w-full border rounded-lg p-2">
            @error('phone_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Pendidikan</label>
            <input type="text" wire:model="education" class="w-full border rounded-lg p-2">
            @error('education') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Jenis Kelamin</label>
            <select wire:model="gender" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih --</option>
                @foreach (Gender::cases() as $item)
                    <option value="{{ $item->name }}">{{ $item->label() }}</option>
                @endforeach
            </select>
            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Agama</label>
            <select wire:model="religion" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih --</option>
                @foreach (Religion::cases() as $item)
                    <option value="{{ $item->name }}">{{ $item->label() }}</option>
                @endforeach
            </select>
            @error('religion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Status Pernikahan</label>
            <select wire:model="maried_status" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih --</option>
                @foreach (MarriedStatus::cases() as $item)
                    <option value="{{ $item->name }}">{{ $item->label() }}</option>
                @endforeach
            </select>
            @error('maried_status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Ukuran Baju</label>
            <select wire:model="shirt_size" class="w-full border rounded-lg p-2">
                <option value="">-- Pilih --</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select>
            @error('shirt_size') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div class="col-span-2">
            <label>Alamat</label>
            <textarea wire:model="address" class="w-full border rounded-lg p-2"></textarea>
            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Provinsi</label>
            <input type="text" wire:model="province" class="w-full border rounded-lg p-2">
            @error('province') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Kabupaten</label>
            <input type="text" wire:model="regency" class="w-full border rounded-lg p-2">
            @error('regency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Kecamatan</label>
            <input type="text" wire:model="subdistrict" class="w-full border rounded-lg p-2">
            @error('subdistrict') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Desa</label>
            <input type="text" wire:model="village" class="w-full border rounded-lg p-2">
            @error('village') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label>Tanggal Masuk</label>
            <input type="date" wire:model="joined_date" class="w-full border rounded-lg p-2">
            @error('village') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div class="col-span-2">
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg">
                Simpan
            </button>
        </div>
    
    </form>
    
</div>
