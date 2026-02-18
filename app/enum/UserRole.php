<?php

namespace App\enum;

enum UserRole: string
{
    case ADMIN = "ADMIN";
    case KEPALA = "KEPALA";
    case PLOG = "PLOG";
    case PLOK = "PLOK";
    case ASLAP = "ASLAP";
    case PERSIAPAN = "PERSIAPAN";
    case PENGOLAHAN = "PENGOLAHAN";
    case PEMORSIAN = "PEMORSIAN";
    case DRIVER = "DRIVER";
    case PENCUCIAN = "PENCUCIAN";

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
