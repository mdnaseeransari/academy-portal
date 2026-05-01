<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'subject',
        'phone',
        'qualification',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->hasMany(AcademicClass::class, 'teacher_id', 'user_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id', 'user_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'teacher_id', 'user_id');
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class, 'teacher_id', 'user_id');
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class, 'teacher_id', 'user_id');
    }
}
