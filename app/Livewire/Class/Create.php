<?php

namespace App\Livewire\Class;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Classes;
use Illuminate\Validation\Rule;

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
    protected $validationAttributes = [
        'item.name' => 'Name',
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

    public $classes ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.class.create');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Classes $classes): void
    {
        $this->confirmingItemDeletion = true;
        $this->classes = $classes;
    }

    public function deleteItem(): void
    {
        $this->classes->delete();
        $this->confirmingItemDeletion = false;
        $this->classes = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('class.table');
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
        $this->validate(    
            [
            'item.name' => ['required', 'string', 'max:255', Rule::unique('classes', 'name')],
         ]
        
    );
        $item = Classes::create([
            'name' => $this->item['name'], 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('class.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Classes $classes): void
    {
        $this->resetErrorBag();
        $this->classes = $classes;
        $this->item = $classes->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate(   [
            'item.name' => ['required', 'string', 'max:255', Rule::unique('classes', 'name')->ignore($this->classes->id)->whereNull('deleted_at')],
         ]);
        $item = $this->classes->update([
            'name' => $this->item['name'], 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('class.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
