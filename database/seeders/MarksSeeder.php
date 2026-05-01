<?php

namespace Database\Seeders;

use App\Models\Mark;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class MarksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $teachers = User::where('role', 'teacher')->pluck('id');
        $subjects = ['Mathematics', 'Science', 'English'];

        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                Mark::create([
                    'student_id' => $student->id,
                    'subject' => $subject,
                    'exam_type' => 'unit_test',
                    'marks_obtained' => rand(50, 100),
                    'total_marks' => 100,
                    'teacher_id' => $teachers->random(),
                    'remarks' => 'Good performance',
                ]);
            }
        }
    }
}
