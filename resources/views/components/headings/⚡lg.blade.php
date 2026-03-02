<?php

use Livewire\Component;

new class extends Component
{
    public $title = '';
    public $subtitle = '';
};
?>

<h2 class="text-xl font-semibold">
    {{ $title }}
    <span class="block w-full text-lg font-light text-slate-500">{{ $subtitle }}</span>
</h2>