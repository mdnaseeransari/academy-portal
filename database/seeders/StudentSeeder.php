<?php

namespace Database\Seeders;

use App\Models\AcademicClass;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Arjun Mehta', 'Sneha Kapoor', 'Vikram Rao', 'Ananya Iyer', 'Rohan Das',
            'Ishita Gupta', 'Kabir Malhotra', 'Meera Reddy', 'Aditya Joshi', 'Sanya Verma'
        ];

        $classes = AcademicClass::all();

        foreach ($names as $index => $name) {
            $email = strtolower(str_replace(' ', '.', $name)) . '@student.com';
            
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('student123'),
                'role' => 'student',
                'is_active' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'class_id' => $classes->random()->id,
                'roll_number' => str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'parent_name' => 'Parent of ' . $name,
                'parent_phone' => '98800' . rand(10000, 99999),
                'address' => 'Sample Address, India',
                'admission_date' => now()->subMonths(rand(1, 12))->format('Y-m-d'),
            ]);
        }
    }
}
