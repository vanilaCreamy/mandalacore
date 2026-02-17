<?php

use Livewire\Component;

new class extends Component
{
    public string $href;
    public string $color = 'blue';

    public function isActive()
    {
        return request()->url() === url($this->href);
    }
};
?>

<a
href="{{ $this->href ? route($this->href) : '#' }}"
@class([
    'block px-3 py-2 rounded-lg transition',

    // ACTIVE STYLE
    'bg-red-200 text-red-700' => $this->isActive() && $this->color === 'red',
    'bg-blue-200 text-blue-700' => $this->isActive() && $this->color === 'blue',
    'bg-green-200 text-green-700' => $this->isActive() && $this->color === 'green',
    'bg-gray-200 text-gray-700' => $this->isActive() && $this->color === 'gray',

    // NORMAL HOVER
    'hover:bg-red-100' => !$this->isActive() && $this->color === 'red',
    'hover:bg-blue-100' => !$this->isActive() && $this->color === 'blue',
    'hover:bg-green-100' => !$this->isActive() && $this->color === 'green',
    'hover:bg-gray-100' => !$this->isActive() && $this->color === 'gray',
])
>
    {{ $slot }}
</a>
