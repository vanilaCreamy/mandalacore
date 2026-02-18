<?php

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On; 


new class extends Component
{
    public $relawans;

    public function mount()
    {
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

<div class="">
    {{-- <livewire:input.input-text model="yolo" label="Users" type="date"/> --}}

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl md:text-2xl font-bold text-gray-800">
            Manajemen Relawan
        </h1>

        <livewire:modal.create-user />
    </div>

    <!-- ============================= -->
    <!-- DESKTOP MODE (TABLE) -->
    <!-- ============================= -->
    <div class="hidden md:block bg-white shadow rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">No</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Role</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-600">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse($relawans as $index => $relawan)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3">{{ $index + 1 }}</td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $relawan->name }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $relawan->email }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-lg bg-blue-100 text-blue-700">
                                    {{ $relawan->role?->label() ?? '-' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                @if($relawan->is_active)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                        Active
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-700">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="/manage/users/{{ $relawan->id }}"
                                       class="px-3 py-1 text-xs bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                      
                                    </a>
                                    <a href="/"
                                       class="px-3 py-1 text-xs bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                                        Edit
                                    </a>

                                    <button
                                        wire:click="toggleStatus({{ $relawan->id }})"
                                        class="px-3 py-1 text-xs rounded-md text-white
                                        {{ $relawan->is_active 
                                            ? 'bg-red-500 hover:bg-red-600' 
                                            : 'bg-green-500 hover:bg-green-600' }}">
                                        {{ $relawan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">
                                Tidak ada data relawan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>


    <!-- ============================= -->
    <!-- MOBILE MODE (CARD) -->
    <!-- ============================= -->
    <div class="md:hidden space-y-4">
        @forelse($relawans as $index => $relawan)
            <div class="bg-white shadow rounded-xl p-4 border border-gray-100">

                <!-- Header Card -->
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="font-semibold text-gray-800">
                            {{ $relawan->name }}
                        </h2>
                        <p class="text-sm text-gray-500">
                            {{ $relawan->email }}
                        </p>
                    </div>

                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $relawan->is_active 
                            ? 'bg-green-100 text-green-700' 
                            : 'bg-red-100 text-red-700' }}">
                        {{ $relawan->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- Role -->
                <div class="mt-3">
                    <span class="text-xs text-gray-500">Role:</span>
                    <span class="ml-1 px-2 py-1 text-xs rounded-lg bg-blue-100 text-blue-700">
                        {{ $relawan->role?->label() ?? '-' }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 flex gap-2">
                    <a href="/"
                       class="flex-1 text-center py-2 text-xs bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                        Edit
                    </a>

                    <button
                        wire:click="toggleStatus({{ $relawan->id }})"
                        class="flex-1 py-2 text-xs rounded-lg text-white
                        {{ $relawan->is_active 
                            ? 'bg-red-500 hover:bg-red-600' 
                            : 'bg-green-500 hover:bg-green-600' }}">
                        {{ $relawan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </div>

            </div>
        @empty
            <div class="text-center py-6 text-gray-500">
                Tidak ada data relawan.
            </div>
        @endforelse
    </div>

</div>
