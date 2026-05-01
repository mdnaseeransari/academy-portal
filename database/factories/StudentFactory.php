<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->student(),
            'class_id' => \App\Models\AcademicClass::factory(),
            'roll_number' => str_pad(fake()->unique()->numberBetween(1, 30), 3, '0', STR_PAD_LEFT),
            'parent_name' => fake('en_IN')->name(),
            'parent_phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'admission_date' => fake()->date(),
        ];
    }
}
