<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $teachers = User::where('role', 'teacher')->pluck('id');

        foreach ($students as $student) {
            for ($i = 0; $i < 30; $i++) {
                $date = now()->subDays($i);
                
                // Skip Sundays
                if ($date->dayOfWeek === 0) continue;

                $rand = rand(1, 100);
                if ($rand <= 80) {
                    $status = 'present';
                } elseif ($rand <= 95) {
                    $status = 'absent';
                } else {
                    $status = 'late';
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'class_id' => $student->class_id,
                    'date' => $date->format('Y-m-d'),
                    'status' => $status,
                    'marked_by' => $teachers->random(),
                ]);
            }
        }
    }
}
