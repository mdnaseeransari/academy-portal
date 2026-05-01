<?php

namespace Database\Factories;

use App\Models\AssignmentSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssignmentSubmission>
 */
class AssignmentSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assignment_id' => \App\Models\Assignment::factory(),
            'student_id' => \App\Models\Student::factory(),
            'file_path' => 'submissions/' . fake()->word() . '.pdf',
            'submitted_at' => now(),
            'status' => fake()->randomElement(['submitted', 'late', 'graded']),
            'grade' => fake()->randomElement(['A', 'B', 'C', 'D']),
        ];
    }
}
