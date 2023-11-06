<?php

namespace App\Livewire\Admin;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\WithFileUploads;

class Create extends Component
{
use WithFileUploads;

    public $item=[];

    public $profile;

    public $uploading;

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
    protected function rules()
    {
       return  $rules = [
            'item.name' => ['required', 'string', 'max:255'],
            'item.email' => ['required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user->id)->whereNull('deleted_at')],
            'item.password' => ['required', 'string', new Password(8), 'confirmed'],
            'item.password_confirmation' => ['required', 'string'],
            'profile' => ['nullable', 'image', 'max:1024'],
        ];
    
        
    }
 
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
        return view('livewire.admin.create');
    }


public function mount(){
   
    $this->user = User::where('id', auth()->user()->id)->first();
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
        $this->dispatch('refresh')->to('admin.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
    }

    public function setUploading(){
        $this->uploading=true;
    }

    public function removeUploading(){
        $this->uploading=false;
    }

    public function createItem(): void
    {
     $this->validate();
   
     $uploadFilePath =$this->profile?'storage/'.$this->profile->store('profiles','public'):'';

    $item = User::create([
        'name' => $this->item['name'],
        'email' => $this->item['email'],
        'password' => $this->item['password'],
        'profile_picture' =>  $uploadFilePath,
    ]);

    $this->confirmingItemCreation = false;
    $this->dispatch('refresh')->to('admin.table');
    $this->reset(['item','profile']);
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
        $this->dispatch('refresh')->to('admin.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}
