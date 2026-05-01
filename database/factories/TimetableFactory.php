<?php

namespace Database\Factories;

use App\Models\Timetable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Timetable>
 */
class TimetableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slot = fake()->randomElement([
            ['08:00:00', '09:00:00'],
            ['09:00:00', '10:00:00'],
            ['10:15:00', '11:15:00'],
            ['11:15:00', '12:15:00'],
            ['13:00:00', '14:00:00'],
        ]);

        return [
            'class_id' => \App\Models\AcademicClass::factory(),
            'day' => fake()->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']),
            'subject' => fake()->randomElement(['Mathematics', 'Science', 'English', 'Hindi', 'History']),
            'time_start' => $slot[0],
            'time_end' => $slot[1],
            'teacher_id' => \App\Models\User::factory()->teacher(),
        ];
    }
}
