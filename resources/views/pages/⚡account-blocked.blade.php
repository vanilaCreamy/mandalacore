<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="min-h-screen flex items-center justify-center bg-base-200">
    <div class="bg-white p-10 rounded-2xl shadow-xl text-center space-y-4 w-[400px]">
        <div class="text-5xl">🚫</div>
        <h1 class="text-2xl font-bold">Akun Anda Dinonaktifkan</h1>
        <p class="text-gray-500">
            Silakan hubungi admin untuk mengaktifkan kembali akun Anda.
        </p>

        <x-button icon="o-power" class="btn btn-error w-full" no-wire-navigate link="/logout" >Log Out</x-button>
    </div>
</div>
