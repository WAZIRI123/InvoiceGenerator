<?php

namespace App\Livewire\Subject;

use App\Models\Classes;
use App\Models\Subject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;


class Create extends Component
{
    use AuthorizesRequests;

    public $item=[];
    public $subject;
    public $classes;
    public $class;
    protected function rules()
    {
        return [
           
            'item.name' => 'required|string|max:255', // Change the max length as needed
    'item.subject_code' => [
        'required',
        'string',
        'max:255', // Change the max length as needed
        Rule::unique('subjects', 'subject_code')->where('classes_id', $this->class->id?? 0)
    ],
    'item.classes_id' => 'required|exists:classes,id',
    'item.description' => 'nullable|string', // This field is optional
    ];
}

    /**0626 506 672
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Subject Name',
        'item.subject_code' => 'Subject Code',
        'item.classes_id' => 'Classes ID',
        'item.description' => 'Description',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;


   

    /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function mount()
    {
     $this->classes=Classes::all();
    }

    public function render(): View
    {
        return view('livewire.subject.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Subject $subject): void
    {

        $this->authorize('delete', $subject);
        $this->confirmingItemDeletion = true;

        $this->subject = $subject;
    }

   
    public function deleteItem(Subject $subject): void
    {

        $this->authorize('delete', $subject);
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
    }

    public function createItem(): void
    {
        $this->authorize('create', [subject::class]);
 
        $this->validate();
       
         $subject = subject::create([
         'name' => $this->item['name'],
    'subject_code' => $this->item['subject_code'], 
    'classes_id' => $this->item['classes_id'],
    'description' => $this->item['description'],
        ]);
       
        $this->confirmingItemCreation = false;
           $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(Subject $subject): void
    {
       
        $this->authorize('update', $subject);
        $this->resetErrorBag();
        $this->subject= $subject;
        $this->item['name'] = $subject->name;
        $this->item['subject_code'] = $subject->subject_code;
        $this->item['classes_id'] = $subject->classes_id;
        $this->item['description'] = $subject->description;
        $this->confirmingItemEdit = true;

    }

    public function editItem(Subject $subject): void
    {
        $this->authorize('update', $subject);
     
        $this->validate();
        $this->subject->update([
            'name' => $this->item['name'],
            'subject_code' => $this->item['subject_code'], 
            'classes_id' => $this->item['classes_id'],
            'description' => $this->item['description'],
        ]);


        $this->confirmingItemEdit = false;
        $this->subject = '';
          $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
