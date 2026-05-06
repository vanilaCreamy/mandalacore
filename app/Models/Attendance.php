<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'recorded_by',
        'date',
        'status',
        'first_check_in',
        'last_check_out',
        'late_minutes',
        'work_minutes',
        'is_overtime',
    ];

    protected $casts = [
        'status' => AttendanceStatus::class,
        'date' => 'date',
        'first_check_in' => 'datetime',
        'last_check_out' => 'datetime',
    ];

    public function calculate(): void
    {
        if (!$this->first_check_in) {
            return;
        }

        $user = $this->user;
        $checkIn = $this->first_check_in->copy();
        $date = $this->date->toDateString();

        $schedules = $user->role->schedules();

        $matchedStart = null;
        $matchedEnd = null;

        foreach ($schedules as $s) {

            $start = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                "$date {$s['start']}"
            );

            $end = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                "$date {$s['end']}"
            );

            // Jika end < start → berarti shift lewat tengah malam
            if ($end->lt($start)) {
                $end->addDay();
            }

            // Jika checkin setelah tengah malam (misal 01:00) dan shift mulai kemarin
            if ($checkIn->lt($start)) {
                $start->subDay();
                $end->subDay();
            }

            // Cek apakah checkin masuk dalam rentang jadwal
            if ($checkIn->between($start, $end)) {
                $matchedStart = $start;
                $matchedEnd = $end;
                break;
            }

            // Jika tidak pas di dalam, cek apakah ini kandidat paling dekat sebelum checkin (untuk kasus telat)
            if ($checkIn->gt($start)) {
                $matchedStart = $start;
                $matchedEnd = $end;
            }
        }

        // Jika tetap tidak ketemu (sangat jarang), fallback ke sesi pertama
        if (!$matchedStart) {
            $first = $schedules[0];

            $matchedStart = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                "$date {$first['start']}"
            );

            $matchedEnd = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                "$date {$first['end']}"
            );

            if ($matchedEnd->lt($matchedStart)) {
                $matchedEnd->addDay();
            }
        }

        // Hitung keterlambatan
        $this->late_minutes = max(
            0,
            $matchedStart->diffInMinutes($checkIn, false)
        );

        // Hitung durasi kerja
        if ($this->last_check_out) {
            $checkOut = $this->last_check_out->copy();

            // Jika checkout lebih kecil dari checkin → berarti lewat tengah malam
            if ($checkOut->lt($checkIn)) {
                $checkOut->addDay();
            }

            $this->work_minutes = $checkIn->diffInMinutes($checkOut);
        }

        $this->status = $this->resolveStatus();
    }


    private function resolveStatus(): AttendanceStatus
    {
        // Jika status sudah diset manual (izin/sakit/absent), jangan diubah
        if (in_array($this->status, [
            AttendanceStatus::SICK,
            AttendanceStatus::EXCUSED,
            AttendanceStatus::ABSENT,
        ])) {
            return $this->status;
        }

        if (!$this->first_check_in) return AttendanceStatus::ABSENT;
        if ($this->late_minutes > 0) return AttendanceStatus::LATE;

        return AttendanceStatus::PRESENT;
    }


    // RELATIONSHIP
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }
    
}
