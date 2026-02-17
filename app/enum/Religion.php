<?php

namespace App\enum;

enum Religion
{
    case ISLAM;
    case CHRISTIAN;
    case HINDU;
    case BUDHA;
    case KONGHUCU;

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
