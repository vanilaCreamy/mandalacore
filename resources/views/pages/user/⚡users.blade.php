<?php

use Livewire\Component;
use App\Models\User;
use App\Models\UserInformation;
use Livewire\Attributes\On;
use App\enum\UserRole;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Mary\Traits\Toast;

new class extends Component
{
    use Toast;

    public $user_modal = false;
    public $edit_modal = false;

    public $breadcrumbs = [];
    public $relawans = [];

    public $selected_user_id = null;

    public $user_name;
    public $user_email;
    public $user_role;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Pengguna']
        ];

        $this->loadRelawan();
    }

    #[On('user-created')]
    #[On('user-updated')]
    #[On('user-status-changed')]
    public function loadRelawan()
    {
        $this->relawans = User::select('id','name','email','role','is_active')
            ->orderByRaw("
                FIELD(role,
                    'ADMIN',
                    'KEPALA',
                    'PLOG',
                    'PLOK',
                    'ASLAP',
                    'PERSIAPAN',
                    'PENGOLAHAN',
                    'PEMORSIAN',
                    'DISTRIBUSI',
                    'PENCUCIAN'
                )
            ")
            ->get();
    }

    public function getUserRoleOptionsProperty()
    {
        return collect(UserRole::cases())->map(fn ($role) => [
            'id' => $role->value,
            'name' => $role->label(),
        ])->toArray();
    }

    protected function rules()
    {
        return [
            'user_name'  => ['required', 'string'],
            'user_email' => ['required', 'email', 'unique:users,email'],
            'user_role'  => ['required', Rule::enum(UserRole::class)],
        ];
    }

    public function save()
    {
        $this->validate();

        $new_user = User::create([
            'name'     => $this->user_name,
            'email'    => $this->user_email,
            'password' => Hash::make('password'),
            'role'     => $this->user_role,
        ]);

        UserInformation::create([
            'user_id' => $new_user->id
        ]);

        $this->resetForm();
        $this->dispatch('user-created');
    }

    public function open_edit_modal($id)
    {
        $user = User::findOrFail($id);

        $this->selected_user_id = $id;
        $this->user_name  = $user->name;
        $this->user_email = $user->email;
        $this->user_role  = $user->role;

        $this->edit_modal = true;
    }

    public function updateUser()
    {
        $user = User::findOrFail($this->selected_user_id);

        $this->validate([
            'user_name' => ['required','string'],
            'user_role' => ['required', Rule::enum(UserRole::class)],
        ]);

        $user->update([
            'name' => $this->user_name,
            'role' => $this->user_role,
        ]);

        $this->resetForm();
        $this->dispatch('user-updated');
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'is_active' => !$user->is_active
        ]);

        $this->dispatch('user-status-changed');
    }

    public function reset_password($id)
    {
        User::findOrFail($id)->update([
            'password' => Hash::make('password')
        ]);

         // ✅ Toast feedback
        $this->toast(
            type: 'success',
            title: 'Password berhasil direset',
            description: 'Password dikembalikan ke default: "password". Minta pengguna segera menggantinya.',
            position: 'toast-top toast-end',
            icon: 'o-key',
            css: 'alert-success',
            timeout: 3000,
            redirectTo: null
        );
    }

    private function resetForm()
    {
        $this->reset([
            'user_name',
            'user_email',
            'user_role',
            'selected_user_id',
            'user_modal',
            'edit_modal'
        ]);
    }
};
?>

<div>
    <x-modal wire:model="user_modal" title="Buat Akun Baru" class="backdrop-blur">
        <x-form wire:submit.prevent="save">
            <x-input label="Nama" wire:model="user_name" />
            <x-input type="email" label="Email" wire:model="user_email" />
            <x-select label="Role" wire:model="user_role" :options="$this->userRoleOptions" />
    
            <x-slot:actions>
                <x-button label="Tambah" type="submit" class="btn-primary" spinner="save" />
                <x-button label="Cancel" @click="$wire.user_modal = false" />
            </x-slot:actions>
        </x-form>
    </x-modal>

    <x-modal wire:model="edit_modal" title="Edit Akun" class="backdrop-blur">
        <x-form wire:submit.prevent="updateUser">
            <x-input label="Nama" wire:model="user_name" />
            <x-input type="email" label="Email" wire:model="user_email" disabled />
            <x-select label="Role" wire:model="user_role" :options="$this->userRoleOptions" />
    
            <x-slot:actions>
                <x-button label="Update" type="submit" class="btn-primary" spinner="updateUser" />
                <x-button label="Cancel" @click="$wire.edit_modal = false" />
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
        <x-list-item :item="$user">
            <x-slot:avatar>
                @php
                    // $user = auth()->user();
                    $jpg = 'profile/' . $user->id . '.jpg';
                    $png = 'profile/' . $user->id . '.png';
                @endphp

                <img 
                src="{{ 
                    Storage::disk('public')->exists($jpg) 
                        ? asset('storage/'.$jpg) 
                        : (Storage::disk('public')->exists($png) 
                            ? asset('storage/'.$png) 
                            : asset('images/ava-md.png')) 
                }}" 
                alt="Profile" 
                height="50" 
                width="50" 
                class="rounded-2xl">

                {{-- <img src="{{ asset('images/pic-default.jpg') }}" alt="" width="50" height="50" class="rounded-2xl"> --}}
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
                <x-dropdown>
                    <x-slot:trigger>
                        <x-button 
                            icon="o-ellipsis-vertical" 
                            class="btn-circle btn-sm btn-ghost" 
                        />
                    </x-slot:trigger>
                    <x-menu-item 
                        title="Detail"
                        icon="o-eye"
                        link="{{ route('user.detail', $user->id) }}"
                    />
                    <x-menu-item 
                        title="Edit"
                        icon="o-pencil"
                        wire:click="open_edit_modal({{ $user->id }})"
                    />

                    <x-menu-item 
                        title="Reset Password"
                        icon="o-key"
                        wire:click="reset_password({{ $user->id }})"
                    />
                </x-dropdown>
            </x-slot:actions>
        </x-list-item>
    @endforeach
</div>
