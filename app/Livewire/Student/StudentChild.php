<?php

namespace App\Livewire\Student;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Student;
use App\Models\User;
use App\Models\Classes;
use App\Models\Stream;
use App\Models\Gender;
use App\Models\Semester;
use App\Models\AcademicYear;

class StudentChild extends Component
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
    public $users = [];

    /**
     * @var array
     */
    public $classes = [];

    /**
     * @var array
     */
    public $streams = [];

    /**
     * @var array
     */
    public $genders = [];

    /**
     * @var array
     */
    public $semesters = [];

    /**
     * @var array
     */
    public $academicYears = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.admission_no' => '',
        'item.date_of_birth' => '',
        'item.date_of_admission' => '',
        'item.is_graduate' => '',
        'item.user_id' => 'required',
        'item.classes_id' => 'required',
        'item.stream_id' => 'required',
        'item.gender_id' => 'required',
        'item.semester_id' => 'required',
        'item.academic_year_id' => 'required',
        'item.user_id' => 'required',
        'item.classes_id' => 'required',
        'item.stream_id' => 'required',
        'item.gender_id' => 'required',
        'item.semester_id' => 'required',
        'item.academic_year_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.admission_no' => 'Admission No',
        'item.date_of_birth' => 'Date Of Birth',
        'item.date_of_admission' => 'Date Of Admission',
        'item.is_graduate' => 'Is Graduate',
        'item.user_id' => 'User Id',
        'item.classes_id' => 'Classes Id',
        'item.stream_id' => 'Stream Id',
        'item.gender_id' => 'Gender Id',
        'item.semester_id' => 'Semester Id',
        'item.academic_year_id' => 'Academic Year Id',
        'item.user_id' => 'User',
        'item.classes_id' => 'Class',
        'item.stream_id' => 'Stream',
        'item.gender_id' => 'Gender',
        'item.semester_id' => 'Semester',
        'item.academic_year_id' => 'AcademicYear',
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

    public $student ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.student.student-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Student $student): void
    {
        $this->confirmingItemDeletion = true;
        $this->student = $student;
    }

    public function deleteItem(): void
    {
        $this->student->delete();
        $this->confirmingItemDeletion = false;
        $this->student = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('student');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->users = User::orderBy('name')->get();

        $this->classes = Classes::orderBy('name')->get();

        $this->streams = Stream::orderBy('name')->get();

        $this->genders = Gender::orderBy('name')->get();

        $this->semesters = Semester::orderBy('name')->get();

        $this->academicYears = AcademicYear::orderBy('academic_year')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Student::create([
            'admission_no' => $this->item['admission_no'] ?? '', 
            'date_of_birth' => $this->item['date_of_birth'] ?? '', 
            'date_of_admission' => $this->item['date_of_admission'] ?? '', 
            'is_graduate' => $this->item['is_graduate'] ?? '', 
            'user_id' => $this->item['user_id'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
            'stream_id' => $this->item['stream_id'] ?? '', 
            'gender_id' => $this->item['gender_id'] ?? '', 
            'semester_id' => $this->item['semester_id'] ?? '', 
            'academic_year_id' => $this->item['academic_year_id'] ?? '', 
            'user_id' => $this->item['user_id'] ?? 0, 
            'classes_id' => $this->item['classes_id'] ?? 0, 
            'stream_id' => $this->item['stream_id'] ?? 0, 
            'gender_id' => $this->item['gender_id'] ?? 0, 
            'semester_id' => $this->item['semester_id'] ?? 0, 
            'academic_year_id' => $this->item['academic_year_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('student');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Student $student): void
    {
        $this->resetErrorBag();
        $this->student = $student;
        $this->item = $student->toArray();
        $this->confirmingItemEdit = true;

        $this->users = User::orderBy('name')->get();

        $this->classes = Classes::orderBy('name')->get();

        $this->streams = Stream::orderBy('name')->get();

        $this->genders = Gender::orderBy('name')->get();

        $this->semesters = Semester::orderBy('name')->get();

        $this->academicYears = AcademicYear::orderBy('academic_year')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->student->update([
            'admission_no' => $this->item['admission_no'] ?? '', 
            'date_of_birth' => $this->item['date_of_birth'] ?? '', 
            'date_of_admission' => $this->item['date_of_admission'] ?? '', 
            'is_graduate' => $this->item['is_graduate'] ?? '', 
            'user_id' => $this->item['user_id'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
            'stream_id' => $this->item['stream_id'] ?? '', 
            'gender_id' => $this->item['gender_id'] ?? '', 
            'semester_id' => $this->item['semester_id'] ?? '', 
            'academic_year_id' => $this->item['academic_year_id'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('student');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
