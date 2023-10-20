<?php

namespace App\Livewire;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\User;
use Livewire\Attributes\On;

class WertChild extends Component
{

    public $item=[];

    /**
     * @var array
     */
    protected $rules = [
        'item.name' => '',
        'item.email' => '',
        'item.branch_id' => '',
        'item.email_verified_at' => '',
        'item.password' => '',
        'item.profile_picture' => '',
        'item.deleted_at' => '',
        'item.remember_token' => '',
        'item.created_at' => '',
        'item.updated_at' => '',
    ];

    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.email' => 'Email',
        'item.branch_id' => 'Branch Id',
        'item.email_verified_at' => 'Email Verified At',
        'item.password' => 'Password',
        'item.profile_picture' => 'Profile Picture',
        'item.deleted_at' => 'Deleted At',
        'item.remember_token' => 'Remember Token',
        'item.created_at' => 'Created At',
        'item.updated_at' => 'Updated At',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    //remove type in this var
    public $user;

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
        return view('livewire.wert-child');
    }
    // change int $id to User $user
    // change  $this->primaryKey = $id; to $this->user = $user;
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
        $item = User::create([
            'name' => $this->item['name'] ?? '', 
            'email' => $this->item['email'] ?? '', 
            'branch_id' => $this->item['branch_id'] ?? '', 
            'email_verified_at' => $this->item['email_verified_at'] ?? '', 
            'password' => $this->item['password'] ?? '', 
            'profile_picture' => $this->item['profile_picture'] ?? '', 
            'deleted_at' => $this->item['deleted_at'] ?? '', 
            'remember_token' => $this->item['remember_token'] ?? '', 
            'created_at' => $this->item['created_at'] ?? '', 
            'updated_at' => $this->item['updated_at'] ?? '', 
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
    // change int $id to User $user
    // change  $this->primaryKey = $id; to $this->user = $user;
    // change $this->item = $user; $this->user = $user;
    #[On('showEditForm')]
    public function showEditForm(User $user): void
    {
        $this->resetErrorBag();
        $this->user= $user;
        $this->item=$user->toArray();
        $this->confirmingItemEdit = true;
        
    }

    public function editItem(): void
    {
        // change save $this-item->save() to $this->user->update()
        $this->validate();
        $item = $this->user->update([
            'name' => $this->item['name'] ?? '', 
            'email' => $this->item['email'] ?? '', 
            'branch_id' => $this->item['branch_id'] ?? '', 
            'email_verified_at' => $this->item['email_verified_at'] ?? '', 
            'password' => $this->item['password'] ?? '', 
            'profile_picture' => $this->item['profile_picture'] ?? '', 
            'deleted_at' => $this->item['deleted_at'] ?? '', 
            'remember_token' => $this->item['remember_token'] ?? '', 
            'created_at' => $this->item['created_at'] ?? '', 
            'updated_at' => $this->item['updated_at'] ?? '', 
        ]);
  
        $this->confirmingItemEdit = false;
        $this->dispatch('refresh')->to('wert');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
