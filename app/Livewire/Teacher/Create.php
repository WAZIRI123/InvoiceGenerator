<?php

namespace App\Livewire\Teacher;

use App\Models\Classes;
use App\Models\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\User;
use App\Traits\DateTime;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads;

class Create extends Component
{

    use WithFileUploads,DateTime;

    public $item=[];
    public $class=[];
    public $profileImage;
    public $classes=[];
    public $profile;


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
    protected function rules()
    {
       return  $rules = [
            'item.name' => ['required', 'string', 'max:255'],
            'item.email' => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user->id)->whereNull('deleted_at')],
            'item.password' => ['required', 'string', new Password(8), 'confirmed'],
            'item.password_confirmation' => ['required', 'string'],
            'item.registration_no' => 'required',
            'item.gender' => 'required',
            'item.date_of_employment' => 'required|date',
            'item.date_of_birth' => 'required|date|date_format:Y-m-d|before:' .today()->subYears(7)->format('Y-m-d'),
            'profile' => ['nullable', 'image', 'max:1024'],
        ];
    
        
    }

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.email' => 'Email',
        'item.password' => 'Password',
        'item.gender' => 'gender',
        'item.password_confirmation' => 'Password Confirmation',
        'item.registration_no' => 'Admission Number',
        'item.date_of_employment' => 'Date of Admission',
        'item.date_of_birth' => 'Date of Birth',
        'profile' => 'Profile Picture',
    
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
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.teacher.create');
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
        
        $teacher=Teacher::where('user_id',$this->user->id);
        
        $teacher->delete();
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
        $this->dispatch('refresh')->to('teacher.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
        $this->classes = Classes::orderBy('name')->get();
        $this->item['registration_no'] = IdGenerator::generate(['table' => 'teachers', 'field' => 'registration_no', 'length' => 5, 'prefix' => 'TC']);
        $this->item['date_of_employment'] =
        Carbon::now()->format('Y-m-d');

    }



    public function createItem(): void
    {
  
        $this->validate();
        DB::transaction(function (){
        $uploadFilePath =$this->profile?'storage/'.$this->profile->store('profiles','public'):'';
      
       $user = User::create([
           'name' => $this->item['name'],
           'email' => $this->item['email'],
           'password' => $this->item['password'],
           'profile_picture' =>  $uploadFilePath,
       ]);
       $user->assignRole('teacher');
  

       $teacher=Teacher::create([
        'registration_no' => $this->item['registration_no'], 
        'date_of_birth' => $this->item['date_of_birth'], 
        'date_of_employment' => $this->item['date_of_employment'], 
  
        'gender' => $this->item['gender'], 
 
        'user_id' =>$user->id, 
       ]);
       $teacher->classes()->sync($this->class);
    });
       $this->confirmingItemCreation = false;
       $this->dispatch('refresh')->to('teacher.table');
       $this->reset(['item','profile']);
       $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(User $user): void
    {
        $this->resetErrorBag();

        $teacher=Teacher::where('user_id' ,$user->id)->get()->first();
        $this->class=$teacher->classes()->get()->pluck('id')->toArray();
        $this->classes = Classes::orderBy('name')->get();
        $this->user = $user;
        $this->profileImage=$this->user->profile_picture;
        $this->item =array_merge($user->toArray(),$teacher?->toArray()??[]);
        $this->item['registration_no']=$teacher?->registration_no;
        $this->item['date_of_employment']=$teacher?->date_of_employment;
        $this->confirmingItemEdit = true;
    }

    public function removeImage()
    {
      $this->profile = null;
      //$this->profileImage = null;
    }

    public function editItem(): void
    {
      
        $this->validate();
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

         $teacher=Teacher::where('user_id' ,$this->user->id)->get()->first();


        $teacher->update([
            'registration_no' => $this->item['registration_no'], 
            'date_of_birth' => $this->item['date_of_birth'], 
            'date_of_employment' => $this->item['date_of_employment'], 
 
            'gender' => $this->item['gender'], 

            'user_id' =>$this->user->id, 
   
           ]);
           $teacher->classes()->attach($this->class);

        });

        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->reset(['item','profile']);
        $this->dispatch('refresh')->to('teacher.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
