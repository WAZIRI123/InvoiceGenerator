<?php

namespace App\Livewire\Category;

use App\Models\Category;
use Livewire\Component;
use \Illuminate\View\View;
use Livewire\Attributes\On; 


class Create extends Component
{

    public $item=[];


   
    /**
     * @var array
     */

    protected function rules()
    {
        return [
        'item.name' => 'required',
    ];
}

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'name',
   
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;


    public $category;

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
        return view('livewire.category.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Category $category): void
    {
       
        $this->confirmingItemDeletion = true;

        $this->category = $category;
    }
    

    public function deleteItem(category $category): void
    {
        $this->category->delete();
        $this->confirmingItemDeletion = false;
        $this->category = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('category.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');
    }
    
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->reset(['item']);
        $this->resetErrorBag();
    }

    public function createItem(): void
    {

         $category = Category::create([
            'name' => $this->item['name']
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('category.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(category $category): void
    {
       
        $this->resetErrorBag();
        $this->category= $category;
        $this->item['name']=$category->name;
        $this->confirmingItemEdit = true;
    }

    public function editItem(category $category): void
    {
         $this->category->update([
            'name' => $this->item['name']
        ]);

        $this->confirmingItemEdit = false;
        $this->category = '';
        $this->dispatch('refresh')->to('category.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
