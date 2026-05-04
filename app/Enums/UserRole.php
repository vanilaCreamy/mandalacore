<?php

namespace App\Enums;

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
    case DISTRIBUSI = "DISTRIBUSI";
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
            self::DISTRIBUSI => 'Distribusi',
            self::PENCUCIAN => 'Pencucian',
        };
    }

    public function dashboardType(): string
    {
        return match ($this) {
            self::ADMIN,
            self::KEPALA,
            self::PLOG,
            self::PLOK,
            self::ASLAP => 'management',

            self::PERSIAPAN,
            self::PENGOLAHAN,
            self::PEMORSIAN,
            self::DISTRIBUSI,
            self::PENCUCIAN => 'operational',
        };
    }

    public function checkInTime()
    {
        return match ($this) {
            self::ADMIN,
            self::KEPALA,
            self::PLOG,
            self::PLOK,
            self::ASLAP => '06:00:00',
            self::PERSIAPAN => '18:00:00',
            self::PENGOLAHAN => '23:00:00',
            self::PEMORSIAN => '03:00:00',
            self::DISTRIBUSI => '06:00:00',
            self::PENCUCIAN => '12:00:00',
        };
    }
}
