<?php

namespace App\Traits;

use App\Models\ExamResult;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Teacher;
use App\Models\Stream;
use App\Models\Student;
use App\Models\User;
use App\Models\Semester;

trait DataTesterTrait
{
    public $gradingScale = [
        ['remark' => 'A', 'mark_from' => 90, 'mark_to' => 100],
        ['remark' => 'B', 'mark_from' => 61, 'mark_to' => 89],
        ['remark' => 'C', 'mark_from' => 40, 'mark_to' => 60],
        ['remark' => 'D', 'mark_from' => 30, 'mark_to' => 40],
        ['remark' => 'F', 'mark_from' => 0, 'mark_to' => 29],
        ];

     public function recordExists(int $studentId, int $examId, int $subjectId, int $semesterId): bool
     {
         return ExamResult::where('student_id', $studentId)

             ->where('exam_id', $examId)

             ->where('subject_id', $subjectId)

             ->where('semester_id', $semesterId)

             ->exists();

     }

public function createSubject($classId, $subjectName, $subjectCode, $description)
{
    return Subject::create([
        'name' => $subjectName,
        'subject_code' => $subjectCode,
        'classes_id' => $classId,
        'description' => $description,
    ]);
}

public function createExam($name, $slug, $classId, $semesterId, $subjectId, $description, $startDate, $endDate)
{
    return Exam::create([
        'name' => $name,
        'slug' => $slug,
        'classes_id' => $classId,
        'semester_id' => $semesterId,
        'subject_id' => $subjectId,
        'description' => $description,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);
}

public function createTeacher($userId, $dateOfBirth, $gender, $registrationNo, $dateOfEmployment)
{
    return Teacher::create([
        'user_id' => $userId,
        'date_of_birth' => $dateOfBirth,
        'gender' => $gender,
        'registration_no' => $registrationNo,
        'date_of_employment' => $dateOfEmployment,
    ]);
}

public function createStream($name, $classId)
{
    return Stream::create([
        'name' => $name,
        'classes_id' => $classId,
    ]);
}

public function createExamResult($studentId, $examId, $subjectId, $semesterId, $marksObtained)
{
    return ExamResult::create([
        'student_id' => $studentId,
        'exam_id' => $examId,
        'subject_id' => $subjectId,
        'semester_id' => $semesterId,
        'marks_obtained' => $marksObtained,
    ]);
}


public function createStudent($userId, $admissionNo, $dateOfBirth, $classId, $streamId, $gender, $semesterId, $dateOfAdmission, $isGraduate, $academicYearId)
{
    return Student::create([
        'user_id' => $userId,
        'admission_no' => $admissionNo,
        'date_of_birth' => $dateOfBirth,
        'classes_id' => $classId,
        'stream_id' => $streamId,
        'gender' => $gender,
        'semester_id' => $semesterId,
        'date_of_admission' => $dateOfAdmission,
        'is_graduate' => $isGraduate,
        'academic_year_id' => $academicYearId,
    ]);
}

public function createUser($name, $email, $password)
{
    return User::create([
        'name' => $name,
        'email' => $email,
        'password' => bcrypt($password),
    ]);
}

public function createSemester($name, $classId, $description, $startDate, $endDate)
{
    return Semester::create([
        'name' => $name,
        'classes_id' => $classId,
        'description' => $description,
        'start_date' => $startDate,
        'end_date' => $endDate,
    ]);
}
}
