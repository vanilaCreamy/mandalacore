<?php

namespace App\Enums;

enum DriverFlow
{
    case DEPART;
    case ARRIVE;

    public function label() {
        return match($this){
            self::DEPART => 'Berangkat',
            self::ARRIVE => 'Tiba',
        };
    }
}
