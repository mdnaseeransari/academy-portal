<?php

namespace Database\Factories;

use App\Models\AcademicClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicClass>
 */
class AcademicClassFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Class ' . fake()->randomElement(['9', '10', '11', '12']) . '-' . fake()->randomElement(['A', 'B', 'C']),
            'teacher_id' => \App\Models\User::factory()->teacher(),
        ];
    }
}
