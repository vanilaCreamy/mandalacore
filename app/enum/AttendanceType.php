<?php

namespace App\enum;

use App\enum\Concerns\HasOptions;

enum AttendanceType: string
{
    use HasOptions;

    case CHECK_IN = 'CHECK_IN';
    case CHECK_OUT = 'CHECK_OUT';
    case EXCUSE = 'EXCUSE';
    case CORRECTION = 'CORRECTION';
    case AUTO_MARK = 'AUTO_MARK';

    public function label(): string
    {
        return match ($this) {
            self::CHECK_IN => 'Check In',
            self::CHECK_OUT => 'Check Out',
            self::EXCUSE => 'Izin',
            self::CORRECTION => 'Koreksi Data',
            self::AUTO_MARK => 'Otomatis Sistem',
        };
    }
}
