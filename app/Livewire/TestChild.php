<?php

namespace App\Livewire;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Role;

class TestChild extends Component
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
        'item.guard_name' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.guard_name' => 'Guard Name',
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

    public $role ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.test-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Role $role): void
    {
        $this->confirmingItemDeletion = true;
        $this->role = $role;
    }

    public function deleteItem(): void
    {
        $this->role->delete();
        $this->confirmingItemDeletion = false;
        $this->role = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('test');
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
        $item = Role::create([
            'name' => $this->item['name'] ?? '', 
            'guard_name' => $this->item['guard_name'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('test');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Role $role): void
    {
        $this->resetErrorBag();
        $this->role = $role;
        $this->item = $role->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->role->update([
            'name' => $this->item['name'] ?? '', 
            'guard_name' => $this->item['guard_name'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('test');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
