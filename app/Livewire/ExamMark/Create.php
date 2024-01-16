<?php

namespace App\Livewire\ExamMark;

use App\Http\Helpers\AppHelper;
use App\Models\AcademicYear;
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
use App\Traits\marksProcessing;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\FuncCall;

class Create extends Component
{
    use marksProcessing;

    public $item=[];

    public $totalMarks=[];

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
    public $examRule;

    public $subjects = [];

    public $academicYears = [];

    public $classes=[];

    public $class_id;

    public $sections=[];

    public $studentIds=[];

    public $marks_type=[];

    public $absent=[];

    /**
     * @var array
     */
    protected $rules = [
        'item.academic_year_id' => 'nullable|integer',
        'class_id' => 'required|integer',
        'item.section_id' => 'required|integer',
        'item.subject_id' => 'required|integer',
        'item.exam_id' => 'required|integer',
        'studentIds' => 'required|array',
        'marks_type' => 'required|array',
        'absent' => 'nullable|array',
    ];
    

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.academic_year_id' => 'Academic year ID',
        'class_id' => 'Class ID',
        'item.section_id' => 'Section ID',
        'item.subject_id' => 'Subject ID',
        'item.exam_id' => 'Exam ID',
        'registrationIds' => 'Registration IDs',
        'marks_type' => 'Marks type',
        'absent' => 'Absent',
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
 

    #[On('showDeleteForm')]
    public function showDeleteForm(ExamResult $examresult): void
    {
        $this->confirmingItemDeletion = true;
        $this->examresult = $examresult;
    }

 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;

        $this->resetErrorBag();

        $this->reset(['item','studentIds','students']);
        

        $this->semesters = Semester::orderBy('name')->get();

        $this->exams = Exam::orderBy('name')->get();

        $this->academicYears = AcademicYear::orderBy('title')->get();


        $this->classes = Classes::orderBy('name')->get();


        $this->subjects = Subject::orderBy('name')->get();
        
    }
     


    public function updatedClassId(){

        $this->sections = Section::where('classes_id',$this->class_id)->orderBy('name')->get();

    }

        public function getstudents(){
            $this->validate([
                'item.academic_year_id' => 'required|integer',
                'class_id' => 'required|integer',
                'item.section_id' => 'required|integer',
                'item.subject_id' => 'required|integer',
                'item.exam_id' => 'required|integer',
            ]);
            $this->examRule = ExamRule::where('exam_id',$this->item['exam_id'])
            ->where('subject_id',$this->item['subject_id'])
            ->first();

            

        if(!$this->examRule) {
     
        dd('need aleert');

        }
                $students=$this->students=Student::where(['classes_id'=>$this->class_id,'stream_id'=>$this->item['section_id'],'academic_year_id'=>$this->item['academic_year_id']])->where('is_graduate',false)->get();

                $this->studentIds = $students->toArray();

    }

    public function createItem(): void
    {
        $this->validate();

                $examInfo = Exam::where('status', AppHelper::ACTIVE)
                ->where('id', $this->item['exam_id'])
                ->first();
            if(!$examInfo) {
                $this->dispatch('show', 'No Exam set')->to('livewire-toast');

                return;
            }

            $studentIds= collect($this->studentIds);
    
        $entryExists = Mark::where('academic_year_id',$this->item['academic_year_id'])
                ->where('classes_id', $this->class_id)
                ->where('section_id', $this->item['section_id'])
                ->where('subject_id', $this->item['subject_id'])
                ->where('exam_id', $this->item['exam_id'])
                ->whereIn('student_id', $studentIds->pluck('id')->toArray())
                ->count();

    
            if($entryExists){

                dd('need allert');

                return;

            }

            $examRule = collect($this->examRule);
  

        $gradingRules=Grade::all();
            //exam distributed marks rules
            $distributeMarksRules = [];

            foreach (json_decode($examRule['marks_distribution']) as $rule){
                $distributeMarksRules[$rule->type] = [
                    'total_marks' => $rule->total_marks,
                    'pass_marks' => $rule->pass_marks
                ];
            }
            
         $distributedMarks = $this->marks_type;
     
       
        
        foreach ($this->studentIds as $key=>$student){
                $marks = $distributedMarks[$student['id']];
        
                [$isInvalid, $message, $totalMarks, $grade, $point, $typeWiseMarks] = $this->processMarksAndCalculateResult(
                    $examRule,
                    $gradingRules,
                    $distributeMarksRules,
                    $marks);
    
                if($isInvalid){
                    break;
                }
        
          if ( !isset($this->absent[$student['id']]) | $this->absent[$student['id']]==false) {

       
            foreach ($typeWiseMarks as  &$value) {

             $value = 0;

             $totalMarks = 0;

            }

          }

                $data = [
                    'academic_year_id' => $this->item['academic_year_id'],
                    'classes_id' => $this->class_id,
                    'section_id' => $this->item['section_id'],
                    'student_id' => $student['id'],
                    'exam_id' => $this->item['exam_id'],
                    'subject_id' => $this->item['subject_id'],
                    'marks' => json_encode($typeWiseMarks),
                    'total_marks' => $totalMarks,
                    'grade' => $grade,
                    'point' => $point,
                    'present' => isset($this->absent[$student['id']]) ? '0' : '1',
                   
                ];
    
                $marksData[] = $data;
            }
    
    
            if($isInvalid){
               dd('to make alert');
            }

            DB::beginTransaction();
            try {
               foreach ($marksData as $marksData) {
                Mark::create($marksData);
                DB::commit();
               }
            }
            catch(\Exception $e){
                DB::rollback();
                $message = str_replace(array("\r", "\n","'","`"), ' ', $e->getMessage());
                dd($e->getMessage());

            }

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('exam-mark.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
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
