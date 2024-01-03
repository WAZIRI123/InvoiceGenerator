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

class Create extends Component
{

    public $item=[];

    public $marks_distribution=[];

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
    protected $rules = [
        'marks_distribution' => 'required',
        'item.passing_rule' => 'required',
        'item.total_exam_marks' => 'required|numeric', 
        'item.over_all_pass' => 'required|numeric', 
        'item.classes_id' => 'required|integer', 
        'exam' => 'required',
        'item.combine_subject_id' => 'nullable', 
        'item.subject_id' => 'required|integer', 
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'marks_distribution' => 'Marks Distribution',
        'item.passing_rule' => 'Passing Rule',
        'item.total_exam_marks' => 'Total Exam Marks',
        'item.over_all_pass' => 'Over All Pass',
        'item.classes_id' => 'Class',
        'exam' => 'Exam',
        
        'item.subject_id' => 'Subject',

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



    public Function updatedExam($exam_id=null){
        if ($exam_id!=null) {
            $markDistTypesKeys = json_decode(Exam::find($exam_id)?->marks_distribution_types);
        }else {
            $markDistTypesKeys = json_decode(Exam::find($this->exam)?->marks_distribution_types);
        }


        $markDistTypesValues = AppHelper::MARKS_DISTRIBUTION_TYPES;
        
        if ( $markDistTypesKeys!=null) {

        $this->markDistTypes = collect($markDistTypesValues)->filter(function ($value, $key) use ($markDistTypesKeys) {
            return in_array($key, $markDistTypesKeys); 
        })->all();

        }
        foreach ($this->markDistTypes as $key => $value) {
            $this->marks_distribution['type'][$key]=$value;
        }
      

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

    }

    public function createItem(): void
    {
      
      $validatedData = $this->validate();
    
        $marksDistribution = [];

        foreach ($this->marks_distribution['type'] as $key => $value){
            $marksDistribution[] = [
                'type' => $value,
                'total_marks' => $this->marks_distribution['total_marks'][$key],
                'pass_marks' => $this->marks_distribution['pass_marks'][$key],
            ];
        }

        $item = ExamRule::create([
            'marks_distribution' => json_encode( $marksDistribution), 
            'passing_rule' => $this->item['passing_rule'], 
            'total_exam_marks' => $this->item['total_exam_marks'], 
            'over_all_pass' => $this->item['over_all_pass'], 
            'classes_id' => $this->item['classes_id'], 
            'exam_id' => $this->exam, 
            'combine_subject_id' => $this->item['combine_subject_id'] !=''? $this->item['combine_subject_id']:null, 
            'subject_id' => $this->item['subject_id'], 
            
        ]);
        
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('exam-rule.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(ExamRule $examrule): void
    {
        $this->reset(['item']);
       
        $this->resetErrorBag();
        $this->examrule = $examrule;
      
        $this->item = $examrule->toArray();
      
        $this->confirmingItemEdit = true;
        
        $this->exam=$examrule->toArray()['exam_id'];

         $this->updatedExam($this->examrule->exam_id);

     

        $this->marks_distribution=json_decode($examrule->marks_distribution,true);

    
        foreach ($this->marks_distribution as $key => $value) {
            $key++;
            $this->marks_distribution['type'][$key]=$value['type'];
            $this->marks_distribution['total_marks'][$key]=$value['total_marks'];
            $this->marks_distribution['pass_marks'][$key]=$value['pass_marks'];
          
        }

        $this->classes = Classes::orderBy('name')->get();

        $this->exams = Exam::orderBy('name')->get();
        
        $this->combineSubjects = Subject::orderBy('name')->get();

        $this->subjects = Subject::orderBy('name')->get();



    }

    public function editItem(): void
    {
        $this->validate();
        $marksDistribution = [];
        foreach ($this->marks_distribution['type'] as $key => $value){
            $marksDistribution[] = [
                'type' => $value,
                'total_marks' => $this->marks_distribution['total_marks'][$key],
                'pass_marks' => $this->marks_distribution['pass_marks'][$key],
            ];
        }

        $item = $this->examrule->update([
            'marks_distribution' => json_encode( $marksDistribution), 
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
