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

<div class="bg-slate-200">
    <div class="flex flex-col gap-2 w-full h-screen justify-center items-center">
        <header>
            <h2 class="text-xl font-semibold text-center">Selamat Datang</h2>
            <p class="text-sm text-slate-600">Masuk ke web Mandala System</p>
        </header>
        <main class="bg-slate-100 p-3 rounded-md flex flex-col gap-4">
            <div class="">
                <h3 class="text-lg font-semibold text-center">Masuk</h3>
            <p class="text-sm text-slate-600 text-center">Masukkan kredensial anda untuk mengakses akun</p>
            </div>

            <form wire:submit.prevent="login" class="flex flex-col gap-2">
                <div class="">
                    <input wire:model="email" type="text" class="border rounded-md p-2 block w-full" placeholder="Email">
                    @error('email')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="">
                    <input wire:model="password" type="password" class="border rounded-md p-2 block w-full" placeholder="Password">
                    @error('password')
                        <p class="text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="bg-slate-800 text-slate-100 p-2 rounded-md hover:bg-slate-700 active:bg-slate-60">Masuk</button>
            </form>
            @error('credential')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </main>
    </div>
</div>