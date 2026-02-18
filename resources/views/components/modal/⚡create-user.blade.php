<?php

use Livewire\Component;
use App\Models\User;
use App\enum\UserRole;
use Illuminate\Validation\Rule;

new class extends Component
{
    public $open = false;
    public $name;
    public $email;
    public $role;

    protected function rules() 
    {
        return [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', Rule::enum(UserRole::class)],
        ];
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt('password'),
            'role' => $this->role,
        ]);

        $this->dispatch("user-created"); 

        $this->reset(['name', 'email', 'open']);
    }
};
?>

<!-- ✅ SATU ROOT -->
<div>

    <!-- Button -->
    <button 
        wire:click="$set('open', true)"
        class="px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition"
    >
        + Tambah User
    </button>

    <!-- Modal -->
    @if($open)
    <div class="fixed inset-0 flex items-center justify-center z-50">

        <!-- Overlay -->
        <div 
            class="absolute inset-0 bg-black/50"
            wire:click="$set('open', false)"
        ></div>

        <!-- Modal Card -->
        <div class="relative bg-white w-full max-w-md rounded-2xl shadow-2xl p-6">

            <h2 class="text-xl font-semibold mb-6">
                Create User
            </h2>

            <form wire:submit="save" class="space-y-4">

                <div>
                    <label>Nama</label>
                    <input type="text" wire:model="name" class="w-full border rounded-lg p-2">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>Email</label>
                    <input type="text" wire:model="email" class="w-full border rounded-lg p-2">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label>Role</label>
                    <select wire:model="role" class="w-full border rounded-lg p-2">
                        <option value="">-- Pilih --</option>
                        @foreach (UserRole::cases() as $item)
                            <option value="{{ $item->value }}" wire:key="{{ $item->value }}">{{ $item->label() }}</option>
                        @endforeach
                    </select>
                    @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button 
                        type="button"
                        wire:click="$set('open', false)"
                        class="px-4 py-2 bg-gray-200 rounded-lg"
                    >
                        Batal
                    </button>

                    <button 
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg"
                    >
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
    @endif

</div>
