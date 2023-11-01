<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\User;

class AdminChild extends Component
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
        'item.name' => 'required|string|max:255',
        'item.email' => 'required|email|max:255',
        'item.password' => 'required|string|min:8|confirmed',
        'item.profile_picture' => 'required|image|max:2048',

    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.email' => 'Email',
        'item.password' => 'Password',
        'item.confirm_password'=>'Confirm Password',
        'item.profile_picture' => 'Profile Picture',
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

    public $user ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.admin.admin-child');
    }
    #[On('showDeleteForm')]
    public function showDeleteForm(User $user): void
    {
        $this->confirmingItemDeletion = true;
        $this->user = $user;
    }

    public function deleteItem(): void
    {
        $this->user->delete();
        $this->confirmingItemDeletion = false;
        $this->user = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('user');
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
        $item = User::create([
            'name' => $this->item['name'], 
            'email' => $this->item['email'], 
            'password' => $this->item['password'], 
            'profile_picture' => $this->item['profile_picture'], 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('user');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(User $user): void
    {
        $this->resetErrorBag();
        $this->user = $user;
        $this->item = $user->toArray();
        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        $this->validate();
        $item = $this->user->update([
            'name' => $this->item['name'], 
            'email' => $this->item['email'], 
            'password' => $this->item['password'], 
            'profile_picture' => $this->item['profile_picture'], 
         ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('user');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
