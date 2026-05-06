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
    case KEAMANAN = "KEAMANAN";
    case KEBERSIHAN = "KEBERSIHAN";

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
            self::KEAMANAN => 'Petugas Keamanan',
            self::KEBERSIHAN => 'Petugas Kebersihan',
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
            self::PENCUCIAN,
            self::KEAMANAN,
            self::KEBERSIHAN => 'operational',
        };
    }

    public function schedules(): array
    {
        return match ($this) {
            self::ADMIN,
            self::KEPALA,
            self::PLOG,
            self::PLOK => [
                ['start' => '08:00:00', 'end' => '16:00:00'],
            ],
            self::ASLAP => [
                ['start' => '06:00:00', 'end' => '18:00:00'],
                ['start' => '18:00:00', 'end' => '06:00:00'],
            ],

            self::PERSIAPAN => [
                ['start' => '18:00:00', 'end' => '02:00:00'],
            ],

            self::PENGOLAHAN => [
                ['start' => '23:00:00', 'end' => '07:00:00'],
            ],

            self::PEMORSIAN => [
                ['start' => '03:00:00', 'end' => '11:00:00'],
            ],

            self::DISTRIBUSI => [
                ['start' => '06:00:00', 'end' => '14:00:00'],
            ],

            self::PENCUCIAN => [
                ['start' => '12:00:00', 'end' => '20:00:00'],
            ],

            // 🔥 KEAMANAN 2 SHIFT
            self::KEAMANAN => [
                ['start' => '06:00:00', 'end' => '18:00:00'], // siang
                ['start' => '18:00:00', 'end' => '06:00:00'], // malam
            ],

            // 🔥 KEBERSIHAN 2 SESI
            self::KEBERSIHAN => [
                ['start' => '06:00:00', 'end' => '18:00:00'], // 2 sesi
            ],
        };
    }
}
