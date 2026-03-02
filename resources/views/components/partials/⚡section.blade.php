<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section {{ $attributes->merge(['class' => 'p-2 rounded-md bg-white mb-2']) }}>
    {{ $slot }}
</section>