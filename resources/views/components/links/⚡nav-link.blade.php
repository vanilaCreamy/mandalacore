<?php

use Livewire\Component;

new class extends Component
{
    public $url = "";
};
?>

<a href="{{ route($url) }}" wire:navigate wire:current="bg-slate-200" class="p-2 block w-full rounded-md hover:bg-slate-200">
    {{ $slot }}
</a>