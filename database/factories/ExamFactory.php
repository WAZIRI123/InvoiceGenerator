<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Semester;
use App\Models\Subject;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'My Exam',
            'slug' => Str::slug('My Exam'),
            'classes_id' => Classes::factory()->create(),
            'semester_id' => Semester::factory()->create(),
            'subject_id' => Subject::factory()->create(),
            'description' => 'This is my exam.',
            'start_date' => now(),
            'end_date' => now()->addDays(1),
        ];
    }
}
