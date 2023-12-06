<?php

namespace App\Livewire\ExamMark;

use App\Http\Helpers\AppHelper;
use App\Models\Classes;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Exam;
use App\Models\Teacher;
use App\Models\ExamRule;
use App\Models\Grade;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Create extends Component
{

    public $item=[];

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];

    /**
     * @var array
     */
    public $students = [];

    /**
     * @var array
     */
    public $semesters = [];

    /**
     * @var array
     */
    public $exams = [];

    /**
     * @var array
     */
    public $subjects = [];

    public $classes=[];

    public $sections=[];


    /**
     * @var array
     */
    protected $rules = [
        'item.academic_year_id' => 'nullable|integer',
        'item.class_id' => 'required|integer',
        'item.section_id' => 'required|integer',
        'item.subject_id' => 'required|integer',
        'item.exam_id' => 'required|integer',
        'item.studentIds' => 'required|array',
        'item.marks_type' => 'required|array',
        'item.absent' => 'nullable|array',
    ];
    

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.academic_year_id' => 'Academic year ID',
        'item.class_id' => 'Class ID',
        'item.section_id' => 'Section ID',
        'item.subject_id' => 'Subject ID',
        'item.exam_id' => 'Exam ID',
        'item.studentIds' => 'Registration IDs',
        'item.marks_type' => 'Marks type',
        'item.absent' => 'Absent',
    ];
    

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    /**
     * @var string | int
     */
    public $primaryKey;

    /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    public $examresult ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;


        public function store()
        {
            $this->validate();
    
            $acYear = AppHelper::getAcademicYear();
    
            $class_id =$this->item['class_id'];
            $section_id =$this->item['section_id'];
            $subject_id =$this->item['subject_id'];
            $exam_id =$this->item['exam_id'];
    
            // some validation before entry the mark
            $examInfo = Exam::where('status', AppHelper::ACTIVE)
                ->where('id', $exam_id)
                ->first();
            if(!$examInfo) {

                $this->dispatch('show', 'Exam Not Found')->to('livewire-toast');

            }
    
            $examRule = ExamRule::where('exam_id',$exam_id)
                ->where('subject_id', $subject_id)
                ->first();
            if(!$examRule) {

                $this->dispatch('show', 'Exam rules not found for this subject and exam!')->to('livewire-toast');

            }
    
            $entryExists = Mark::where('academic_year_id', $acYear)
                ->where('class_id', $class_id)
                ->where('section_id', $section_id)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                ->whereIn('student_id', $this->item['studentIds'])
                ->count();
    
            if($entryExists){

                $this->dispatch('show', 'This subject marks already exists for this exam & students!')->to('livewire-toast');

            }
            //validation end
    
            //pull grading information
            $grade = Grade::where('id',  $examRule->grade_id)->first();
            if(!$grade){
                $this->dispatch('show', 'Grading information not found!')->to('livewire-toast');
    
            }
            $gradingRules = json_decode($grade->rules);
    
            //exam distributed marks rules
            $distributeMarksRules = [];
            foreach (json_decode($examRule->marks_distribution) as $rule){
                $distributeMarksRules[$rule->type] = [
                    'total_marks' => $rule->total_marks,
                    'pass_marks' => $rule->pass_marks
                ];
            }
    
            $distributedMarks = $this->item['marks_type'];
            $absent = $this->item['absent'];
            $timeStampNow = Carbon::now(env('APP_TIMEZONE', 'Asia/Dhaka'));
            $userId = auth()->user()->id;
    
            $marksData = [];
            $isInvalid = false;
            $message = '';
    
            foreach ($this->item['studentIds'] as $student){
                $marks = $distributedMarks[$student];
                [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks] = $this->processMarksAndCalculateResult(
                    $examRule,
                    $gradingRules,
                    $distributeMarksRules,
                    $marks);
    
                if($isInvalid){
                    break;
                }
    
                $data = [
                    'academic_year_id' => $acYear,
                    'class_id' => $class_id,
                    'section_id' => $section_id,
                    'registration_id' => $student,
                    'exam_id' => $exam_id,
                    'subject_id' => $subject_id,
                    'marks' => json_encode($typeWiseMarks),
                    'total_marks' => $totalMarks,
                    'grade' => $grade,
                    'point' => $point,
                    'present' => isset($absent[$student]) ? '0' : '1',
                    "created_at" => $timeStampNow,
                    "created_by" => $userId,
                ];
    
                $marksData[] = $data;
            }
    
    
            if($isInvalid){
                $this->dispatch('show', $message)->to('livewire-toast');
            }
    
    
            DB::beginTransaction();

            try {
    
                Mark::insert($marksData);
                DB::commit();
            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
                return redirect()->route('marks.create')->with("error",$message);
            }
    
            $sectionInfo = Section::where('id', $section_id)->first();
            $subjectInfo = Subject::with(['class' => function($query){
                $query->select('name','id');
            }])->where('id', $subject_id)->first();
            //now notify the admins about this record
            $msg = "Class {$subjectInfo->class->name}, section {$sectionInfo->name}, {$subjectInfo->name} subject marks added for {$examInfo->name} exam  by ".auth()->user()->name;
            $nothing = AppHelper::sendNotificationToAdmins('info', $msg);
            // Notification end
            $this->dispatch('show', 'Exam marks added successfully!')->to('livewire-toast');
      
        }
    
    
        /**
         * Process student entry marks and
         * calculate grade point
         *
         * @param $examRule collection
         * @param $gradingRules array
         * @param $distributeMarksRules array
         * @param $strudnetMarks array
         */
        private function processMarksAndCalculateResult($examRule, $gradingRules, $distributeMarksRules, $studentMarks) {
            $totalMarks = 0;
            $isFail = false;
            $isInvalid = false;
            $message = "";
            $typeWiseMarks = [];
    
            foreach ($distributeMarksRules as $type => $marksRule){
                if(!isset($studentMarks[$type])){
                    $typeWiseMarks[$type] = 0;
                    continue;
                }
    
                $marks = floatval($studentMarks[$type]);
                $typeWiseMarks[$type] = $marks;
                $totalMarks += $marks;
    
                // AppHelper::PASSING_RULES
                if(in_array($examRule->passing_rule, [2,3])){
                    if($marks > $marksRule['total_marks']){
                        $isInvalid = true;
                        $message = AppHelper::MARKS_DISTRIBUTION_TYPES[$type]. " marks is too high from exam rules marks distribution!";
                        break;
                    }
    
                    if($marks < $marksRule['pass_marks']){
                        $isFail = true;
                    }
                }
            }
    
            //fraction number make ceiling
            $totalMarks = ceil($totalMarks);
    
            // AppHelper::PASSING_RULES
            if(in_array($examRule->passing_rule, [1,3])){
                if($totalMarks < $examRule->over_all_pass){
                    $isFail = true;
                }
            }
    
            if($isFail){
                $grade = 'F';
                $point = 0.00;
    
                return [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks];
            }
    
            [$grade, $point] = $this->findGradePointFromMarks($gradingRules, $totalMarks);
    
            return [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks];
    
        }
    
        private function findGradePointFromMarks($gradingRules, $marks) {
            $grade = 'F';
            $point = 0.00;
            foreach ($gradingRules as $rule){
                if ($marks >= $rule->marks_from && $marks <= $rule->marks_upto){
                    $grade = AppHelper::GRADE_TYPES[$rule->grade];
                    $point = $rule->point;
                    break;
                }
            }
            return [$grade, $point];
        }
    
        private function findGradeFromPoint($point, $gradingRules) {
            $grade = 'F';
    
            foreach ($gradingRules as $rule){
                if($point >= floatval($rule->point)){
                    $grade = AppHelper::GRADE_TYPES[$rule->grade];
                    break;
                }
            }
    
            return $grade;
    
        }

    public function render(): View
    {
       $this->classes=Classes::all()->pluck('id', 'name');

       if(auth()->user()->hasRole('teacher')){

        $teacher = Teacher::where('user_id',auth()->user()->id); 
        
        $this->subjects = $teacher ? $teacher->pluck('id','name')  :'';

        }
        
        $this->sections = Section::where('class_id',$this->item['class_id'])->pluck('name', 'id');


        $this->exams = Exam::where('status', AppHelper::ACTIVE)
        ->where('classes_id', $this->item['class_id'])
        ->pluck('name', 'id');

        return view('livewire.exam-mark.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(ExamResult $examresult): void
    {
        $this->confirmingItemDeletion = true;
        $this->examresult = $examresult;
    }

    // public function deleteItem(): void
    // {
    //     DB::beginTransaction();
    //     try {
    //     $student=Student::find($this->examresult->student_id);
    //     $this->examresult->delete();
    //     $examResultsSemester1 = ExamResult::where('student_id', $student->id)->where('semester_id', 1)->get();

    //     $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

    //     if(!array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray())){

    //         $student = Student::find($this->item['student_id']);

    //         $student->resultStatus = 'complete';

    //         $student->save();
    
    //         }
    //     DB::commit();
    //     $this->confirmingItemDeletion = false;
    //     $this->examresult = '';
    //     $this->reset(['item']);
    //     $this->dispatch('refresh')->to('exam-mark.table');
    //     $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');
    //     }
    //     catch(\Exception $e){

    //     DB::rollback();

    //     }

    // }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->students = Student::orderBy('admission_no')->get();

        $this->semesters = Semester::orderBy('name')->get();

        $this->exams = Exam::orderBy('name')->get();

        $this->subjects = Subject::orderBy('name')->get();
    }

    // public function createItem(): void
    // {
    //     $this->validate();
    //     $item = ExamResult::create([
    //         'marks_obtained' => $this->item['marks_obtained'], 
    //         'student_id' => $this->item['student_id'], 
    //         'semester_id' => $this->item['semester_id'], 
    //         'exam_id' => $this->item['exam_id'], 
    //         'subject_id' => $this->item['subject_id'], 
    //     ]);
    //     $examResultsSemester1 = ExamResult::where('student_id', $this->item['student_id'])->where('semester_id', 1)->get();
    //     $student=Student::find($this->item['student_id']);
    //     $semester1Subjects=Semester::where('id',1)->where('classes_id',$student->classes_id)->first()->subjects?->pluck('id')->toArray();

    //     if(!array_diff($semester1Subjects,$examResultsSemester1->pluck('subject_id')->toArray())){

    //         $student = Student::find($this->item['student_id']);

    //         $student->resultStatus = 'complete';

    //         $student->save();
    
    //         }


    //     $this->confirmingItemCreation = false;
    //     $this->dispatch('refresh')->to('exam-mark.table');
    //     $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    // }
        
    #[On('showEditForm')]
    public function showEditForm(ExamResult $examresult): void
    {
        $this->resetErrorBag();

        $this->examresult = $examresult;

        $this->item = $examresult->toArray();

        $this->confirmingItemEdit = true;

        $this->students = Student::orderBy('admission_no')->get();

        $this->semesters = Semester::orderBy('name')->get();

        $this->exams = Exam::orderBy('name')->get();

        $this->subjects = Subject::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->examresult->update([
            'marks_obtained' => $this->item['marks_obtained'], 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('exam-mark.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
