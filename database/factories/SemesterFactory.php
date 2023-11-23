<?php

namespace Database\Factories;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semester>
 */
class SemesterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Fall Semester',
            'classes_id' => Classes::factory()->create(),
            'description' => 'The Fall Semester is the first semester of the academic year.',
            'start_date' => '2023-08-29',
            'end_date' => '2023-12-22',
        ];
    }
}
