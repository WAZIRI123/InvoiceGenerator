<?php

namespace App\Livewire\AcademicPerformance;

use App\Models\ExamResult as ModelsExamResult;
use App\Models\Semester;
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
    }elseif ($loggedInUser->hasRole('admin')) {
             // Get all students in the teacher's classes
             $students = Student::all();

       
             return $this->students= $students;
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
        'Name' => $student->user?->name,
        'Admission No' => $student->admission_no,
    ];

    $semester1Subjects=Semester::find(1)->subjects?->pluck('id')->toArray();

    $semester2Subjects=Semester::find(2)->subjects?->pluck('id')->toArray();

    // Get the exam results for both Semester 1 and Semester 2
  
    $examResultsSemester1 = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 1)->get();
    $examResultsSemester2 = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 2)->get();

    //student my done all exams for all subject in semester
    if(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray())){
return ;
    }


    // Define a grading scale (adjust as needed)
    $gradingScale = [
        ['grade' => 'A', 'min' => 90, 'max' => 100],
        ['grade' => 'B', 'min' => 70, 'max' => 89],
        ['grade' => 'C', 'min' => 40, 'max' => 60],
        ['grade' => 'D', 'min' => 30, 'max' => 39],
        ['grade' => 'F', 'min' => 0, 'max' => 29],
    ];
    // Calculate the grades for each subject in Semester 1 and Semester 2
    $subjectGradesSemester1 = $this->calculateSubjectGrades($examResultsSemester1, $gradingScale);
    $subjectGradesSemester2 = $this->calculateSubjectGrades($examResultsSemester2, $gradingScale);

    // Calculate the cumulative average for Semester 1
    $totalMarksSemester1 = 0;
    $totalSubjectsSemester1 = 0;

    foreach ($examResultsSemester1 as $result) {
        $totalMarksSemester1 += $result->marks_obtained;
        $totalSubjectsSemester1++;
    }

    $cumulativeAverageSemester1 = $totalSubjectsSemester1 > 0 ? ($totalMarksSemester1 / $totalSubjectsSemester1) : 0;
    $cumulativePercentageSemester1=$totalSubjectsSemester1 ? $totalMarksSemester1/(100*$totalSubjectsSemester1)*100:0;
   
    // Initialize Semester 2 variables with default values
    $examResultsSemester2 = [];
    $cumulativeAverageSemester2 = 0;

    // Check if Semester 2 results exist
    $examResultsSemester2 = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 2)->get();
    if ($examResultsSemester2->count() > 0 && count($semester2Subjects) > 0 && !array_diff($semester2Subjects,$examResultsSemester2->pluck('subject_id')->toArray())) {
        // Calculate the cumulative average for Semester 2
        $totalMarksSemester2 = 0;
        $totalSubjectsSemester2 = 0;

        foreach ($examResultsSemester2 as $result) {
            $totalMarksSemester2 += $result->marks_obtained;
            $totalSubjectsSemester2++;
        }
        $cumulativeAverageSemester2 = $totalSubjectsSemester2 > 0 ? ($totalMarksSemester2 / $totalSubjectsSemester2) : 0;

        $cumulativePercentageSemester2=$totalSubjectsSemester2 ? $totalMarksSemester2/(100*$totalSubjectsSemester2)*100:0;
    }else {

        $totalSubjectsSemester2 =0;
        $totalMarksSemester2 = 0;
        $examResultsSemester2=[];
        $cumulativePercentageSemester2=0;
    }

    // Calculate the rank of the student in the class based on the total marks obtained in Semester 1
    $rankSemester1 =$totalSubjectsSemester1? Student::where('classes_id', $student->classes_id)
        ->where('stream_id', $student->stream_id)
        ->where('academic_year_id', $student->academic_year_id)
        ->where('semester_id', 1)
        ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 1) > ?", [$totalMarksSemester1])
        ->count() + 1:'';
        

    // Calculate the rank of the student in the class based on the total marks obtained in Semester 2
    $rankSemester2 =$totalSubjectsSemester2? Student::where('classes_id', $student->classes_id)
        ->where('stream_id', $student->stream_id)
        ->where('academic_year_id', $student->academic_year_id)
        ->where('semester_id', 2)
        ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 2) > ?", [$totalMarksSemester2])
        ->count() + 1:0;

    // Calculate the overall rank based on the total marks obtained in both semesters
    $overallRank = Student::where('classes_id', $student->classes_id)
        ->where('stream_id', $student->stream_id)
        ->where('academic_year_id', $student->academic_year_id)
        ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 1) + (SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 2) > ?", [$totalMarksSemester1 + $totalMarksSemester2])
        ->count() + 1;


    // Calculate grades for Semester 1 and Semester 2
    $gradeSemester1 = $this->calculateGrade($cumulativePercentageSemester1, $gradingScale);
    $statusSemester1=$this->checkStudentAcademicStatus($gradeSemester1);
    $gradeSemester2 = $this->calculateGrade( $cumulativePercentageSemester2, $gradingScale);

    $statusSemester2=$this->checkStudentAcademicStatus($gradeSemester2);

    // Calculate the overall grade
    $overallCumulativeAverage = ($cumulativeAverageSemester1 + $cumulativeAverageSemester2) / 2;
    $overallGrade = $this->calculateGrade($overallCumulativeAverage, $gradingScale);

    // Prepare the data for display
    $data = [
        'Student Information' => $studentInfo,
        'Semester Results' => [
            'Semester 1' => $examResultsSemester1,
            'Semester 2' => $examResultsSemester2,
        ],
        'Cumulative Average Semester 1' => $cumulativeAverageSemester1,
        'Grade Semester1' => $gradeSemester1,
        'Subject Grades Semester 1' => $subjectGradesSemester1,
        'Cumulative Average Semester 2' => $cumulativeAverageSemester2,
        'Cumulative Percentage Semester 2' => $cumulativePercentageSemester2,
        'Cumulative Percentage Semester 1' => $cumulativePercentageSemester1,
        'status Semester2'=>$statusSemester2,
        'status Semester1'=>$statusSemester1,
        'Grade Semester2' => $gradeSemester2,
        'Subject Grades Semester 2' => $subjectGradesSemester2,
        'Semester Ranks' => [
            'Semester 1' => $rankSemester1,
            'Semester 2' => $rankSemester2,
        ],
        'Overall Cumulative Average' => $overallCumulativeAverage,
        'Overall Grade' => $overallGrade,
        'Overall Rank' => $overallRank,
        'Year Status'  =>$this->checkStudentAcademicStatus($overallGrade)
    ];

    // You can return the data to a view for better formatting
    $this->confirmingItemView = true;
    return $this->data = $data;
}
 
