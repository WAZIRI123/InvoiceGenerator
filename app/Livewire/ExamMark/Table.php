<?php

namespace App\Livewire\ExamMark;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Exam;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use \Illuminate\View\View;

use App\Models\ExamResult;
use App\Models\ExamRule;
use App\Models\Mark;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class Table extends Component
{
    use WithPagination;


       public $acYear = null;
       public $teacherId;
       public $class_id = null;
       public $classes=[];
       public $section_id = null;
       public $subject_id = null;
       public $exam_id = null;
       public $sections = [];
       public $academicYears = [];
       public $subjects = [];
       public $examRule = null;
       public $exams = [];
       public $editMode = 1;

        

    /**
     * @var array
     */
    protected $listeners = ['refresh' => '$refresh'];
    /**
     * @var string
     */
    public $sortBy = 'id';

    public $item=[];

    /**
     * @var bool
     */
    public $sortAsc = true;

    /**
     * @var int
     */
    public $per_page = 15;



    public function mount(): void
    {
        $this->exams = Exam::orderBy('name')->get();

        $this->academicYears = AcademicYear::orderBy('title')->get();

        $this->classes = Classes::orderBy('name')->get();

        $this->subjects = Subject::orderBy('name')->get();

    }

    public function updatedClassId(){

        $this->sections = Section::where('classes_id',$this->class_id)->orderBy('name')->get();

    }

    public function render(): View
    {
    
            $acYear =$this->academic_year_id ?? AcademicYear::first()->id;
            $class_id = $this->class_id ?? 0;
            $section_id = $this->section_id ?? 0;
            $subject_id = $this->subject_id ?? 0;
            $exam_id = $this->exam_id ?? 0;
            $this->teacherId = 1;

            $examRule=$this->examRule = ExamRule::where('exam_id',$exam_id)
            ->where('subject_id', $subject_id)
            ->first();

        // if(!$examRule) {

        //    dd('alert later');

        // }

                    //check is result is published?
                    // $isPublish = DB::table('result_publish')
                    // ->where('academic_year_id', $acYear)
                    // ->where('class_id', $class_id)
                    // ->where('exam_id', $exam_id)
                    // ->count();
    
                // if($isPublish){
                //     $editMode = 0;
                // }

               
                $marks = Mark::with(['student' => function($query){
                    $query->with(['user' => function($query){
                        $query->select('name','id');
                    }])->select('admission_no','id');
                }])
       
                ->where('academic_year_id', $acYear)
                ->where('classes_id', $class_id)
                ->where('section_id', $section_id)
                ->where('subject_id', $subject_id)
                ->where('exam_id', $exam_id)
                    ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
                    ->paginate($this->per_page);
        
        return view('livewire.exam-mark.table', [
            'results' => $marks
        ]);
    }

    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    public function query(): Builder
    {
        return ExamResult::query();
    }
}
