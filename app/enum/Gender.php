<?php

namespace App\enum;

use App\enum\Concerns\HasOptions;

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
