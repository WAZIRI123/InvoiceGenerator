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
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DataTesterSeeder extends Seeder
{
    use DateTime;
    /**
     * Run the database seeds.
     *
     * @return void
     */

     public function recordExists(int $studentId, int $examId, int $subjectId, int $semesterId): bool
     {
         return ExamResult::where('student_id', $studentId)

             ->where('exam_id', $examId)

             ->where('subject_id', $subjectId)

             ->where('semester_id', $semesterId)

             ->exists();

     }


    public function run()
    {
     
            $class = Classes::factory()->create();

            $class2 = Classes::factory()->create();    

            $subject=Subject::create([

            'name' => 'test subjects',

            'subject_code' => '10test',

            'classes_id'=>$class->id,

            'description' => 'test desc',

    ]);

    $subject2=Subject::create([

            'name' => 'test subjects2',

            'subject_code' => '10test',

            'classes_id'=>$class->id,

            'description' => 'test desc',

    ]);

     $semester = Semester::create([

            'name' => 'Fall Semester',

            'classes_id'=>$class->id,

            'description' => 'The Fall Semester is the first semester of the academic year.',

            'start_date' => '2023-08-29',

            'end_date' => '2023-12-22',

    ]);

    $semester2 = Semester::create([

            'name' => 'Fall Semester2',

            'classes_id'=>$class2->id,
            
            'description' => 'The Fall Semester is the first 2 semester of the academic year.',

            'start_date' => '2023-08-29',

            'end_date' => '2023-12-22',

    ]);

    $semester->subjects()->attach([$subject->id,$subject2->id]);

    $semester2->subjects()->attach([$subject->id]);

        $user=User::create([

            'name' => 'John Doe',

            'email' => 'john@example.com',

            'password' => bcrypt('password123'),

        ]);

        $teacherRole = Role::create(['name' => 'teacher']);

        $useradmin=User::create([

            'name' => 'John Doe',

            'email' => 'admin@example.com',

            'password' => bcrypt('password123'),

        ]);
        $adminRole = Role::create(['name' => 'admin']);

        $useradmin->assignRole([ $adminRole->id]);

        $Stream=Stream::create([

            'name'=>'test stream',

            'classes_id'=>$class->id
        ]);

        $teacher=Teacher::create([

            'user_id' => $user->id,

            'date_of_birth' => '1990-01-01',

            'gender' =>  'female',

            'registration_no' => '123456',

            'date_of_employment' => '2021-01-01',

        ]);
        $teacher->classes()->attach([$class->id,$class2->id]); 
      
        $user->assignRole([$teacherRole->id]);
    

        $exam = Exam::create([

                'name' => 'My Exam',

                'slug' => 'my-exams',

                'classes_id'=>$class->id,

                'semester_id'=>$semester->id,

                'subject_id'=>$subject->id,

                'description' => 'This is my exam.',

                'start_date' => now(),

                'end_date' => now()->addDays(1),

        ]);

        $user2=User::create([

                'name' => 'John Doe2',

                'email' => 'john@example2.com',

                'password' => bcrypt('password123'),

        ]);

                // Seed the grading scale data
                $gradingScale = [
                        ['remark' => 'A', 'mark_from' => 90, 'mark_to' => 100],
                        ['remark' => 'B', 'mark_from' => 61, 'mark_to' => 89],
                        ['remark' => 'C', 'mark_from' => 40, 'mark_to' => 60],
                        ['remark' => 'D', 'mark_from' => 30, 'mark_to' => 40],
                        ['remark' => 'F', 'mark_from' => 0, 'mark_to' => 29],
                    ];

                    
            
                DB::table('grade_systems')->insert($gradingScale);

        $studentRole = Role::create(['name' => 'student']);

        $user3 = User::create([

                'name' => 'Student1',
                
                'email' => 'student1@example.com',
                
                'password' => bcrypt('password123'),
            
        ]);

        $student2 = Student::create([

                'user_id' => $user3->id,
                
                'admission_no' => 'A102',
                
                'date_of_birth' => '1995-03-15',
                
                'classes_id' => $class->id,
                
                'stream_id' => $Stream->id,
                
                'gender' => 'female',
                
                'semester_id' => $semester->id,
                
                'date_of_admission' => '2021-02-15',
                
                'is_graduate' => 0,
                
                'academic_year_id' => $this->getFinancialYear()->start.'-'.$this->getFinancialYear()->end,

        ]);
        $user3->assignRole([$studentRole->id]);

        $user4 = User::create([

                'name' => 'Student 2',

                'email' => 'student2@example.com',

                'password' => bcrypt('password123'),

            
        ]);

        $student4 = Student::create([

                'user_id' => $user4->id,

                'admission_no' => 'A103',

                'date_of_birth' => '1998-07-20',

                'classes_id' => $class->id,

                'semester_id' => $semester->id,

                'stream_id' => $Stream->id,

                'gender' => 'female',

                'date_of_admission' => '2021-03-20',

                'is_graduate' => 0, 

                'academic_year_id' => $this->getFinancialYear()->start.'-'.$this->getFinancialYear()->end,

        ]);
        $user4->assignRole([$studentRole->id]);
        
        $student=Student::create([

                'user_id' => $user->id,

                'admission_no' => 'A101',

                'date_of_birth' => '1990-01-01',

                'classes_id' => $class->id,

                'semester_id' => $semester->id,

                'stream_id' => $Stream->id,

                'gender' => 'female',

                'date_of_admission' => '2021-01-01',

                'is_graduate' => 1, 

                'academic_year_id' => $this->getFinancialYear()->start.'-'.$this->getFinancialYear()->end,
        ]);

        $user2->assignRole([$studentRole->id]);

       $recordExists = $this->recordExists($student->id, $exam->id, $subject->id, $semester->id);

       if (! $recordExists) {

        ExamResult::create([

                'student_id' => $student->id,
                
                'exam_id' => $exam->id,
                
                'subject_id'=>$subject->id,
                
                'semester_id'=>$semester->id,
                
                'marks_obtained' => rand(0, 100),

        ]);

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

        if(empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }

       }

    $recordExists = $this->recordExists($student->id, $exam->id, $subject->id, $semester->id);

    if (! $recordExists) {

       ExamResult::create([

                'student_id' => $student->id,
                
                'exam_id' => $exam->id,
                
                'subject_id'=>$subject->id,
                
                'semester_id'=>$semester->id,
                
                'marks_obtained' => rand(0, 100),
        
    ]);

    $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

    $student=Student::find($student->id);
    $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

    if(empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

        $student = Student::find($student->id);

        $student->resultStatus = 'complete';

         $student->save();

        }

}

        $recordExists = $this->recordExists($student->id, $exam->id, $subject2->id, $semester->id);

        if (! $recordExists) {

        ExamResult::create([

                'student_id' => $student->id,

                'exam_id' => $exam->id,

                'subject_id'=>$subject2->id,

                'semester_id'=>$semester->id,

                'marks_obtained' => rand(0, 100),

        ]);
        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

        if(empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }
        }


         $recordExists = $this->recordExists($student2->id, $exam->id, $subject->id, $semester->id);

         if (! $recordExists) {

        ExamResult::create([

                'student_id' => $student2->id,

                'exam_id' => $exam->id,

                'subject_id'=>$subject->id,

                'semester_id'=>$semester->id,

                'marks_obtained' => rand(0, 100),

        ]); 

        $examResultsSemester1 = ExamResult::where('student_id', $student2->id)->where('semester_id', 1)->get();

        $student=Student::find($student2->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

        if(empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

            $student = Student::find($student2->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }
         }

     // Check if a record exists
     $recordExists = $this->recordExists($student2->id, 
     $exam->id, $subject2->id, $semester->id);

     if (! $recordExists) {

         ExamResult::create([

                'student_id' => $student2->id,

                'exam_id' => $exam->id,

                'subject_id'=>$subject2->id,

                'semester_id'=>$semester->id,

                'marks_obtained' => rand(0, 100),

        ]);

        $examResultsSemester1 = ExamResult::where('student_id', $student2->id)->where('semester_id', 1)->get();

        $student=Student::find($student2->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

        if(empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

            $student = Student::find($student2->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }

     }

         // Check if a record exists
         $recordExists = $this->recordExists($student->id, 
         $exam->id, $subject->id, $semester2->id);

         if (! $recordExists) {

        ExamResult::create([

                'student_id' => $student->id,

                'exam_id' => $exam->id,

                'subject_id'=>$subject->id,

                'semester_id'=>$semester2->id,

                'marks_obtained' => rand(0, 100),

        ]);

        $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

        $student=Student::find($student->id);
        $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

        if(empty(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray()))){

            $student = Student::find($student->id);

            $student->resultStatus = 'complete';

             $student->save();
    
            }
    }

    }
}
