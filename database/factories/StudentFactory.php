<?php

namespace Database\Factories;

use App\Models\Classes;
use App\Models\Semester;
use App\Models\Stream;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
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
            'user_id' =>User::factory()->create(),
            'admission_no' => 'A101',
            'date_of_birth' => '1990-01-01',
            'classes_id' => Classes::factory()->create(),
            'semester_id' =>Semester::factory()->create(),
            'stream_id' => Stream::factory()->create(),
            'gender' => 'female',
            'date_of_admission' => '2021-01-01',
            'is_graduate' => 1,
            'academic_year_id' =>  '2021-01-01',
           
        ];
    }
}
