<?php

namespace App\Livewire\Section;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Section;
use App\Models\User;
use App\Models\Classes;

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
    public $teachers = [];

    /**
     * @var array
     */
    public $classes = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.name' => 'required|string|max:255',
        'item.capacity' => 'required|integer|min:1',
        'item.classes_id' => 'required|exists:classes,id',
        'item.teacher_id' => 'required|exists:teachers,id',
        'item.note' => 'nullable|string|max:500',
        'item.status' => 'required',
    ];
    
    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.capacity' => 'Capacity',
        'item.classes_id' => 'Classes Id',
        'item.teacher_id' => 'Teacher Id',
        'item.note' => 'Note',
        'item.status' => 'Status',
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

    public $section ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.section.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Section $section): void
    {
        $this->confirmingItemDeletion = true;
        $this->section = $section;
    }

    
    public function deleteItem(): void
    {
        $this->section->delete();
        $this->confirmingItemDeletion = false;
        $this->section = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('section.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->teachers = User::orderBy('name')->get();

        $this->classes = Classes::orderBy('name')->get();
    }

    public function createItem(): void
    {
   
        $this->validate();
        $sectionExists=Section::where([
            'name' => $this->item['name'], 
            'capacity' => $this->item['capacity'], 
            'classes_id' => $this->item['classes_id'], 
            'teacher_id' => $this->item['teacher_id'],  
        ])->get();
     
        if ($sectionExists->isEmpty()) {
            $item = Section::create([
                'name' => $this->item['name'], 
                'capacity' => $this->item['capacity'], 
                'classes_id' => $this->item['classes_id'], 
                'teacher_id' => $this->item['teacher_id'], 
                'note' => $this->item['note'], 
                'status' => $this->item['status']=='true' ? 1:0, 
            ]);
        }else {
            return;
        }
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('section.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Section $section): void
    {
        $this->resetErrorBag();
        $this->section = $section;
        $this->item = $section->toArray();
        $this->confirmingItemEdit = true;

        $this->teachers = User::orderBy('name')->get();

        $this->classes = Classes::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();

            $item = $this->section->update([
                'name' => $this->item['name'], 
                'capacity' => $this->item['capacity'], 
                'classes_id' => $this->item['classes_id'], 
                'teacher_id' => $this->item['teacher_id'], 
                'note' => $this->item['note'], 
                'status' => $this->item['status'], 
             ]);
    
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('section.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
