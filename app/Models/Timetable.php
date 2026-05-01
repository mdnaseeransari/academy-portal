<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    protected $fillable = [
        'class_id',
        'day',
        'subject',
        'time_start',
        'time_end',
        'teacher_id',
    ];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}
