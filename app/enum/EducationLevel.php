<?php

namespace App\Enum;

use App\enum\Concerns\HasOptions;

enum EducationLevel: string
{
    use HasOptions;

    case SD  = 'SD';
    case SMP = 'SMP';
    case SMA = 'SMA';
    case D3  = 'D3';
    case S1  = 'S1';

    public function label(): string
    {
        return match ($this) {
            self::SD  => 'SD / MI Sederajat',
            self::SMP => 'SMP / MTs Sederajat',
            self::SMA => 'SMA / MA / SMK Sederajat',
            self::D3  => 'Diploma 3 (D3)',
            self::S1  => 'Strata 1 (S1)',
        };
    }
}