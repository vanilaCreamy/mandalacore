<?php

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On; 


new class extends Component
{
    public $breadcrumbs = [];

    public $relawans;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Pengguna']
        ];

        $this->loadRelawan();
    }

    #[On('user-created')] 
    public function loadRelawan()
    {
        $this->relawans = User::latest()->get();
    }

    public function toggleStatus($id)
    {
        $relawan = User::findOrFail($id);
        $relawan->is_active = !$relawan->is_active;
        $relawan->save();

        $this->loadRelawan();
    }
};
?>

<div>

    <x-breadcrumbs :items="$breadcrumbs" />

    <!-- Header -->
    <x-header title="Manajemen Akun" separator />

    @foreach($relawans as $user)
        <x-list-item :item="$user" :link="route('user.detail', $user->id)">
            <x-slot:avatar>
                <img src="{{ asset('images/pic-default.jpg') }}" alt="" width="50" height="50" class="rounded-2xl">
            </x-slot:avatar>
            <x-slot:value>
                <h2>{{ $user->name }} - ({{ $user->role->label() }})</h2>
                @if ($user->is_active)
                <span class="text-sm px-1 py-0.5 bg-green-500 text-white rounded-md">Aktif</span>
                @else
                <span class="text-sm px-1 py-0.5 bg-red-500 text-white rounded-md">Tidak Aktif</span>
                @endif
            </x-slot:value>
            <x-slot:sub-value>
                {{ $user->email }}
            </x-slot:sub-value>
            <x-slot:actions>
                <x-button icon="o-bug-ant" class="btn-sm" wire:click="toggleStatus({{ $user->id }})" spinner />
            </x-slot:actions>
        </x-list-item>
    @endforeach
</div>
