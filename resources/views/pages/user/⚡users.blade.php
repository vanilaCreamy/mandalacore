<?php

use Livewire\Component;
use App\Models\User;
use App\Models\UserInformation;
use Livewire\Attributes\On;
use App\enum\UserRole; 
use Illuminate\Validation\Rule;


new class extends Component
{
    public $user_modal = false;
    public $breadcrumbs = [];

    public $user_name;
    public $user_email;
    public $user_role;

    public $relawans;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Pengguna']
        ];

        $this->loadRelawan();
    }

    public function getUserRoleOptionsProperty()
    {
        return collect(UserRole::cases())->map(fn ($role) => [
            'id' => $role->name,
            'name' => $role->label(),
        ])->toArray();
    }

    public function rules()
    {
        return [
            'user_name' => ['required', 'string'],
            'user_email' => ['required', 'email'],
            'user_role' => ['required', Rule::enum(UserRole::class)],
        ];
    }
    
    public function save()
    {
        $this->validate();

        $new_user = User::create([
            'name' => $this->user_name,
            'email' => $this->user_email,
            'password' => Hash::make('password'),
            'role' => $this->user_role,
        ]);

        UserInformation::create([
            'user_id' => $new_user->id
        ]);

        // ✅ Reset field
        $this->reset(['user_name', 'user_email', 'user_role']);

        // ✅ Tutup modal
        $this->user_modal = false;

        // ✅ Dispatch event
        $this->dispatch('user-created');
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
    <x-modal wire:model="user_modal" title="Buat Akun Baru" class="backdrop-blur">
        <x-form wire:submit.prevent="save">
            <x-input type="text" label="Nama" wire:model="user_name" />
            <x-input type="email" label="Email" wire:model="user_email" />
            <x-select label="Role" wire:model="user_role" :options="$this->userRoleOptions" />
            
            <x-slot:actions>
                <x-button label="Tambah" type="submit" class="btn-primary" spinner="save" />
                <x-button label="Cancel" @click="$wire.user_modal = false" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-breadcrumbs :items="$breadcrumbs" />

    <!-- Header -->
    <x-header title="Manajemen Akun" separator />

    <div class="flex items-center justify-between">
        <div class="">
            <x-stat title="Jumlah Akun" value="{{ count($relawans) }}" icon="o-users" color="text-primary" />
        </div>
        <div class="">
            <x-button label="+ Tambah Pengguna" @click="$wire.user_modal = true" class="btn-primary" />
        </div>
    </div>

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
