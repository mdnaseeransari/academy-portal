<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Database\Seeder;

class TimetableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = AcademicClass::where('name', 'Class 10-A')->first();
        if (!$class) return;

        $teachers = User::where('role', 'teacher')->get();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $subjects = ['Mathematics', 'Science', 'English', 'Hindi', 'History', 'Geography'];

        foreach ($days as $day) {
            $startTime = \Carbon\Carbon::createFromTime(8, 0, 0);
            
            for ($i = 0; $i < 6; $i++) {
                $endTime = (clone $startTime)->addMinutes(45);
                
                Timetable::create([
                    'class_id' => $class->id,
                    'day' => $day,
                    'subject' => $subjects[$i],
                    'time_start' => $startTime->format('H:i:s'),
                    'time_end' => $endTime->format('H:i:s'),
                    'teacher_id' => $teachers->random()->id,
                ]);

                // Next period starts after 5 mins break
                $startTime = (clone $endTime)->addMinutes(5);
            }
        }
    }
}
