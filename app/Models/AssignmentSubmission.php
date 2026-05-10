<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $table = 'assignment_submissions';

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'submitted_at',
        'status',
        'grade',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file_path) return null;
        if (filter_var($this->file_path, FILTER_VALIDATE_URL)) {
            return $this->file_path;
        }
        return \Illuminate\Support\Facades\Storage::url($this->file_path);
    }
}
