<?php

namespace App\Livewire\ExamRule;

use App\Http\Helpers\AppHelper;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\ExamRule;
use App\Models\Classes;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Grade;
use Symfony\Component\CssSelector\Node\FunctionNode;

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
    public $classes = [];

    public $markDistTypes=[];

    public $exam = [];

    public $MarksDistFields =[1];

    /**
     * @var array
     */
    public $exams = [];

    /**
     * @var array
     */
    public $combineSubjects = [];

    /**
     * @var array
     */
    public $subjects = [];

    /**
     * @var array
     */
    public $grades = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.marks_distribution' => '',
        'item.passing_rule' => '',
        'item.total_exam_marks' => '',
        'item.over_all_pass' => '',
        'item.classes_id' => 'required',
        'exam' => 'required',
        'item.combine_subject_id' => 'required',
        'item.subject_id' => 'required',
        'item.grade_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.marks_distribution' => 'Marks Distribution',
        'item.passing_rule' => 'Passing Rule',
        'item.total_exam_marks' => 'Total Exam Marks',
        'item.over_all_pass' => 'Over All Pass',
        'item.classes_id' => 'Class',
        'exam' => 'Exam',
        'item.combine_subject_id' => 'CombineSubject',
        'item.subject_id' => 'Subject',
        'item.grade_id' => 'Grade',
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

    public $examrule ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

 
    public function render(): View
    {
        return view('livewire.exam-rule.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(ExamRule $examrule): void
    {
        $this->confirmingItemDeletion = true;
        $this->examrule = $examrule;
    }

    public  function addMarksDistField(){
        $this->MarksDistFields[]= '';
    }


    public function removeMarksDistField($index)
    {
 
        unset($this->MarksDistFields[$index]);

        $this->MarksDistFields = array_values($this->MarksDistFields);
    }

    public Function updatedExam(){
        $markDistTypesKeys = json_decode(Exam::find($this->exam)->marks_distribution_types);

        $markDistTypesValues = AppHelper::MARKS_DISTRIBUTION_TYPES;

        $this->markDistTypes = collect($markDistTypesValues)->filter(function ($value, $key) use ($markDistTypesKeys) {
            return in_array($key, $markDistTypesKeys); 
        })->all();


    }
    public function deleteItem(): void
    {
        $this->examrule->delete();
        $this->confirmingItemDeletion = false;
        $this->examrule = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('exam-rule.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;

        $this->resetErrorBag();
        
        $this->reset(['item']);

        $this->classes = Classes::orderBy('name')->get();

        $this->exams = Exam::orderBy('name')->get();

        $this->combineSubjects = Subject::orderBy('name')->get();

        $this->subjects = Subject::orderBy('name')->get();

        $this->grades = Grade::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();

        $item = ExamRule::create([
            'marks_distribution' => $this->item['marks_distribution'], 
            'passing_rule' => $this->item['passing_rule'], 
            'total_exam_marks' => $this->item['total_exam_marks'], 
            'over_all_pass' => $this->item['over_all_pass'], 
            'classes_id' => $this->item['classes_id'], 
            'exam_id' => $this->item['exam_id'], 
            'combine_subject_id' => $this->item['combine_subject_id'], 
            'subject_id' => $this->item['subject_id'], 
            'grade_id' => $this->item['grade_id'], 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('exam-rule.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(ExamRule $examrule): void
    {
        $this->resetErrorBag();
        $this->examrule = $examrule;
        $this->item = $examrule->toArray();
        $this->confirmingItemEdit = true;

        $this->classes = Classes::orderBy('name')->get();

        $this->exams = Exam::orderBy('name')->get();

        $this->combineSubjects = Subject::orderBy('name')->get();

        $this->subjects = Subject::orderBy('name')->get();

        $this->grades = Grade::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->examrule->update([
            'marks_distribution' => $this->item['marks_distribution'], 
            'passing_rule' => $this->item['passing_rule'], 
            'total_exam_marks' => $this->item['total_exam_marks'], 
            'over_all_pass' => $this->item['over_all_pass'], 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('exam-rule.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
