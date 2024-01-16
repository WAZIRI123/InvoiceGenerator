<?php

namespace App\Livewire\Student;

use App\Models\AcademicYear;
use App\Models\Classes;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Stream;
use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\User;
use App\Traits\DateTime;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads,DateTime;

    public $item=[];
    public $class;
    public $profileImage;

    public $profile;

    public $is_graduate;

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
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.email' => 'Email',
        'item.password' => 'Password',
        'item.gender' => 'gender',
        'item.password_confirmation' => 'Password Confirmation',
        'item.admission_no' => 'Admission Number',
        'item.academic_year' => 'Academic Year',
        'item.date_of_admission' => 'Date of Admission',
        'item.date_of_birth' => 'Date of Birth',
        'is_graduate' => 'Is Graduate',
        'profile' => 'Profile Picture',
        'item.classes_id' => 'Class',
        'item.stream_id' => 'Stream',
        'item.semester_id' => 'Semester',
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

    public $user ;

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
    public $semesters = [];

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.student.create');
    }

    public function mount(){
   
        $this->user = User::where('id', auth()->user()->id)->first();
    }
    
    #[On('showDeleteForm')]
    public function showDeleteForm(User $user): void
    {
        $this->confirmingItemDeletion = true;
        $this->user = $user;
       $this->profileImage=$this->user->profile_picture;
    }

    public function deleteItem(): void
    {
        DB::transaction(function (){
        Student::where('user_id',$this->user->id)->delete();
        $this->user->delete();
        });
        if($this->profileImage !== null)
        {
          $currentImagePath = public_path("storage/{$this->profileImage}");
          shell_exec("rm {$currentImagePath}");
        }
        $this->confirmingItemDeletion = false;
        $this->user = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('student.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
        $this->classes = Classes::orderBy('name')->get();

        $this->semesters = Semester::orderBy('name')->get();
        
        $this->item['is_graduate'] = $this->item['is_graduate']?? false;
        
        $this->item['admission_no'] = IdGenerator::generate(['table' => 'students', 'field' => 'admission_no', 'length' => 5, 'prefix' => 'St']);
        $this->item['date_of_admission'] =
        Carbon::now()->format('Y-m-d');

        $this->item['academic_year']=AcademicYear::latest()->first()->id;
    }

    public function updatedClass(){
        $this->streams=Section::where('classes_id',$this->class)->get();
    }

    public function createItem(): void
    {
  
        $this->validate(['item.name' => ['required', 'string', 'max:255'],
        'item.email' => ['required', 'string', 'email', Rule::unique('users', 'email')->whereNull('deleted_at')],
        'item.password' => ['required', 'string', new Password(8), 'confirmed'],
        'item.password_confirmation' => ['required', 'string'],
        'item.admission_no' => 'required',
        'item.gender' => 'required',
        'item.academic_year' => 'required',
        'item.date_of_admission' => 'required|date',
        'item.date_of_birth' => 'required|date|date_format:Y-m-d|before:' .today()->subYears(7)->format('Y-m-d'),
        'is_graduate' => 'nullable',
        'profile' => ['nullable', 'image', 'max:1024'],
        'class' => 'required|integer|exists:classes,id',
        'item.stream_id' => 'required|integer|exists:sections,id',
        'item.semester_id' => 'required|integer|exists:semesters,id']);
        DB::transaction(function (){
        $uploadFilePath =$this->profile?'storage/'.$this->profile->store('profiles','public'):'';
      
       $user = User::create([
           'name' => $this->item['name'],
           'email' => $this->item['email'],
           'password' => $this->item['password'],
           'profile_picture' =>  $uploadFilePath,
       ]);
       $user->assignRole('student');

       $student=Student::create([
        'admission_no' => $this->item['admission_no'], 
        'date_of_birth' => $this->item['date_of_birth'], 
        'date_of_admission' => $this->item['date_of_admission'], 
        'is_graduate' => $this->is_graduate? true:false, 
        'gender' => $this->item['gender'], 
        'academic_year_id' => $this->item['academic_year'], 
        'user_id' =>$user->id, 
        'classes_id' => $this->class, 
        'stream_id' => $this->item['stream_id'], 
        'semester_id' => $this->item['semester_id'],
       ]);
    });
       $this->confirmingItemCreation = false;
       $this->dispatch('refresh')->to('student.table');
       $this->reset(['item','profile']);
       $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(User $user): void
    {
        $this->resetErrorBag();

        $student=Student::where('user_id' ,$user->id)->get()->first();
        $this->classes = Classes::orderBy('name')->get();

        $this->semesters = Semester::orderBy('name')->get();
        $this->streams=Section::where('classes_id',$student?->classes_id)->get();

        $this->user = $user;
         
        $this->profileImage=$this->user->profile_picture;
        $this->item =array_merge($user->toArray(),$student?->toArray()??[]);

        $this->item['is_graduate'] = $this->item['is_graduate']?? false;
        
        $this->item['academic_year']=$student?->academic_year_id;
        $this->item['admission_no']=$student?->admission_no;
        $this->item['date_of_admission']=$student?->date_of_admission;
    
        $this->is_graduate=$student?->is_graduate;
        $this->class=$student?->classes_id;

        $this->confirmingItemEdit = true;
    }

    public function removeImage()
    {
      $this->profile = null;
      //$this->profileImage = null;
    }

    public function editItem(): void
    {
      
        $this->validate(['item.name' => ['required', 'string', 'max:255'],
        'item.email' => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user->id)->whereNull('deleted_at')],
        'item.password' => ['required', 'string', new Password(8), 'confirmed'],
        'item.password_confirmation' => ['required', 'string'],
        'item.admission_no' => 'required',
        'item.gender' => 'required',
        'item.academic_year' => 'required',
        'item.date_of_admission' => 'required|date',
        'item.date_of_birth' => 'required|date|date_format:Y-m-d|before:' .today()->subYears(7)->format('Y-m-d'),
        'is_graduate' => 'nullable',
        'profile' => ['nullable', 'image', 'max:1024'],
        'class' => 'required|integer|exists:classes,id',
        'item.stream_id' => 'required|integer|exists:sections,id',
        'item.semester_id' => 'required|integer|exists:semesters,id']);
        DB::transaction(function (){
        if($this->profile !== null)
        {
          $currentImagePath = public_path("storage/{$this->profileImage}");
          shell_exec("rm {$currentImagePath}");
  
          $uploadFilePath = $this->profile->store("profiles", "public");
        }
        else if(!$this->profile && !$this->profileImage) {
          $uploadFilePath = "";
        } else {
          $uploadFilePath = $this->profileImage;
        }
  
     
        $user = $this->user->update([
            'name' => $this->item['name'], 
            'email' => $this->item['email'], 
            'password' => $this->item['password'], 
            'profile_picture' => $uploadFilePath, 
         ]);

         $student=Student::where('user_id' ,$this->user->id)->get()->first();

         $student= $student->update([
            'admission_no' => $this->item['admission_no'], 
            'date_of_birth' => $this->item['date_of_birth'], 
            'date_of_admission' => $this->item['date_of_admission'], 
            'is_graduate' => $this->is_graduate? true:false, 
            'gender' => $this->item['gender'], 
            'academic_year_id' => $this->item['academic_year'], 
            'user_id' =>$this->user->id, 
            'classes_id' => $this->class, 
            'stream_id' => $this->item['stream_id'], 
            'semester_id' => $this->item['semester_id'],
           ]);

        });

        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->reset(['item','profile']);
        $this->dispatch('refresh')->to('student.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
