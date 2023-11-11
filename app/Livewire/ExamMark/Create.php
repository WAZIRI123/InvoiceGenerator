<?php

namespace App\Livewire\ExamMark;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\ExamResult;
use App\Models\Student;
use App\Models\Semester;
use App\Models\Exam;
use App\Models\Subject;

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

    /**
     * @var array
     */
    protected $rules = [
        'item.marks_obtained' => 'nullable|numeric|min:0|max:100', // Adjust the numeric and range constraints accordingly
        'item.student_id' => 'required|integer',
        'item.semester_id' => 'required|integer',
        'item.exam_id' => 'required|integer',
        'item.subject_id' => 'required|integer',
    ];
    

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.marks_obtained' => 'Marks Obtained',
        'item.student_id' => 'Student',
        'item.semester_id' => 'Semester',
        'item.exam_id' => 'Exam',
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

    public $examresult ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.exam-mark.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(ExamResult $examresult): void
    {
        $this->confirmingItemDeletion = true;
        $this->examresult = $examresult;
    }

    public function deleteItem(): void
    {
        $this->examresult->delete();
        $this->confirmingItemDeletion = false;
        $this->examresult = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('exam-mark.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
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

    public function createItem(): void
    {
        $this->validate();
        $item = ExamResult::create([
            'marks_obtained' => $this->item['marks_obtained'], 
            'student_id' => $this->item['student_id'], 
            'semester_id' => $this->item['semester_id'], 
            'exam_id' => $this->item['exam_id'], 
            'subject_id' => $this->item['subject_id'], 
        ]);
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
