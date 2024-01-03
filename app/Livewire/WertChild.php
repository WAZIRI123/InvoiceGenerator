<?php

namespace App\Livewire;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\AcademicYear;

class WertChild extends Component
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
        'item.academic_year' => '',
        'item.start_date' => '',
        'item.end_date' => '',
        'item.status' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.academic_year' => 'Academic Year',
        'item.start_date' => 'Start Date',
        'item.end_date' => 'End Date',
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

    public $academicyear ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.wert-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(AcademicYear $academicyear): void
    {
        $this->confirmingItemDeletion = true;
        $this->academicyear = $academicyear;
    }

    public function deleteItem(): void
    {
        $this->academicyear->delete();
        $this->confirmingItemDeletion = false;
        $this->academicyear = '';
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
    }

    public function createItem(): void
    {
        $this->validate();
        $item = AcademicYear::create([
            'academic_year' => $this->item['academic_year'] ?? '', 
            'start_date' => $this->item['start_date'] ?? '', 
            'end_date' => $this->item['end_date'] ?? '', 
            'status' => $this->item['status'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(AcademicYear $academicyear): void
    {
        $this->resetErrorBag();
        $this->academicyear = $academicyear;
        $this->item = $academicyear->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->academicyear->update([
            'academic_year' => $this->item['academic_year'] ?? '', 
            'start_date' => $this->item['start_date'] ?? '', 
            'end_date' => $this->item['end_date'] ?? '', 
            'status' => $this->item['status'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
