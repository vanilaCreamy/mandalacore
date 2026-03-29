<?php

namespace App\enum;

use App\enum\Concerns\HasOptions;

enum AttendanceStatus: string
{
    use HasOptions;

    case PRESENT = 'PRESENT';          // Hadir tepat waktu
    case LATE = 'LATE';                // Hadir tapi terlambat
    case EXCUSED = 'EXCUSED';          // Izin
    case SICK = 'SICK';                // Sakit
    case ABSENT = 'ABSENT';            // Tidak hadir tanpa keterangan
    case ON_DUTY = 'ON_DUTY';          // Sedang bertugas di luar lokasi

    public function label(): string
    {
        return match($this) {
            self::PRESENT => 'Hadir',
            self::LATE => 'Terlambat',
            self::EXCUSED => 'Izin',
            self::SICK => 'Sakit',
            self::ABSENT => 'Alpa',
            self::ON_DUTY => 'Dinas Luar',
        };
    }
}