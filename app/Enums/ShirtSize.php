<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum ShirtSize: string
{
    use HasOptions;

    case S  = 'S';
    case M = 'M';
    case L = 'L';
    case XL  = 'XL';

    public function label(): string
    {
        return match ($this) {
            self::S  => 'S',
            self::M => 'M',
            self::L => 'L',
            self::XL  => 'XL',
        };
    }
}