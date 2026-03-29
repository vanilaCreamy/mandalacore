<?php

namespace App\Models;

use App\enums\AttendanceType;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    protected $fillable = [
        'attendance_id',
        'created_by',
        'logged_at',
        'type',
        'note',
    ];

    protected $casts = [
        'type' => AttendanceType::class,
    ];

    public function maker()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
