<?php

use Livewire\Component;

new class extends Component
{
    public string $url = '';
    public string $variant = 'primary';
    public string $color = 'blue';
    public string $size = 'def';

    public function getClassesProperty()
    {
        $base = "inline-flex items-center justify-center font-light rounded-lg border-2 transition duration-200 cursor-pointer";

        // Size
        $sizes = [
            'def' => 'px-4 py-2 text-sm',
            'sm' => 'px-3 py-1.5 text-sm',
            'xs' => 'px-2 py-1 text-xs',
        ];

        $size = $sizes[$this->size] ?? $sizes['def'];

        switch ($this->variant) {

            case 'filled':
            case 'primary':
                $variant = "bg-{$this->color}-600 border-{$this->color}-600 text-white hover:bg-{$this->color}-700";
                break;

            case 'outline':
                $variant = "bg-transparent border-{$this->color}-600 text-{$this->color}-600 hover:bg-{$this->color}-600 hover:text-white";
                break;

            case 'ghost':
                $variant = "bg-transparent border-transparent text-{$this->color}-600 hover:bg-{$this->color}-50";
                break;

            case 'subtle':
                $variant = "bg-{$this->color}-50 border-transparent text-{$this->color}-700 hover:bg-{$this->color}-100";
                break;

            case 'danger':
                $variant = "bg-red-600 border-red-600 text-white hover:bg-red-700";
                break;

            default:
                $variant = "bg-{$this->color}-600 border-{$this->color}-600 text-white hover:bg-{$this->color}-700";
        }

        return "{$base} {$size} {$variant}";
    }
};
?>

<a
    href="{{ $url ? route($url) : '#' }}"
    {{ $attributes->merge(['class' => $this->classes]) }}
    wire:navigate
>
    {{ $slot }}
</a>
