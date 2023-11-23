<?php

namespace App\Livewire\GradeSystem;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\GradeSystem;
use App\Models\Exam;

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
    public $exams = [];

    /**
     * @var array
     */
    protected $rules = [
        'item.exam_id' => 'required|numeric',
        'item.mark_from' => '',
        'item.mark_to' => '',
        'item.remark' => '',
        'item.exam_id' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.exam_id' => 'Exam Id',
        'item.mark_from' => 'Mark From',
        'item.mark_to' => 'Mark To',
        'item.remark' => 'Remark',
        'item.exam_id' => 'Exam',
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

    public $gradesystem ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.grade-system.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(GradeSystem $gradesystem): void
    {
        $this->confirmingItemDeletion = true;
        $this->gradesystem = $gradesystem;
    }

    public function deleteItem(): void
    {
        $this->gradesystem->delete();
        $this->confirmingItemDeletion = false;
        $this->gradesystem = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->exams = Exam::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate();
        $item = GradeSystem::create([
            'exam_id' => $this->item['exam_id'] ?? '', 
            'mark_from' => $this->item['mark_from'] ?? '', 
            'mark_to' => $this->item['mark_to'] ?? '', 
            'remark' => $this->item['remark'] ?? '', 
            'exam_id' => $this->item['exam_id'] ?? 0, 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(GradeSystem $gradesystem): void
    {
        $this->resetErrorBag();
        $this->gradesystem = $gradesystem;
        $this->item = $gradesystem->toArray();
        $this->confirmingItemEdit = true;

        $this->exams = Exam::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->gradesystem->update([
            'exam_id' => $this->item['exam_id'] ?? '', 
            'mark_from' => $this->item['mark_from'] ?? '', 
            'mark_to' => $this->item['mark_to'] ?? '', 
            'remark' => $this->item['remark'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
