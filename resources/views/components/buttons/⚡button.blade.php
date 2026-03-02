<?php

use Livewire\Component;

new class extends Component
{
    public $variant = 'primary'; 
    public $color = 'blue';  
    public $size = 'default';

    public function getClassesProperty()
    {
        $base = "inline-flex items-center justify-center font-medium rounded-lg border-2 transition duration-200 cursor-pointer";

        // Size
        $sizes = [
            'default' => 'px-4 py-2 text-sm',
            'small' => 'px-3 py-1.5 text-sm',
            'extra-small' => 'px-2 py-1 text-xs',
        ];

        $size = $sizes[$this->size] ?? $sizes['default'];

        switch ($this->variant) {

            case 'filled':
            case 'primary':
                $variant = "bg-{$this->color}-600 border-{$this->color}-600 text-white hover:bg-{$this->color}-700";
                break;

            case 'outline':
                $variant = "bg-transparent border-{$this->color}-600 text-{$this->color}-600 hover:bg-{$this->color}-600 hover:text-white";
                break;

            case 'danger':
                $variant = "bg-red-600 border-red-600 text-white hover:bg-red-700";
                break;

            case 'ghost':
                $variant = "bg-transparent border-transparent text-{$this->color}-600 hover:bg-{$this->color}-50";
                break;

            case 'subtle':
                $variant = "bg-{$this->color}-50 border-transparent text-{$this->color}-700 hover:bg-{$this->color}-100";
                break;

            default:
                $variant = "bg-{$this->color}-600 border-{$this->color}-600 text-white hover:bg-{$this->color}-700";
        }

        return "{$base} {$size} {$variant}";
    }
};
?>

<button {{ $attributes->merge(['class' => $this->classes]) }}>
    {{ $slot }}
</button>
