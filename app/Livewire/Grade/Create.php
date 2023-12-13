<?php

namespace App\Livewire\Grade;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Grade;

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
    protected $rules = [
        'item.name' => 'required',
        'item.rules' => 'required',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.rules' => 'Rules',
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

    public $grade ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.grade.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Grade $grade): void
    {
        $this->confirmingItemDeletion = true;
        $this->grade = $grade;
    }

    public function deleteItem(): void
    {
        $this->grade->delete();
        $this->confirmingItemDeletion = false;
        $this->grade = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('grade.table');
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
        $item = Grade::create([
            'name' => $this->item['name'] ?? '', 
            'rules' => $this->item['rules'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('grade.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Grade $grade): void
    {
        $this->resetErrorBag();
        $this->grade = $grade;
        $this->item = $grade->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->grade->update([
            'name' => $this->item['name'] ?? '', 
            'rules' => $this->item['rules'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('grade.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
