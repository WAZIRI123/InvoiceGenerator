<?php

namespace App\Livewire\Subject;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Subject;
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
    public $classes = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.name' => 'required|string|max:255',
        'item.subject_code' => 'required',
        'item.classes_id' => 'required|integer|exists:classes,id',
        'item.description' => 'nullable|string',
        'item.classes_id' => 'required|integer|exists:classes,id',
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
        return view('livewire.subject.create');
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
        $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
        $this->reset(['item']);
        $this->item['subject_code'] = IdGenerator::generate(['table' => 'subjects', 'field' => 'subject_code', 'length' => 5, 'prefix' => 'S']);
        $this->classes = Classes::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = Subject::create(
            [
            'name' => $this->item['name'], 
            'subject_code' => $this->item['subject_code'], 
            'classes_id' => $this->item['classes_id'], 
            'description' => $this->item['description'], 
            'classes_id' => $this->item['classes_id'], 
          ]
       );
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('subject.table');
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
            'name' => $this->item['name'] , 
            'subject_code' => $this->item['subject_code'], 
            'classes_id' => $this->item['classes_id'], 
            'description' => $this->item['description'], 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
