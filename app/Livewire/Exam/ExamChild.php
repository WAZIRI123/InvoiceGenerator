<?php

namespace App\Livewire\Exam;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Exam;

class ExamChild extends Component
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
    protected $rules = [
        'item.name' => '',
        'item.slug' => '',
        'item.description' => '',
        'item.start_date' => '',
        'item.end_date' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.slug' => 'Slug',
        'item.description' => 'Description',
        'item.start_date' => 'Start Date',
        'item.end_date' => 'End Date',
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

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.exam.exam-child');
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
        $this->dispatch('refresh')->to('exam');
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
            'name' => $this->item['name'] ?? '', 
            'slug' => $this->item['slug'] ?? '', 
            'description' => $this->item['description'] ?? '', 
            'start_date' => $this->item['start_date'] ?? '', 
            'end_date' => $this->item['end_date'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('exam');
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
            'name' => $this->item['name'] ?? '', 
            'slug' => $this->item['slug'] ?? '', 
            'description' => $this->item['description'] ?? '', 
            'start_date' => $this->item['start_date'] ?? '', 
            'end_date' => $this->item['end_date'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('exam');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
