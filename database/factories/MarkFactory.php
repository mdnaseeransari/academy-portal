<?php

namespace Database\Factories;

use App\Models\Mark;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mark>
 */
class MarkFactory extends Factory
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
            'subject' => fake()->randomElement(['Mathematics', 'Science', 'English', 'Hindi', 'History']),
            'exam_type' => fake()->randomElement(['unit_test', 'half_yearly', 'final', 'other']),
            'marks_obtained' => fake()->randomFloat(2, 40, 100),
            'total_marks' => 100,
            'teacher_id' => \App\Models\User::factory()->teacher(),
            'remarks' => fake()->sentence(),
        ];
    }
}
