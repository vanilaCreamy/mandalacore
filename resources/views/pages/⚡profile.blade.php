<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

new class extends Component
{
    use WithFileUploads;

    public $photo;

    public function savePhoto()
    {
        $this->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $extension = $this->photo->getClientOriginalExtension();
        $filename = $user->id . '.' . $extension;

        // Hapus foto lama jika ada
        Storage::disk('public')->delete($user->id . '.jpg');
        Storage::disk('public')->delete($user->id . '.png');

        // Simpan foto baru
        $this->photo->storeAs('profile', $filename, 'public');

        $this->photo = null;

        session()->flash('success', 'Foto profil berhasil diperbarui.');
    }
};
?>

<div class="space-y-8 max-w-3xl">

    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Profil Saya</h2>
        <p class="text-sm text-slate-500">Kelola informasi akun dan foto profil Anda</p>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow rounded-2xl p-6 space-y-6">

        {{-- Flash Message --}}
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center">

            {{-- Foto Profil --}}
            <div class="w-40 h-40 rounded-xl overflow-hidden border bg-slate-100 flex items-center justify-center">
                @php
                    $user = auth()->user();
                    $jpg = 'profile/' . $user->id . '.jpg';
                    $png = 'profile/' . $user->id . '.png';
                @endphp

                @if(Storage::disk('public')->exists($jpg))
                    <img src="{{ asset('storage/'.$jpg) }}" class="w-full h-full object-cover">
                @elseif(Storage::disk('public')->exists($png))
                    <img src="{{ asset('storage/'.$png) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-slate-400 text-sm">Belum ada foto</span>
                @endif
            </div>

            {{-- Form Upload --}}
            <div class="flex-1 space-y-4">
                <form wire:submit.prevent="savePhoto" class="space-y-4">

                    <div>
                        <input type="file" wire:model="photo"
                               class="block w-full text-sm text-slate-600
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700
                               hover:file:bg-blue-100"/>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($photo)
                        <div class="w-32 h-32 rounded-lg overflow-hidden border">
                            <img src="{{ $photo->temporaryUrl() }}"
                                 class="w-full h-full object-cover">
                        </div>
                    @endif

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                        Simpan Foto
                    </button>
                </form>
            </div>

        </div>

        {{-- Informasi User --}}
        <div class="border-t pt-6 grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <h5 class="text-slate-500 font-semibold">Nama</h5>
                <p class="text-slate-800">{{ auth()->user()->name }}</p>
            </div>

            <div>
                <h5 class="text-slate-500 font-semibold">Email</h5>
                <p class="text-slate-800">{{ auth()->user()->email }}</p>
            </div>
        </div>

    </div>

</div>
