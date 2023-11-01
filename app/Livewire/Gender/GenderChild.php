<?php

namespace App\Livewire\Gender;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Gender;

class GenderChild extends Component
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

    public $gender ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.gender.gender-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(Gender $gender): void
    {
        $this->confirmingItemDeletion = true;
        $this->gender = $gender;
    }

    public function deleteItem(): void
    {
        $this->gender->delete();
        $this->confirmingItemDeletion = false;
        $this->gender = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('gender');
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
        $item = Gender::create([
            'name' => $this->item['name'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('gender');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Gender $gender): void
    {
        $this->resetErrorBag();
        $this->gender = $gender;
        $this->item = $gender->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->gender->update([
            'name' => $this->item['name'] ?? '', 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('gender');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
