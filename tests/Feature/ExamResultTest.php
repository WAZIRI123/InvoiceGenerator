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
use Database\Seeders\AllSubjectMustMarkedData;
use Database\Seeders\AllSubjectMustMarkedDataSemester2;
use Database\Seeders\DataTesterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Livewire\Livewire;
use Spatie\Permission\Models\Role as ModelsRole;
use Tests\TestCase;

class ExamResultTest extends TestCase
{
    use RefreshDatabase;
    

    public function test_exam_results_cover_all_subjects_in_semesters1()
    {
        $this->seed(AllSubjectMustMarkedData::class);
        $user=User::factory()->create();

        $teacherRole = User::role('admin')->first();

        $user->assignRole([ $teacherRole->id]);

        $class= Classes::factory()->create();

        $semester1Subjects=Semester::find(1)->subjects?->pluck('id')->toArray();

        $examResultsSemester1 = ModelsExamResult::where('student_id', 3)->where('semester_id', 1)->get();
      $test=$examResultsSemester1->pluck('subject_id')->toArray();
     
       
        $missingSubjectsSemester1 =array_diff($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects);


        Livewire::actingAs($user)
            ->test(ExamResult::class)
            ->set('students', 3)
            ->call('showStudentResult',3);
            
            $this->assertEquals(count($examResultsSemester1), count($semester1Subjects));

            $this->assertEmpty($missingSubjectsSemester1);
            Artisan::call('migrate:fresh');
            
    }

    

    public function test_exam_results_cover_all_subjects_in_semesters2()
    {

        $this->refreshDatabase();
        $this->seed(AllSubjectMustMarkedDataSemester2::class);
        $user=User::factory()->create();

        $teacherRole = User::role('admin')->first();

        $user->assignRole([ $teacherRole->id]);

        $class= Classes::factory()->create();

        $semester2Subjects=Semester::find(2)->subjects?->pluck('id')->toArray();

        $examResultsSemester2 = ModelsExamResult::where('student_id', 3)->where('semester_id', 2)->get();
      $test=$examResultsSemester2->pluck('subject_id')->toArray();
     
       
        $missingSubjectsSemester2 =array_diff($examResultsSemester2->pluck('subject_id')->toArray(),$semester2Subjects);


        Livewire::actingAs($user)
            ->test(ExamResult::class)
            ->set('students', 3)
            ->call('showStudentResult',3);
            
            $this->assertEquals(count($examResultsSemester2), count($semester2Subjects));

            $this->assertEmpty($missingSubjectsSemester2);
            
    }
    


}
