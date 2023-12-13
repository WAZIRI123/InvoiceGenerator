<?php

namespace App\Livewire\Exam;

use App\Models\Classes;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Exam;
use App\Rules\StartDateBeforeToday;
use Illuminate\Validation\Rule;

class Create extends Component
{

    public $item=[];
    public $marks_dist_types=[];
    public $marks_distribution_types=[];
    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];


    
    protected $rules = [
        'item.name' => 'required|string|max:255', 
        'item.classes_id' => 'required|integer|exists:classes,id', 
        'marks_dist_types' => 'required|array', 

        'item.open_for_marks_entry' => 'required|boolean', 
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.classes_id' => 'Class',
        'marks_dist_types' => 'distribution type ',
        'item.open_for_marks_entry' => 'open for marks entry',
  
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

    public $exam ;
    public $classes=[];


    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        $this->marks_distribution_types=[  
        1 => "Written",
        2 => "MCQ",
        3 => "SBA",
        4 => "Attendance",
        5 => "Assignment",
        6 => "Lab Report",
        7 => "Practical"
    ];

    $this->classes=Classes::all();
        return view('livewire.exam.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Exam $exam): void
    {
        $this->confirmingItemDeletion = true;
        $this->exam = $exam;
    }

    public function deleteItem(): void
    {
        $this->exam->delete();
        $this->confirmingItemDeletion = false;
        $this->exam = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('exam.table');
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

    $this->validate(); 
  $item = Exam::create([
            'name' => $this->item['name'], 
            'classes_id' => $this->item['classes_id'], 
            'marks_distribution_types' =>json_encode($this->marks_dist_types), 
            'open_for_marks_entry' => $this->item['open_for_marks_entry'], 
        
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('exam.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Exam $exam): void
    {
        $this->resetErrorBag();
        $this->exam = $exam;
 
        $this->item = $exam->toArray();
    
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        
        $this->validate(); 
        $item = $this->exam->update([
            'name' => $this->item['name'], 
            'classes_id' => $this->item['classes_id'], 
            'marks_distribution_types' => json_encode($this->item['marks_distribution_types']), 
            'open_for_marks_entry' => $this->item['open_for_marks_entry'], 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('exam.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
