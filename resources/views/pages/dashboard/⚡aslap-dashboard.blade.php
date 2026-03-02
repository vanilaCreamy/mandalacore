<?php

use Livewire\Component;

new class extends Component
{
    public $breadcrumbs = [];

    public function mount()
    {
        $this->breadcrumbs = [
            ['icon' => 'o-home', 'link'=> route('dashboard')]
        ];
    }
};
?>

<div class="space-y-8">
    <x-breadcrumbs :items="$breadcrumbs" />

    {{-- header --}}
    <x-header title="Dashboard" separator />

    {{-- <x-card title="Pengumuman 🔔" subtitle="Our findings about you" shadow separator>
        I have title, subtitle and separator.
    </x-card>    --}}
</div>
