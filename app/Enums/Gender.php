<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum Gender: string
{
    use HasOptions;

    case MALE = 'MALE';
    case FEMALE = 'FEMALE';

    public function label()
    {
        return match($this) {
            self::MALE => 'Pria',
            self::FEMALE => 'Wanita',
        };
    }
}
