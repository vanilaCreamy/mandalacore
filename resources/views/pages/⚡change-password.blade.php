<?php

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

new class extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function updatePassword()
    {
        $this->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ], [
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Password berhasil diperbarui.');
    }
};
?>

<div class="max-w-xl space-y-6">

    {{-- Header --}}
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Ubah Password</h2>
        <p class="text-sm text-slate-500">Pastikan password baru Anda aman dan mudah diingat.</p>
    </div>

    {{-- Card --}}
    <div class="bg-white shadow rounded-2xl p-6">

        {{-- Flash Message --}}
        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="updatePassword" class="space-y-5">

            {{-- Password Lama --}}
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">
                    Password Lama
                </label>
                <input type="password"
                       wire:model.defer="current_password"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('current_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">
                    Password Baru
                </label>
                <input type="password"
                       wire:model.defer="new_password"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('new_password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi Password Baru --}}
            <div>
                <label class="block text-sm font-semibold text-slate-600 mb-1">
                    Konfirmasi Password Baru
                </label>
                <input type="password"
                       wire:model.defer="new_password_confirmation"
                       class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            {{-- Button --}}
            <div class="pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>

</div>
