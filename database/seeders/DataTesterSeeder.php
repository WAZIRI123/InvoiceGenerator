<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Gender;
use App\Models\Semester;
use App\Models\Stream;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DataTesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $academicYear = AcademicYear::create([
            'academic_year' => '2023-2024',
            'start_date' => '2023-08-01',
            'end_date' => '2024-07-31',
            'status' => 'active',
        ]);
        AcademicYear::checkUserAcademicYear();

        $academicYear = AcademicYear::where('status', 'active')->first();

    $class = Classes::factory()->existing()->create()->pluck('id')->toArray();
        
     $semester = Semester::create([
    'name' => 'Fall Semester',
    'description' => 'The Fall Semester is the first semester of the academic year.',
    'start_date' => '2023-08-29',
    'end_date' => '2023-12-22',
        ]);
       
     
        $user=User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);
        $teacherRole = Role::create(['name' => 'teacher']);
        $gender=Gender::factory()->create();
        $Stream=Stream::create([
            'name'=>'test stream',
            'classes_id'=>$class->id
        ]);
        $teacher=Teacher::create([
            'user_id' => $user->id,
            'date_of_birth' => '1990-01-01',
            'gender_id' =>  $gender->id,
            'registration_no' => '123456',
            'date_of_employment' => '2021-01-01',
        ]);
        $subject=Subject::create([
            'name' => 'test subjects',
            'subject_code' => '10test',
            'classes_id'=>$class->id,
            'description' => 'test desc',
        ]);
        $user->assignRole([$teacherRole->id]);
    

        $exam = Exam::create([
            'name' => 'My Exam',
            'slug' => 'my-exams',
            'description' => 'This is my exam.',
            'start_date' => now(),
            'end_date' => now()->addDays(1),
            'subject_id'=>$subject->id
        ]);

        $user2=User::create([
            'name' => 'John Doe2',
            'email' => 'john@example2.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);
        $studentRole = Role::create(['name' => 'student']);

        $user3 = User::create([
            'name' => 'Student 1',
            'email' => 'student1@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        $student2 = Student::create([
            'user_id' => $user3->id,
            'admission_no' => 'A102',  // Change the admission number
            'date_of_birth' => '1995-03-15',  // Change the date of birth
            'classes_id' => $class->id,
            'stream_id' => $Stream->id,
            'gender_id' => $gender->id,
            'semester_id' => $semester->id,
            'date_of_admission' => '2021-02-15',  // Change the date of admission
            'is_graduate' => 0,  // Not a graduate
            'graduation_year' => null,  // No graduation year
            'academic_year_id' => $academicYear->id,
        ]);
        $user3->assignRole([$studentRole->id]);

        $user4 = User::create([
            'name' => 'Student 2',
            'email' => 'student2@example.com',
            'password' => bcrypt('password123'),
            'role' => 'student',
        ]);

        $student4 = Student::create([
            'user_id' => $user4->id,
            'admission_no' => 'A103',  // Change the admission number
            'date_of_birth' => '1998-07-20',  // Change the date of birth
            'classes_id' => $class->id,
            'semester_id' => $semester->id,
            'stream_id' => $Stream->id,
            'gender_id' => $gender->id,
            'date_of_admission' => '2021-03-20',  // Change the date of admission
            'is_graduate' => 0,  // Not a graduate
            'graduation_year' => null,  // No graduation year
            'academic_year_id' => $academicYear->id,
        ]);
        $user4->assignRole([$studentRole->id]);
        $student=Student::create([
            'user_id' => $user->id,
            'admission_no' => 'A101',
            'date_of_birth' => '1990-01-01',
            'classes_id' => $class->id,
            'semester_id' => $semester->id,
            'stream_id' => $Stream->id,
            'gender_id' => $gender->id,
            'date_of_admission' => '2021-01-01',
            'is_graduate' => 1, // 10% probability of being a graduate
            'graduation_year' => '2026-01-01', // 70% probability of having a graduation year
            'academic_year_id' => $academicYear->id,
        ]);
        $user2->assignRole([$studentRole->id]);

        
    }
}
