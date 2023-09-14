<?php

namespace App\Livewire\AcademicPerformance;

use App\Models\ExamResult as ModelsExamResult;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ExamResult extends Component
{
public $students ;
public $data ;
public $confirmingItemView;
public function mount(){
     // Get the logged-in user (teacher)
     $loggedInUser = Auth::user();

     if ($loggedInUser->hasRole('teacher')) {
         // Find the teacher's assigned classes
         $teacher = Teacher::where('user_id', $loggedInUser->id)->first();

         
        if ($teacher) {
            // Get all students in the teacher's classes
            $students = Student::whereIn('classes_id', $teacher->classes->pluck('id')->toArray())->get();

            return $this->students= $students;
        }
    }

    // Return an empty collection if the user is not a teacher or is not assigned to any class
    return collect();
}

public function showStudentResult($studentId)
{
    // Find the student by ID
    $student = Student::find($studentId);

    if (!$student) {
        return "Student not found";
    }

    // Get the student's name and other information
    $studentInfo = [
        'Name' => $student->user->name,
        'Admission No' => $student->admission_no,

    ];

    // Get the exam results for the student
    $examResults = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 1)->get();
        // Calculate the cumulative average
        $totalMarks = 0;
        $totalSubjects = 0;

        foreach ($examResults as $result) {
            $totalMarks += $result->marks_obtained;
            $totalSubjects++;
        }

        $cumulativeAverage = $totalSubjects > 0 ? ($totalMarks / $totalSubjects) : 0;

        // Calculate the rank of the student in the class
        $rank = Student::where('classes_id', $student->classes_id)
            ->where('semester_id', $student->semester_id)
            ->where('stream_id', $student->stream_id)
            ->where('academic_year_id', $student->academic_year_id)
            ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id) >= ?", [$totalMarks])
            ->count() + 1;

        // Prepare the data for display
        $data = [
            'Student Information' => $studentInfo,
            'Exam Results' => $examResults,
            'Cumulative Average' => $cumulativeAverage,
            'Class Rank' => $rank,
        ];
        $this->confirmingItemView=true;
 
    // You can return the data to a view for better formatting
    return $this->data=$data;
}

    public function render()
    {
        return view('livewire.academic-performance.exam-result')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }
}
