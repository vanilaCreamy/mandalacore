<?php

use Livewire\Component;

new class extends Component
{
    public $title = '';
    public $subtitle = '';
    public $size = 'md'; // lg, md, sm

    public function getHeadingClassProperty()
    {
        $sizes = [
            'lg' => 'text-3xl',
            'md' => 'text-2xl',
            'sm' => 'text-xl',
        ];

        return $sizes[$this->size] ?? $sizes['md'];
    }

    public function getSubtitleClassProperty()
    {
        $sizes = [
            'lg' => 'text-lg',
            'md' => 'text-base',
            'sm' => 'text-sm',
        ];

        return $sizes[$this->size] ?? $sizes['md'];
    }
};
?>

<h2 class="{{ $this->headingClass }} font-semibold">
    {{ $title }}

    @if($subtitle)
        <span class="block w-full font-light text-slate-500 {{ $this->subtitleClass }}">
            {{ $subtitle }}
        </span>
    @endif
</h2>
