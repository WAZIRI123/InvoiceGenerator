<?php

namespace Database\Factories;

use App\Models\Exam;
use App\Models\Semester;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamResult>
 */
class ExamResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory()->create(),
            'exam_id' => Exam::factory()->create(),
            'subject_id' => Subject::factory()->create(),
            'semester_id' => Semester::factory()->create(),
            'marks_obtained' => rand(0, 100),
        ];
    }
}
