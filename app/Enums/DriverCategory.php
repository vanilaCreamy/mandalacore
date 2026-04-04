<?php

namespace App\Enums;

enum DriverCategory
{
    case DELIVERY;
    case TAKE;

    public function label()
    {
        return match($this){
            self::DELIVERY => "Pengantaran",
            self::TAKE => "Pengambilan",
        };
    }
}
