<?php

namespace App\Models;

use App\enum\AttendanceStatus;
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }

    public function logs()
    {
        return $this->hasMany(AttendanceLog::class, 'attendance_id', 'id');
    }
    
}
