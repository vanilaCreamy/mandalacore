<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum PurchaseStatus: string
{
    use HasOptions;

    case OPEN = 'OPEN';
    case PARTIAL = 'PARTIAL';
    case DONE = 'DONE';

    public function label()
    {
        return match ($this) {
            self::OPEN => 'Diproses',
            self::PARTIAL => 'Sebagian',
            self::DONE => 'Selesai',
        };
    }
}
