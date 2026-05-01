<?php

namespace Database\Factories;

use App\Models\Remark;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Remark>
 */
class RemarkFactory extends Factory
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
            'teacher_id' => \App\Models\User::factory()->teacher(),
            'remark_text' => fake()->randomElement([
                'Excellent progress in all subjects.',
                'Needs to focus more on Mathematics.',
                'Very active in class discussions.',
                'Consistently submits assignments on time.',
                'A pleasure to have in class.',
            ]),
            'date' => fake()->date(),
        ];
    }
}
