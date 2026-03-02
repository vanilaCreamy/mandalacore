<?php

use Livewire\Component;

new class extends Component
{
    public string $href = '';
    public string $scope = '';
    public string $variant = 'primary';
    public string $color = 'blue';
    public string $size = 'default';

    public function isActive(): bool
    {
        return request()->routeIs($this->scope);
    }

    public function getClassesProperty()
    {
        $base = "inline-flex block w-full items-center justify-center font-medium rounded-lg border-2 transition duration-200 cursor-pointer";

        // Size
        $sizes = [
            'default' => 'px-4 py-2 text-sm',
            'small' => 'px-3 py-1.5 text-sm',
            'extra-small' => 'px-2 py-1 text-xs',
        ];

        $size = $sizes[$this->size] ?? $sizes['default'];

        // Active override (lebih dominan dari variant)
        if ($this->isActive()) {
            return "{$base} {$size} bg-{$this->color}-600 border-{$this->color}-600 text-white";
        }

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
    href="{{ $href ? route($href) : '#' }}"
    {{ $attributes->merge(['class' => $this->classes]) }}
    wire:navigate
>
    {{ $slot }}
</a>
