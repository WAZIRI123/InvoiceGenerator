<?php

namespace App\Livewire\Item;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Item;
use Livewire\Attributes\On; 
use Illuminate\Validation\Rule;

class Create extends Component
{

    public $item=[];

   
    
    /**
     * @var array
     */
    public $categories = [];
    public  $category;
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
        'item.email' => 'Email',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;


    public $Item;

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
        return view('livewire.item.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Item $Item): void
    {
        $this->authorize('delete', $Item);
        $this->confirmingItemDeletion = true;

        $this->Item = $Item;
    }
    

    public function deleteItem(Item $Item): void
    {

        $this->authorize('delete', $Item);
        category::find($this->Item->category_id)->delete();
        $this->Item->delete();
        $this->confirmingItemDeletion = false;
        $this->Item = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('Item.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');
    }
    
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item','profile_picture']);

        $this->categories = category::orderBy('name')->get();

    }

    public function createItem(): void
    {
        $this->authorize('create', [Item::class]);
        if ($this->profile_picture) {
            $rule['profile_picture'] = 'image|mimes:jpeg,png';
        }
        $this->validate();
        if ($this->profile_picture) {
            $profile_picture=$this->profile_picture->storeAs('img/profile_picture/upload',$this->profile_picture->getClientOriginalName(),'public');
         }
         $category = category::create([
            'name' => $this->item['name'],
            'profile_picture' => $profile_picture?? auth()->category()->avatarUrl($this->item['email']) ,
            'email' => $this->item['email'],
        ]);
        $category->assignRole('Item');
        Item::create([
            'category_id' => $category->id
        ]);

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('Item.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(Item $Item): void
    {
       
        $this->authorize('update', $Item);
        $this->resetErrorBag();
        $this->reset(['profile_picture']);
        $this->Item= $Item;
        $this->category= $Item->category;
        $this->item['name']=$Item->category->name;
       
        $this->item['email']=$Item->category->email;
        
        $this->oldImage=$Item->category->profile_picture;
        $this->confirmingItemEdit = true;
        

        $this->categories = category::orderBy('name')->get();
    }

    public function editItem(Item $Item): void
    {
        $this->authorize('update', $Item);
        $this->validate();
        if ($this->profile_picture) {
            $profile_picture=$this->profile_picture->storeAs('img/profile_picture/upload',$this->profile_picture->getClientOriginalName(),'public');
            if ($this->oldImage!=null) {
                Storage::delete($this->oldImage);
            }
         
        }
         else{
            $profile_picture=$this->oldImage;
         }

         $this->category->update([
            'name' => $this->item['name'],
            'email' => $this->item['email'],
            'profile_picture' => $profile_picture?? auth()->category()->avatarUrl($this->item['email']) ,
        ]);

        $this->confirmingItemEdit = false;
        $this->Item = '';
        $this->dispatch('Item.table', 'refresh');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
