<?php

use Livewire\Component;

new class extends Component
{
    public $breadcrumbs;

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link' => route('dashboard')],
            ['label' => 'Menu']
        ];
    }
};
?>

<div>
    <x-breadcrumbs :items="$breadcrumbs" />

    <x-header title="Menu" subtitle="..." separator>
        <x-slot:actions>
            <x-button label="Resep" link="{{ route('recipe.index') }}" />
            <x-button label="Buat Menu" link="{{ route('menu.create') }}" class="btn-primary" />
        </x-slot:actions>
    </x-header>
</div>