<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;
use App\Models\Semester;
use App\Models\Stream;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\DateTime;
use App\Traits\DataTesterTrait;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DataTesterSeeder extends Seeder
{
    use DateTime,DataTesterTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */



    public function run()
    {
        
 $classId1 = Classes::factory()->create()->id;

 $classId2 = Classes::factory()->create()->id;

 $classId3 = Classes::factory()->create()->id;

 $classId4 = Classes::factory()->create()->id;
 
 $classId5 = Classes::factory()->create()->id;

 $classId6 = Classes::factory()->create()->id;

 $classId7 = Classes::factory()->create()->id;

 $subject=$this->createSubject($classId1, 'math', 'math01', 'math');

 $subject2=$this->createSubject($classId1, 'english', 'english01', 'english');

 $subject3=$this->createSubject($classId1, 'civics', 'civics01', 'civics');

 $subject4=$this->createSubject($classId1, 'swahilli', 'swahilli01', 'swahilli');

 $subject5=$this->createSubject($classId1, 'sport', 'sport01', 'sport');

 $subject6=$this->createSubject($classId1, 'Religious', 'Religious01', 'Religious');
 
 
     $semester = $this->createSemester('Fall Semester',
     $classId1,
     'The Fall Semester is the first semester of the academic year.',
     '2023-08-29',
     '2023-12-22');

     $semester2 = $this->createSemester('Fall Semester',
     $classId1,
     'The Fall Semester is the first semester of the academic year.',
     '2023-08-29',
     '2023-12-22');


    $semester->subjects()->attach([$subject->id,$subject2->id,$subject3->id,$subject4->id,$subject5->id]);

    $semester2->subjects()->attach([$subject5->id,$subject4->id,$subject6->id]);

    $user = $this->createUser('John Doe', 'john@eexample.com', 'password123');

        $teacherRole = Role::create(['name' => 'teacher']);

        $useradmin=$this->createUser('John Doe', 'john@example.com', 'password123');

        $adminRole = Role::create(['name' => 'admin']);

        $useradmin->assignRole([ $adminRole->id]);

        $stream = $this->createStream('test stream', $classId1);


        $teacher = $this->createTeacher($classId1, '1990-01-01', 'female', '123456', '2021-01-01');

        $teacher->classes()->attach([$classId1,$classId2]); 
      
        $user->assignRole([$teacherRole->id]);
    

        $exam = $this->createExam(
                'My Exam',
                'my-exams',
                $classId1,
                $semester->id,
                $subject->id,
                'This is my exam.',
                now(),
                now()->addDays(1)
            );



        $user2=$this->createUser('Student1','student12@example.com', bcrypt('password123'
              ));
  
        DB::table('grade_systems')->insert($this->gradingScale);

        $studentRole = Role::create(['name' => 'student']);

        $user3 = $this->createUser('Student1','student1@example.com', bcrypt('password123'));


        $student = $this->createStudent(
                $user3->id,
                'A102',
                '1995-03-15',
                $classId1,
                $stream->id,
                'female',
                $semester->id,
                '2021-02-15',
                0,
                $this->getFinancialYear()->start.'-'.$this->getFinancialYear()->end
            );
        $user3->assignRole([$studentRole->id]);

        $user4 = $this->createUser('Student 2', 'student2@example.com', 'password123');

        $user4->assignRole([$studentRole->id]);
        $student4 = $this->createStudent(
                $user4->id,
                'A103',
                '1998-07-20',
                $classId1,
                $stream->id,
                'female',
                $semester->id,
                '2021-03-20',
                0,
                $this->getFinancialYear()->start.'-'.$this->getFinancialYear()->end
            );

        $user4->assignRole([$studentRole->id]);
        
        $student = $this->createStudent(
                $user->id,
                'A101',
                '1990-01-01',
                $classId1,
                $stream->id,
                'female',
                $semester->id,
                '2021-01-01',
                1,
                $this->getFinancialYear()->start.'-'.$this->getFinancialYear()->end
            );

        $user2->assignRole([$studentRole->id]);

       $recordExists = $this->recordExists($student->id, $exam->id, $subject->id, $semester->id);

       if (! $recordExists) {

        $examResult = $this->createExamResult(
                $student->id,
                $exam->id,
                $subject->id,
                $semester->id,
                rand(0, 100)
                );

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);

        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();
 
        if(count(array_intersect($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects))===count($semester1Subjects) ){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }

       }

    $recordExists = $this->recordExists($student->id, $exam->id, $subject3->id, $semester->id);

    if (! $recordExists) {

$anotherExamResult = $this->createExamResult(
        $student->id,
        $exam->id,
        $subject3->id,
        $semester->id,
        rand(0, 100)
        );

    $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

    $student=Student::find($student->id);

    $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

      
    if(count(array_intersect($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects))===count($semester1Subjects) ){

        $student = Student::find($student->id);

        $student->resultStatus = 'complete';

         $student->save();

        }

}

        $recordExists = $this->recordExists($student->id, $exam->id, $subject2->id, $semester->id);

        if (! $recordExists) {

        $this->createExamResult(
                $student->id,
                $exam->id,
                $subject2->id,
                $semester->id,
                rand(0, 100)
                );

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();
 
        if(count(array_intersect($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects))===count($semester1Subjects) ){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }
        }


         $recordExists = $this->recordExists($student->id, $exam->id, $subject4->id, $semester->id);

         if (! $recordExists) {

        $this->createExamResult(
                $student->id,
                $exam->id,
                $subject4->id,
                $semester->id,
                rand(0, 100)
                ); 

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);

        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();
 
        if(count(array_intersect($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects))===count($semester1Subjects) ){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }
         }

     // Check if a record exists
     $recordExists = $this->recordExists($student->id, 
     $exam->id, $subject5->id, $semester->id);

     if (! $recordExists) {

        $this->createExamResult(
                $student->id,
                $exam->id,
                $subject5->id,
                $semester->id,
                rand(0, 100)
            );

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);

        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();
 
        if( count(array_intersect($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects))===count($semester1Subjects) ){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }

     }

         // Check if a record exists
         $recordExists = $this->recordExists($student->id, 
         $exam->id, $subject6->id, $semester->id);

         if (! $recordExists) {

        $this->createExamResult(
                $student->id,
                $exam->id,
                $subject6->id,
                $semester->id,
                rand(0, 100)
                );

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();
 
        if(empty(array_diff($examResultsSemester1->pluck('subject_id')->toArray(),$semester1Subjects)) && empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }
    }

    

    }
}
