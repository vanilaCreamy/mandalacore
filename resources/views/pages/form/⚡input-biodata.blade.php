<?php

use Livewire\Component;
use App\Models\UserInformation;
use Illuminate\Support\Facades\Auth;
use App\Enums\Gender;
use App\Enums\Religion;
use App\Enums\MarriedStatus;
use App\Enums\EducationLevel;
use App\Enums\ShirtSize;


new class extends Component
{
    public $breadcrumbs =[];

    // ENUM
    public $enum_education_level; 
    public $enum_gender; 
    public $enum_maried_status; 
    public $enum_religion;
    public $enum_shirt_size;

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

        $this->enum_education_level = EducationLevel::options();
        $this->enum_gender = Gender::options();
        $this->enum_maried_status = MarriedStatus::options(); 
        $this->enum_religion = Religion::options();
        $this->enum_shirt_size = ShirtSize::options();

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
            'nik' => 'nullable|numeric',
            'nomor_kk' => 'nullable|numeric',
            'fullname' => 'nullable|string|max:255',
            'education' => 'nullable|string',
            'place_of_birth' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'phone_number' => 'nullable|numeric',
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

    <x-form wire:submit.prevent="save">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input label="NIK" wire:model="nik" placeholder="320..." icon="o-credit-card" hint="16 Digit Nomor Induk Kependudukan" />
            <x-input label="Nomor kk" wire:model="nomor_kk" placeholder="320..." icon="o-credit-card" hint="Nomor Kartu Keluarga" />
            <div class="col-span-1 md:col-span-2">
                <x-input label="Nama Lengkap" wire:model="fullname" placeholder="..." icon="o-user" hint="Nama lengkap sesuai dengan yang ada pada ktp" />
            </div>
            <x-input label="Tempat Lahir" wire:model="place_of_birth" placeholder="..." icon="o-map-pin" />
            <x-datetime label="Tanggal Lahir" wire:model="date_of_birth" icon="o-calendar-days" />
            <x-input label="Nomor Telepon" wire:model="phone_number" placeholder="" icon="o-phone" />

            <x-select label="Pendidikan" wire:model="education" :options="$this->enum_education_level" placeholder="-- Pilih --" icon="o-user" />
            <x-select label="Jenis Kelamin" wire:model="gender" :options="$this->enum_gender" placeholder="-- Pilih --" icon="o-user" />
            <x-select label="Agama" wire:model="religion" :options="$this->enum_religion" placeholder="-- Pilih --" icon="o-user" />
            <x-select label="Status Pernikahan" wire:model="maried_status" :options="$this->enum_maried_status" placeholder="-- Pilih --" icon="o-user" />
            <x-select label="Ukuran Baju" wire:model="shirt_size" :options="$this->enum_shirt_size" placeholder="-- Pilih --" icon="o-user" />
            
            <div class="col-span-1 md:col-span-2">
                <x-textarea label="Alamat" wire:model="address" placeholder="..." rows="3" />
            </div>

            <x-input label="Provinsi" wire:model="province" placeholder="" />
            <x-input label="Kabupaten" wire:model="regency" placeholder="" />
            <x-input label="Kecamatan" wire:model="subdistrict" placeholder="" />
            <x-input label="Desa" wire:model="village" placeholder="" />

            <x-datetime label="Tanggal Masuk" wire:model="joined_date" icon="o-calendar-days" />
        </div>

        <x-slot:actions>
            <x-button label="Simpan" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>

    </x-form>
    
</div>
