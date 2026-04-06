<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum OrderCategory: string
{
    use HasOptions;

    case DAILY = 'DAILY';
    case WEEKLY = 'WEEKLY';

    public function label()
    {
        return match($this) {
            self::DAILY => 'Harian',
            self::WEEKLY => 'Mingguan',
        };
    }
}
