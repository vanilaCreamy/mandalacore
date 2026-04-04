<?php

namespace App\Enums;

use App\Enums\Concerns\HasOptions;

enum Religion: string
{
    use HasOptions;

    case ISLAM = 'ISLAM';
    case CHRISTIAN = 'CHRISTIAN';
    case HINDU = 'HINDU';
    case BUDHA = 'BUDHA';
    case KONGHUCU = 'KONGHUCU';

    public function label()
    {
        return match($this){
            self::ISLAM => 'Islam',
            self::CHRISTIAN => 'Kristen',
            self::HINDU => 'Hindu',
            self::BUDHA => 'Budha',
            self::KONGHUCU => 'Konghucu',
        };
    }
}
