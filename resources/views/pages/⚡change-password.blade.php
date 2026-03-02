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
    
        $user->password = Hash::make($this->new_password);
        $user->save();

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        session()->flash('success', 'Password berhasil diperbarui.');
    }
};
?>

<div class="max-w-xl space-y-6">

    {{-- Header --}}
    <x-header title="Ubah Password" subtitle="Pastikan password baru Anda aman dan mudah diingat." separator />
    

    {{-- Card --}}
    <div class="bg-white shadow rounded-2xl p-6">

        {{-- Flash Message --}}
        @if (session()->has('success'))
            <div class="mb-4 bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <x-form wire:submit.prevent="updatePassword">
            <x-password label="Password Lama" wire:model="current_password" right />
            <x-password label="Password Baru" wire:model="new_password" right />
            <x-password label="Konfirmasi Password Baru" wire:model="new_password_confirmation" />
            <x-slot:actions>
                <div class="w-full flex items-center justify-center">
                    <x-button label="Masuk" type="submit" class="btn-primary w-full" spinner="updatePassword" />
                </div>
            </x-slot:actions>
        </x-form>
    </div>

</div>
