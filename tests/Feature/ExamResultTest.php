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

      $examResultsSemesterStudent1 = ModelsExamResult::where('student_id', 1)->where('semester_id', 1)->get();
   
      $totalMarksSemesterStudent = 0;

      $totalSubjectsSemesterStudent = 0;
 
      foreach ( $examResultsSemester1 as $result) {
 
      $totalMarksSemesterStudent  += $result->marks_obtained;
      
      $totalSubjectsSemesterStudent++;
 
      }
      $student=Student::find(3);
      $rankSemesterStudent =$totalMarksSemesterStudent ? Student::where('classes_id', $student->classes_id)
 
      ->where('stream_id', $student->stream_id)
 
      ->where('academic_year_id', $student->academic_year_id)
 
      ->where('semester_id', 1)
 
      ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 1) > ?", [$totalMarksSemesterStudent])
 
      ->count() + 1:'';

     $totalMarksSemester1 = 0;

     $totalSubjectsSemester1 = 0;

     foreach ($examResultsSemesterStudent1 as $result) {

     $totalMarksSemester1 += $result->marks_obtained;
     
     $totalSubjectsSemester1++;

     }
     $student1=Student::find(1);
     $rankSemesterStudent1 =$totalSubjectsSemester1? Student::where('classes_id', $student1->classes_id)

     ->where('stream_id', $student1->stream_id)

     ->where('academic_year_id', $student1->academic_year_id)

     ->where('semester_id', 1)

     ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 1) > ?", [$totalMarksSemester1])

     ->count() + 1:'';

    //  $cumulativeAverageSemester1 = $totalSubjectsSemester1 > 0 ? ($totalMarksSemester1 / $totalSubjectsSemester1) : 0;
       
        $missingSubjectsSemester1 =array_diff($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects);


        Livewire::actingAs($user)
            ->test(ExamResult::class)
            ->set('students', 3)
            ->call('showStudentResult',3);
            
            $this->assertEquals(count($examResultsSemester1), count($semester1Subjects));

            $this->assertEquals($rankSemesterStudent,1);
            
            $this->assertEquals($rankSemesterStudent1,2);

            $this->assertEmpty($missingSubjectsSemester1);
            Artisan::call('migrate:fresh');

            
    }

    public function test_teacher_see_his_students_only()
    {
        Artisan::call('migrate:fresh');
        $this->seed(AllSubjectMustMarkedData::class);

        $class= Classes::factory()->create();

        $user=User::factory()->create();

        $teacher= Teacher::factory()->create(['user_id'=>$user->id]);

        $teacherRole = User::role('teacher')->first();

        $user->assignRole([ $teacherRole->id]);

        $students=Student::factory(5)->create([
            'classes_id' =>$class->id
        ]);
       
        $teacher->classes()->attach($class->id);


        Livewire::actingAs($user)
            ->test(ExamResult::class);
   
         $this->assertEquals(5,$students->count());
    

            
    }


    public function test_teacher_can_not_see_others_students()
    {
        Artisan::call('migrate:fresh');
        $this->seed(AllSubjectMustMarkedData::class);

        $class= Classes::factory()->create();

        $class2= Classes::factory()->create();

        $user=User::factory()->create();

        $teacher= Teacher::factory()->create(['user_id'=>$user->id]);

        $teacherRole = User::role('teacher')->first();

        $user->assignRole([ $teacherRole->id]);

        $students=Student::factory(5)->create([
            'classes_id' =>$class->id
        ]);
       
        $teacher->classes()->sync([$class2->id]);

        Livewire::actingAs($user)
            ->test(ExamResult::class);
   
         $this->assertNotEquals(5,'students');
         
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
