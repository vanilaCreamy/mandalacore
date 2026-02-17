<?php

namespace App\enum;

enum SchoolLevel
{
    case I;
    case II;
    case III;
    case IV;
    case V;

    public function label()
    {
        return match($this) {
            self::I => 'TK/RA/PAUD',
            self::II => 'SD/MI',
            self::III => 'SMP/MTS',
            self::IV => 'SMA/SMK/MA',
            self::V => 'Lainnya',
        };
    }
}
