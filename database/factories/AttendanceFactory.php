<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'class_id' => \App\Models\AcademicClass::factory(),
            'date' => fake()->date(),
            'status' => fake()->randomElement([
                ...array_fill(0, 80, 'present'),
                ...array_fill(0, 15, 'absent'),
                ...array_fill(0, 5, 'late'),
            ]),
            'marked_by' => \App\Models\User::factory()->teacher(),
        ];
    }
}
