<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Rahul Sharma',
                'email' => 'rahul@optimal.com',
                'subject' => 'Mathematics',
                'class' => 'Class 9-A',
            ],
            [
                'name' => 'Priya Singh',
                'email' => 'priya@optimal.com',
                'subject' => 'Science',
                'class' => 'Class 9-B',
            ],
            [
                'name' => 'Amit Kumar',
                'email' => 'amit@optimal.com',
                'subject' => 'English',
                'class' => 'Class 10-A',
            ],
        ];

        foreach ($teachers as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('teacher123'),
                'role' => 'teacher',
                'is_active' => true,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'subject' => $data['subject'],
                'phone' => '9876543210',
                'qualification' => 'B.Ed',
            ]);

            // Assign teacher to the class
            AcademicClass::where('name', $data['class'])->update([
                'teacher_id' => $user->id,
            ]);
        }
    }
}
