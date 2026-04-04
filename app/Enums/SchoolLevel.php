<?php

namespace App\Enums;

enum SchoolLevel
{
    case I;
    case II;
    case III;
    case IV;
    case V;
    case VI;

    public function label()
    {
        return match($this) {
            self::I => 'KB/PAUD',
            self::II => 'TK/RA',
            self::III => 'SD/MI',
            self::IV => 'SMP/MTS',
            self::V => 'SMA/SMK/MA',
            self::VI => 'Lainnya',
        };
    }
}
