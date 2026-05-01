<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'class_id',
        'teacher_id',
        'title',
        'description',
        'file_path',
        'due_date',
    ];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'class_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }
}
