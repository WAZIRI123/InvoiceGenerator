<?php

namespace Tests\Feature\Livewire\AcademicPerformance;

use App\Livewire\AcademicPerformance\ExamResult;
use App\Models\Classes;
use App\Models\ExamResult as ModelsExamResult;
use App\Models\Semester;
use App\Models\GradeSystem;
use App\Models\Role;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Database\Seeders\DataTesterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role as ModelsRole;
use Tests\TestCase;

class ExamResultTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DataTesterSeeder::class);
    }


    public function test_exam_results_cover_all_subjects_in__all_semesters()
    {
        $user=User::factory()->create();

        $teacherRole = User::role('admin')->first();

        $user->assignRole([ $teacherRole->id]);

        $class= Classes::factory()->create();

        $examResultsSemester2 =ModelsExamResult::where('student_id',3)->where('semester_id', 2)->get();

        $semester2Subjects=Semester::find(2)->subjects?->pluck('id')->toArray();

        $semester1Subjects=Semester::find(1)->subjects?->pluck('id')->toArray();

        $examResultsSemester1 = ModelsExamResult::where('student_id', 3)->where('semester_id', 1)->get();

        $missingSubjectsSemester1 = array_diff($semester1Subjects, $examResultsSemester1->pluck('subject_id')->toArray());

        $missingSubjectsSemester2 = array_diff($semester2Subjects, $examResultsSemester2->pluck('subject_id')->toArray());



        Livewire::actingAs($user)
            ->test(ExamResult::class)
            ->set('students', 3)
            ->call('showStudentResult',3);
            
            $this->assertEquals(count($examResultsSemester2), count($semester2Subjects));

            $this->assertEmpty($missingSubjectsSemester1);

            $this->assertEmpty($missingSubjectsSemester2);
            
    }





    public function test_can_calculate_student_grades()
    {
        $student = Student::factory()->create();
        $examResults = ModelsExamResult::factory(2)->create(['student_id' => $student->id]);

        $component = ExamResult::make(['students' => [$student->id]]);
        $component->calculateSubjectGrades($examResults);

        $this->assertEquals([
            $examResults[0]->subject->name => [
                'Marks Obtained' => $examResults[0]->marks_obtained,
                'Grade' => 'A',
            ],
            $examResults[1]->subject->name => [
                'Marks Obtained' => $examResults[1]->marks_obtained,
                'Grade' => 'B',
            ],
        ], $component->data['semesterResults']['semester 1']['subjectGrades']);
    }

    public function test_can_calculate_student_ranks()
    {
        $student = Student::factory()->create();
        $examResults = ModelsExamResult::factory(2)->create(['student_id' => $student->id]);

        $component = ExamResult::make(['students' => [$student->id]]);
        $component->calculateStudentRanks($examResults);

        $this->assertEquals(1, $component->data['semesterRanks']['semester 1']);
        $this->assertEquals(2, $component->data['semesterRanks']['semester 2']);
    }

    public function test_can_calculate_student_status()
    {
        $student = Student::factory()->create();
        $examResults = ModelsExamResult::factory(2)->create(['student_id' => $student->id]);

        $component = ExamResult::make(['students' => [$student->id]]);
        $component->calculateStudentStatus($examResults);

        $this->assertEquals('pass', $component->data['status Semester 1']);
        $this->assertEquals('pass', $component->data['status Semester 2']);
    }
}
