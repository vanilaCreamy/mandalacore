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
}