public function checkStudentAcademicStatus($gradeSemester)
{
if($gradeSemester=='F')
{

    return 'failed';
}

else
{
    return 'pass';
}

}

// Helper function to calculate grades for each subject
private function calculateSubjectGrades($examResults, $gradingScale)
{
    $subjectGrades = [];

    foreach ($examResults as $result) {
        $marksObtained = $result->marks_obtained;
        $subjectName = $result->subject->name; // Adjust this based on your model structure

        $grade = $this->calculateGrade($marksObtained, $gradingScale);

        $subjectGrades[$subjectName] = [
            'Marks Obtained' => $marksObtained,
            'Grade' => $grade,
        ];
    }

    return $subjectGrades;
}

// Helper function to calculate the grade based on a grading scale
private function calculateGrade($marksObtained, $gradingScale)
{
    foreach ($gradingScale as $gradeRange) {
        if ($marksObtained >= $gradeRange['min'] && $marksObtained <= $gradeRange['max']) {
            return $gradeRange['grade'];
        }
    }
    return 'N/A'; // Not applicable if the average doesn't fall within the grading scale
}

    public function render()
    {
        return view('livewire.academic-performance.exam-result')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }

    // brainstorm

    /* 
    -to find average of student does it need to include only number of subjects that student done exam for it or total of student in class =>  total of student in class in class to limit student from skip some exams
    
    -prevent student from do one exam multiple times?=done
    */
}
