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
    ];

    protected $casts = [
        'status' => AttendanceStatus::class,
        'date' => 'date',
        'first_check_in' => 'datetime',
        'last_check_out' => 'datetime',
    ];

    // HELPER
    public function calculate(): void
    {
        if (!$this->first_check_in) return;

        $user = $this->user;

        $date = $this->date->toDateString();

        $start = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $date . ' ' . $user->role->checkInTime()
        );

        $checkIn = $this->first_check_in;

        $this->late_minutes = max(0, $start->diffInMinutes($checkIn, false));

        if ($this->last_check_out) {

            $checkOut = $this->last_check_out->copy();

            // 🔥 jika checkout < checkin → tambah 1 hari
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
