<?php

namespace App\Livewire\Semester;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\Classes;

class SemesterChild extends Component
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
    public $subjects = [];
    /**
     * @var array
     */
    public $checkedSubjects = [];

    /**
     * @var array
     */
    public $classes = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.name' => '',
        'item.classes_id' => 'required',
        'item.description' => '',
        'item.start_date' => '',
        'item.end_date' => '',
        'item.class_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.classes_id' => 'Classes Id',
        'item.description' => 'Description',
        'item.start_date' => 'Start Date',
        'item.end_date' => 'End Date',
        'item.class_id' => 'Class',
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

    public $semester ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.semester.semester-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Semester $semester): void
    {
        $this->confirmingItemDeletion = true;
        $this->semester = $semester;
    }

    public function deleteItem(): void
    {
        $this->semester->delete();
        $this->confirmingItemDeletion = false;
        $this->semester = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('semester');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->subjects = Subject::orderBy('name')->get();
        $this->checkedSubjects = [];

        $this->classes = Classes::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Semester::create([
            'name' => $this->item['name'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
            'description' => $this->item['description'] ?? '', 
            'start_date' => $this->item['start_date'] ?? '', 
            'end_date' => $this->item['end_date'] ?? '', 
            'class_id' => $this->item['class_id'] ?? 0, 
        ]);
        $item->subjects()->attach($this->checkedSubjects);

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('semester');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Semester $semester): void
    {
        $this->resetErrorBag();
        $this->semester = $semester;
        $this->item = $semester->toArray();
        $this->confirmingItemEdit = true;

        $this->checkedSubjects = $semester->subjects->pluck("id")->map(function ($i) {
            return (string)$i;
        })->toArray();
        $this->subjects = Subject::orderBy('name')->get();


        $this->classes = Classes::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->semester->update([
            'name' => $this->item['name'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
            'description' => $this->item['description'] ?? '', 
            'start_date' => $this->item['start_date'] ?? '', 
            'end_date' => $this->item['end_date'] ?? '', 
         ]);

        $this->item->subjects()->sync($this->checkedSubjects);
        $this->checkedSubjects = [];
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('semester');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
