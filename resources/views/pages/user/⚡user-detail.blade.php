<?php

use Livewire\Component;
use App\Models\User;

new class extends Component
{
    public $breadcrumbs = [];

    public $user;
    public $profilePhoto;

    public function mount($user_id)
    {
        $this->user = User::with('information')->findOrFail($user_id);

        $jpg = 'profile/' . $this->user->id . '.jpg';
        $png = 'profile/' . $this->user->id . '.png';

        if (Storage::disk('public')->exists($jpg)) {
            $this->profilePhoto = asset('storage/' . $jpg);
        } elseif (Storage::disk('public')->exists($png)) {
            $this->profilePhoto = asset('storage/' . $png);
        } else {
            $this->profilePhoto = asset('images/pic-default.jpg');
        }

        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Pengguna', 'link' => route('user.view')],
            ['label' => $this->user->name]
        ];
    }
};
?>

<div class="max-w-5xl mx-auto space-y-6">
    <x-breadcrumbs :items="$breadcrumbs" />

    {{-- ================= PROFILE CARD ================= --}}
    <div class="bg-white rounded-2xl shadow-sm p-6 mb-2">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

            {{-- Foto Profile --}}
            <div class="w-32 h-32 rounded-full overflow-hidden border border-slate-200 shadow-sm">
                <img 
                    src="{{ $profilePhoto }}" 
                    alt="Foto {{ $user->name }}"
                    class="w-full h-full object-cover"
                >
            </div>

            {{-- Info Akun --}}
            <div class="text-center md:text-left">
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ $user->name }}
                </h2>

                <p class="text-slate-500">
                    {{ $user->email }}
                </p>

                <span class="inline-block mt-3 px-3 py-1 text-xs rounded-full 
                    {{ $user->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </span>
            </div>

        </div>
    </div>

    {{-- ================= INFORMASI RELAWAN ================= --}}
    <div class="bg-white rounded-2xl shadow-sm p-6">

        <h3 class="text-lg font-semibold text-slate-700 mb-6">
            Informasi Relawan
        </h3>

        @if($user->information)
        <div class="grid md:grid-cols-2 gap-6 text-sm">

            {{-- Kolom Kiri --}}
            <div class="space-y-4">
                <div>
                    <label class="text-slate-500 text-xs">NIK</label>
                    <p class="font-medium">{{ $user->information->nik ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Nomor KK</label>
                    <p class="font-medium">{{ $user->information->nomor_kk ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Nama Lengkap</label>
                    <p class="font-medium">{{ $user->information->fullname ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Tempat, Tanggal Lahir</label>
                    <p class="font-medium">
                        {{ $user->information->place_of_birth ?? '-' }},
                        {{ optional($user->information->date_of_birth)->format('d F Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Jenis Kelamin</label>
                    <p class="font-medium">
                        {{ $user->information->gender ?? '-' }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Status Pernikahan</label>
                    <p class="font-medium">
                        {{ $user->information->maried_status ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class="space-y-4">

                <div>
                    <label class="text-slate-500 text-xs">Pendidikan</label>
                    <p class="font-medium">{{ $user->information->education ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">No HP</label>
                    <p class="font-medium">{{ $user->information->phone_number ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Alamat</label>
                    <p class="font-medium">
                        {{ $user->information->address ?? '-' }},
                        {{ $user->information->village ?? '' }},
                        {{ $user->information->subdistrict ?? '' }},
                        {{ $user->information->regency ?? '' }},
                        {{ $user->information->province ?? '' }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Tanggal Bergabung</label>
                    <p class="font-medium">
                        {{ optional($user->information->joined_date)->format('d F Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Ukuran Baju</label>
                    <p class="font-medium">{{ $user->information->shirt_size ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Agama</label>
                    <p class="font-medium">{{ $user->information->religion ?? '-' }}</p>
                </div>
            </div>

        </div>

        {{-- ================= INFORMASI BANK ================= --}}
        <div class="mt-8 border-t pt-6">
            <h4 class="text-md font-semibold text-slate-700 mb-4">
                Informasi Bank
            </h4>

            <div class="grid md:grid-cols-3 gap-6 text-sm">
                <div>
                    <label class="text-slate-500 text-xs">Nama Bank</label>
                    <p class="font-medium">{{ $user->information->bank_name ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Nomor Rekening</label>
                    <p class="font-medium">{{ $user->information->account_number ?? '-' }}</p>
                </div>

                <div>
                    <label class="text-slate-500 text-xs">Atas Nama</label>
                    <p class="font-medium">{{ $user->information->account_owner_name ?? '-' }}</p>
                </div>
            </div>
        </div>

        @else
            <div class="text-slate-500 text-sm">
                Informasi relawan belum tersedia.
            </div>
        @endif

    </div>
</div>
