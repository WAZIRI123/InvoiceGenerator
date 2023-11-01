<?php

namespace App\Livewire\Subjecs;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Subject;
use App\Models\Classes;

class SubjectsChild extends Component
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
    protected $rules = [
        'item.name' => 'required',
        'item.subject_code' => '',
        'item.classes_id' => 'required',
        'item.description' => '',
        'item.classes_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.subject_code' => 'Subject Code',
        'item.classes_id' => 'Classes Id',
        'item.description' => 'Description',
        'item.classes_id' => 'Class',
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

    public $subject ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.subjecs.subjects-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Subject $subject): void
    {
        $this->confirmingItemDeletion = true;
        $this->subject = $subject;
    }

    public function deleteItem(): void
    {
        $this->subject->delete();
        $this->confirmingItemDeletion = false;
        $this->subject = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('subjects');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->classes = Classes::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Subject::create([
            'name' => $this->item['name'] ?? '', 
            'subject_code' => $this->item['subject_code'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
            'description' => $this->item['description'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('subjects');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Subject $subject): void
    {
        $this->resetErrorBag();
        $this->subject = $subject;
        $this->item = $subject->toArray();
        $this->confirmingItemEdit = true;

        $this->classes = Classes::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->subject->update([
            'name' => $this->item['name'] ?? '', 
            'subject_code' => $this->item['subject_code'] ?? '', 
            'classes_id' => $this->item['classes_id'] ?? '', 
            'description' => $this->item['description'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('subjects');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
