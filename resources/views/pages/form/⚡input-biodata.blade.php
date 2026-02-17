<?php

use Livewire\Component;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use App\Enum\Gender;
use App\Enum\Religion;
use App\Enum\MarriedStatus;


new class extends Component
{
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

    public $isEdit = false;

    public function mount()
    {
        $biodata = UserInformation::where('user_id', Auth::id())->first();

        if ($biodata) {
            $this->fill($biodata->toArray());
            $this->isEdit = true;
        }
    }

    public function save()
    {
        
        $this->validate([
            'nik' => 'required|numeric|digits:16',
            'nomor_kk' => 'required|numeric|digits:16',
            'fullname' => 'required|string|max:255',
            'education' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'gender' => 'required',
            'religion' => 'required',
            'maried_status' => 'required',
            'province' => 'required',
            'regency' => 'required',
            'subdistrict' => 'required',
            'village' => 'required',
            'address' => 'required',
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
            ]
        );

        session()->flash('success', 'Biodata berhasil disimpan.');
        $this->isEdit = true;
    }
};
?>

<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-6 space-y-6">

    <div class="text-center">
        <h2 class="text-2xl font-bold text-gray-700">
            {{ $isEdit ? 'Edit Biodata' : 'Input Biodata' }}
        </h2>
        <p class="text-sm text-gray-500">
            Lengkapi data diri Anda dengan benar
        </p>
    </div>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="grid grid-cols-2 gap-4">

        <div>
            <label>NIK</label>
            <input type="text" wire:model="nik" class="w-full border rounded-lg p-2">
            @error('nik') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Nomor KK</label>
            <input type="text" wire:model="nomor_kk" class="w-full border rounded-lg p-2">
            @error('nomor_kk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div class="col-span-2">
            <label>Nama Lengkap</label>
            <input type="text" wire:model="fullname" class="w-full border rounded-lg p-2">
            @error('fullname') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
        <div>
            <label>Tempat Lahir</label>
            <input type="text" wire:model="place_of_birth" class="w-full border rounded-lg p-2">
            @error('place_of_birth') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    
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
    
        <div class="col-span-2">
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg">
                Simpan
            </button>
        </div>
    
    </form>
    
</div>
