<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => \App\Models\AcademicClass::factory(),
            'teacher_id' => \App\Models\User::factory()->teacher(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'file_path' => null,
            'due_date' => fake()->dateTimeBetween('+1 week', '+1 month')->format('Y-m-d'),
        ];
    }
}
