<?php

namespace App\enum\Concerns;

trait HasOptions
{
    public static function options(): array
    {
        return collect(self::cases())
            ->map(fn ($case) => [
                'id' => $case->value,
                'name' => $case->label(),
            ])
            ->toArray();
    }
}