<?php

namespace App\Livewire\Employee;

use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Employee;
use App\Models\Product;
use App\Models\User;
use Livewire\Attributes\On; 
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class Create extends Component
{
    use AuthorizesRequests, WithFileUploads;

    public $item=[];

   
    
    /**
     * @var array
     */
    public $users = [];
    public  $user;
    public $profile_picture;
    public $oldImage;
    /**
     * @var array
     */

     public function mount(){
        $this->user=auth()->user();

     }
    protected function rules()
    {
        return [
        'item.name' => 'required',
        'item.email' =>['required','email',Rule::unique('users','email')->ignore($this->user->id)->whereNull('deleted_at')],
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


    public $employee;

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
        return view('livewire.employee.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Employee $employee): void
    {
        $this->authorize('delete', $employee);
        $this->confirmingItemDeletion = true;

        $this->employee = $employee;
    }
    

    public function deleteItem(Employee $employee): void
    {

        $this->authorize('delete', $employee);
        User::find($this->employee->user_id)->delete();
        $this->employee->delete();
        $this->confirmingItemDeletion = false;
        $this->employee = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('employee.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');
    }
    
    #[On('post-created')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item','profile_picture']);

        $this->users = User::orderBy('name')->get();

    }

    public function createItem(): void
    {
        $this->authorize('create', [Employee::class]);
        if ($this->profile_picture) {
            $rule['profile_picture'] = 'image|mimes:jpeg,png';
        }
        $this->validate();
        if ($this->profile_picture) {
            $profile_picture=$this->profile_picture->storeAs('img/profile_picture/upload',$this->profile_picture->getClientOriginalName(),'public');
         }
         $user = User::create([
            'name' => $this->item['name'],
            'profile_picture' => $profile_picture?? auth()->user()->avatarUrl($this->item['email']) ,
            'email' => $this->item['email'],
        ]);
        $user->assignRole('Employee');
        Employee::create([
            'user_id' => $user->id
        ]);

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('employee.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(Employee $employee): void
    {
       
        $this->authorize('update', $employee);
        $this->resetErrorBag();
        $this->reset(['profile_picture']);
        $this->employee= $employee;
        $this->user= $employee->user;
        $this->item['name']=$employee->user->name;
       
        $this->item['email']=$employee->user->email;
        
        $this->oldImage=$employee->user->profile_picture;
        $this->confirmingItemEdit = true;
        

        $this->users = User::orderBy('name')->get();
    }

    public function editItem(Employee $employee): void
    {
        $this->authorize('update', $employee);
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

         $this->user->update([
            'name' => $this->item['name'],
            'email' => $this->item['email'],
            'profile_picture' => $profile_picture?? auth()->user()->avatarUrl($this->item['email']) ,
        ]);

        $this->confirmingItemEdit = false;
        $this->employee = '';
        $this->dispatch('employee.table', 'refresh');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
