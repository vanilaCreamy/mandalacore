<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum MaterialMovType: string
{
    use HasOptions;

    case IN = 'IN';
    case OUT = 'OUT';
    case ADJUSTMENT = 'ADJUSTMENT';
    case WASTE = 'WASTE';

    public function label()
    {
        return match($this) {
            self::IN => 'Masuk',
            self::OUT => 'Keluar',
            self::ADJUSTMENT => 'Penyesuaian',
            self::WASTE => 'Rusak',
        };
    }
}
