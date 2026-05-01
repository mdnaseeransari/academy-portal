<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'user_id',
        'class_id',
        'roll_number',
        'parent_name',
        'parent_phone',
        'address',
        'admission_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }
}
