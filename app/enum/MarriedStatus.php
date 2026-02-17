<?php

namespace App\enum;

enum MarriedStatus
{
    case MARRIED;
    case UNMARRIED;
    case DIVORCE;

    public function label()
    {
        return match($this){
            self::MARRIED => 'Menikah',
            self::UNMARRIED => 'Belum Menikah',
            self::DIVORCE => 'Cerai',
        };
    }
}
