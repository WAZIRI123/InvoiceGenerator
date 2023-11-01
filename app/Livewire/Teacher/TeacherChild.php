<?php

namespace App\Livewire\Teacher;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Teacher;
use App\Models\Classes;

class TeacherChild extends Component
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
    /**
     * @var array
     */
    public $checkedClasses = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.user_id' => 'required',
        'item.date_of_birth' => '',
        'item.registration_no' => '',
        'item.date_of_employment' => '',
        'item.gender_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.user_id' => 'User Id',
        'item.date_of_birth' => 'Date Of Birth',
        'item.registration_no' => 'Registration No',
        'item.date_of_employment' => 'Date Of Employment',
        'item.gender_id' => 'Gender Id',
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

    public $teacher ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.teacher.teacher-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Teacher $teacher): void
    {
        $this->confirmingItemDeletion = true;
        $this->teacher = $teacher;
    }

    public function deleteItem(): void
    {
        $this->teacher->delete();
        $this->confirmingItemDeletion = false;
        $this->teacher = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('teacher');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->classes = Classes::orderBy('name')->get();
        $this->checkedClasses = [];
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Teacher::create([
            'user_id' => $this->item['user_id'] ?? '', 
            'date_of_birth' => $this->item['date_of_birth'] ?? '', 
            'registration_no' => $this->item['registration_no'] ?? '', 
            'date_of_employment' => $this->item['date_of_employment'] ?? '', 
            'gender_id' => $this->item['gender_id'] ?? '', 
        ]);
        $item->classes()->attach($this->checkedClasses);

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('teacher');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Teacher $teacher): void
    {
        $this->resetErrorBag();
        $this->teacher = $teacher;
        $this->item = $teacher->toArray();
        $this->confirmingItemEdit = true;

        $this->checkedClasses = $teacher->classes->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->classes = Classes::orderBy('name')->get();

    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->teacher->update([
            'user_id' => $this->item['user_id'] ?? '', 
            'date_of_birth' => $this->item['date_of_birth'] ?? '', 
            'registration_no' => $this->item['registration_no'] ?? '', 
            'date_of_employment' => $this->item['date_of_employment'] ?? '', 
            'gender_id' => $this->item['gender_id'] ?? '', 
         ]);

        $this->item->classes()->sync($this->checkedClasses);
        $this->checkedClasses = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('teacher');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
