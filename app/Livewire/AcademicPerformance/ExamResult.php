<?php

    namespace App\Livewire\AcademicPerformance;

    use App\Models\ExamResult as ModelsExamResult;

    use App\Models\Semester;

    use App\Models\GradeSystem;

    use App\Models\Student;

    use App\Models\Teacher;

    use Illuminate\Support\Facades\Auth;

    use Livewire\Component;

    class ExamResult extends Component
    {
      public $students ;

      public $data ;

      public $confirmingItemView;

      public function mount(){

         $loggedInUser = Auth::user();

        if ($loggedInUser->hasRole('teacher')) {

         $teacher = Teacher::where('user_id', $loggedInUser->id)->first();
         
        if ($teacher) {

         $students = Student::whereIn('classes_id', $teacher->classes->pluck('id')->toArray())->get();

         return $this->students= $students;

        }

       }elseif ($loggedInUser->hasRole('admin')) {

             $students = Student::all();

             return $this->students= $students;
       }

            return collect();
       }

        public function showStudentResult($studentId)
        {
  
        $student = Student::find($studentId);

        if (!$student) {

            return "Student not found";

        }

        $studentInfo = [

        'Name' => $student->user?->name,

        'Admission No' => $student->admission_no,

        ];

        $semester1Subjects=Semester::find(1)->subjects?->pluck('id')->toArray();

        $semester2Subjects=Semester::find(2)->subjects?->pluck('id')->toArray();


        $examResultsSemester1 = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 1)->get();

        $examResultsSemester2 = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 2)->get();

        if(array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray())){

        return ;

        }
        
        $subjectGradesSemester1 = $this->calculateSubjectGrades($examResultsSemester1);

        $subjectGradesSemester2 = $this->calculateSubjectGrades($examResultsSemester2);

        $totalMarksSemester1 = 0;

        $totalSubjectsSemester1 = 0;

        foreach ($examResultsSemester1 as $result) {

        $totalMarksSemester1 += $result->marks_obtained;
        
        $totalSubjectsSemester1++;

        }

        $cumulativeAverageSemester1 = $totalSubjectsSemester1 > 0 ? ($totalMarksSemester1 / $totalSubjectsSemester1) : 0;

        $cumulativePercentageSemester1=$totalSubjectsSemester1 ? $totalMarksSemester1/(100*$totalSubjectsSemester1)*100:0;

        $examResultsSemester2 = [];

        $cumulativeAverageSemester2 = 0;

        $examResultsSemester2 = ModelsExamResult::where('student_id', $studentId)->where('semester_id', 2)->get();

        if ($examResultsSemester2->count() > 0 && count($semester2Subjects) > 0 && !array_diff($semester2Subjects,$examResultsSemester2->pluck('subject_id')->toArray())) {

        $totalMarksSemester2 = 0;
        $totalSubjectsSemester2 = 0;

        foreach ($examResultsSemester2 as $result) {
        $totalMarksSemester2 += $result->marks_obtained;
        $totalSubjectsSemester2++;
        }
        $cumulativeAverageSemester2 = $totalSubjectsSemester2 > 0 ? ($totalMarksSemester2 / $totalSubjectsSemester2) : 0;


        $cumulativePercentageSemester2=$totalSubjectsSemester2 ? $totalMarksSemester2/(100*$totalSubjectsSemester2)*100:0;
        } 
        else 
        {

        $totalSubjectsSemester2 =0;

        $totalMarksSemester2 = 0;

        $examResultsSemester2=[];

        $cumulativePercentageSemester2=0;
        }

           $rankSemester1 =$totalSubjectsSemester1? Student::where('classes_id', $student->classes_id)

            ->where('stream_id', $student->stream_id)

            ->where('academic_year_id', $student->academic_year_id)

            ->where('semester_id', 1)

            ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 1) > ?", [$totalMarksSemester1])

            ->count() + 1:'';
            
            $rankSemester2 =$totalSubjectsSemester2? Student::where('classes_id', $student->classes_id)

            ->where('stream_id', $student->stream_id)

            ->where('academic_year_id', $student->academic_year_id)

            ->where('semester_id', 2)

            ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 2) > ?", [$totalMarksSemester2])

            ->count() + 1:0;

            $overallRank = Student::where('classes_id', $student->classes_id)

            ->where('stream_id', $student->stream_id)

            ->where('academic_year_id', $student->academic_year_id)

            ->whereRaw("(SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 1) + (SELECT SUM(marks_obtained) FROM exam_results WHERE student_id = students.id AND semester_id = 2) > ?", [$totalMarksSemester1 + $totalMarksSemester2])

            ->count() + 1;

            $gradeSemester1 = $this->calculateGrade($cumulativePercentageSemester1);

            $statusSemester1=$this->checkStudentAcademicStatus($gradeSemester1);

            $gradeSemester2 = $this->calculateGrade( $cumulativePercentageSemester2);

            $statusSemester2=$this->checkStudentAcademicStatus($gradeSemester2);

            $overallCumulativeAverage = ($cumulativeAverageSemester1 + $cumulativeAverageSemester2) / 2;

            $overallGrade = $this->calculateGrade($overallCumulativeAverage);

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

  public function getGrade($mark,$exam_id)
    {
        if($mark < 1) { return NULL; }

        $grades = GradeSystem::where(['exam_id' => $exam_id])->get();

        if($grades->count() > 0){
            
            $gr = $grades->where('mark_from', '<=', $mark)->where('mark_to', '>=', $mark);

            return $gr->count() > 0 ? $gr->first() : 
            $this->getGrade2($mark);

        }
        return $this->getGrade2($mark);
    }

    public function getGrade2($mark)
    {
        $grades = GradeSystem::whereNull('exam_id')->get();


        if($grades->count() > 0)
        {
            
            return $grades->where('mark_from', '<=', $mark)->where('mark_to', '>=', $mark)->first()?->remark;

        }else{

        return NULL;
       }

    }
        private function calculateSubjectGrades($examResults)
        {

        $subjectGrades = [];

        foreach ($examResults as $result) {

        $marksObtained = $result->marks_obtained;

        $subjectName = $result->subject->name; 

        $grade = $this->calculateGrade($marksObtained);

        $subjectGrades[$subjectName] = [

            'Marks Obtained' => $marksObtained,

            'Grade' => $grade,

           ];

        }

        return $subjectGrades;

       }


      private function calculateGrade($marksObtained)
      {
   
     if($marksObtained>0)
     {
      
      return $this->getGrade2($marksObtained);

    }else{

        return 'N/A'; 

    }


    }

    public function render()
    {
        return view('livewire.academic-performance.exam-result')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }

}
