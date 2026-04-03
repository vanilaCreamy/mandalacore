<?php

namespace App\enum;

use App\enum\Concerns\HasOptions;

enum MarriedStatus: string
{
    use HasOptions;

    case MARRIED = 'MARRIED';
    case UNMARRIED = 'UNMARRIED';
    case DIVORCE = 'DIVORCE';

    public function label()
    {
        return match($this){
            self::MARRIED => 'Menikah',
            self::UNMARRIED => 'Belum Menikah',
            self::DIVORCE => 'Cerai',
        };
    }
}
