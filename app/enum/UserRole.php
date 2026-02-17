<?php

namespace App\enum;

enum UserRole
{
    case ADMIN;
    case KEPALA;
    case PLOG;
    case PLOK;
    case ASLAP;
    case PERSIAPAN;
    case PENGOLAHAN;
    case PEMORSIAN;
    case DRIVER;
    case PENCUCIAN;

    public function label()
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::KEPALA => 'Kepala SPPG',
            self::PLOG => 'Pengawas Gizi',
            self::PLOK => 'Pengawas Keuangan',
            self::ASLAP => 'Asisten Lapangan',
            self::PERSIAPAN => 'Persiapan',
            self::PENGOLAHAN => 'Pengolahan',
            self::PEMORSIAN => 'Pemorsian',
            self::DRIVER => 'Driver',
            self::PENCUCIAN => 'Pencucian',
        };
    }
}
