<?php

namespace App\Livewire\Class;

use App\Models\Classes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;


class Create extends Component
{
    use AuthorizesRequests;

    public $item=[];
    public $class;
  
    protected function rules()
    {
        return [
            'item.name' => ['required', Rule::unique('classes','name')->ignore($this->class->id??0)],

    ];
}

    /**0626 506 672
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'class name',
       
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


    public function render(): View
    {
        return view('livewire.class.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Classes $Classes): void
    {

        $this->authorize('delete', $Classes);
        $this->confirmingItemDeletion = true;

        $this->class = $Classes;
    }
    
  
   
    public function deleteItem(Classes $Classes): void
    {

        $this->authorize('delete', $Classes);
        $this->class->delete();
        $this->confirmingItemDeletion = false;
        $this->class = '';
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
        $this->authorize('create', [Classes::class]);
        
   
        $this->validate();
       
         $Classes = Classes::create([
            'name' => $this->item['name'],
        
        ]);
       
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('class.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(Classes $Classes): void
    {
       
        $this->resetErrorBag();
       
        $this->class= $Classes;
        $this->item['name']=$Classes->name;
      
        $this->confirmingItemEdit = true;
        
    }

    public function editItem(Classes $Classes): void
    {
        $this->authorize('update', $Classes);
 
        
        $this->validate();
        $this->class->update([
            'name' => $this->item['name'],
      
        ]);


        $this->confirmingItemEdit = false;
        $this->class = '';
        $this->dispatch('class.table', 'refresh');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
