<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'created_by',
        'subject',
        'topic',
        'exam_type',
        'scheduled_date',
        'total_marks',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function academicClass()
    {
        return $this->belongsTo(AcademicClass::class, 'class_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
