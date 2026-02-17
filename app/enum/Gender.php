<?php

namespace App\enum;

enum Gender
{
    case MALE;
    case FEMALE;

    public function label()
    {
        return match($this) {
            self::MALE => 'Pria',
            self::FEMALE => 'Wanita',
        };
    }
}
