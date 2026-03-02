<?php

use Livewire\Component;
use Livewire\Attributes\Validate; 

new class extends Component
{
    #[Validate('required|email')]
    public $email = "";
    
    #[Validate('required')]
    public $password= "";

    public function login()
    {
        $this->validate();

        if(Auth::attempt(['email' => $this->email, 'password' => $this->password]))
        {
            session()->regenerate();

            return redirect('/dashboard');
        }

        $this->addError('credential', 'Email atau password salah.');
    }

    public function render()
    {
        return $this->view()
            ->layout('layouts::app');
    }
};
?>

<div class="">
    <div class="flex flex-col gap-2 w-full h-screen justify-center items-center">
        <x-header title="Selamat Datang" subtitle="Masuk ke web Mandala System" />
        <main class="bg-slate-50 p-3 rounded-md flex flex-col gap-4">
            <div class="">
                <h3 class="text-lg font-semibold text-center">Masuk</h3>
            <p class="text-sm text-slate-600 text-center">Masukkan kredensial anda untuk mengakses akun</p>
            </div>

            <x-form wire:submit.prevent="login" >
                <x-input label="Email" wire:model="email" type="email" placeholdel="abc@email.com" />
                <x-password label="Password" wire:model="password" right />
                <x-slot:actions>
                    <div class="w-full flex items-center justify-center">
                        <x-button label="Masuk" type="submit" class="btn-primary w-full" spinner="login" />
                    </div>
                </x-slot:actions>
            </x-form>
            @error('credential')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </main>
    </div>
</div>