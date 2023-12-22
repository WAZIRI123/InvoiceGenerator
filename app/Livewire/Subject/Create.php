<?php

namespace App\Livewire\Subject;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Subject;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class Create extends Component
{

    public $item=[];

    public $subjectTypes=[];

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
    public $classes = [];


    

    /**
     * 
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.code' => 'Subject Code',
        'item.type' => 'type',
        'item.exclude_in_result' => 'exclude in result',
        'item.classes_id' => 'Class',
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

    public $subject ;

    public $teachersCollection=[] ;

    public $teachers = [];

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        $this->subjectTypes=[
            1 => 'Core',
            2 => 'Electives',
            3 => 'Selective'
        ];
        return view('livewire.subject.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Subject $subject): void
    {
        $this->confirmingItemDeletion = true;
        $this->subject = $subject;
    }

    public function deleteItem(): void
    {
          DB::beginTransaction();
        try {
            $this->subject->teachers()->detach();
            $this->subject->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('show', 'Failed to Delete')->to('livewire-toast');
  
        }

        $this->confirmingItemDeletion = false;
        $this->subject = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }
 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
        $this->reset(['item']);
        $this->item['code'] = IdGenerator::generate(['table' => 'subjects', 'field' => 'code', 'length' => 5, 'prefix' => 'S']);
        $this->teachersCollection = Teacher::all();
        
        $this->classes = Classes::orderBy('name')->get();
    }

    public function createItem(): void
    {
        $this->validate([
            'item.name' => 'required|string|max:255',
            'item.code' =>['required',Rule::unique('subjects', 'code')],
            'item.type' => 'required',
            'item.classes_id' => 'required|integer|exists:classes,id',
            'item.exclude_in_result' => 'nullable',
      
        ]);
  
        $item = Subject::create(
            [
            'name' => $this->item['name'], 
            'code' => $this->item['code'], 
            'classes_id' => $this->item['classes_id'], 
            'exclude_in_result' => $this->item['exclude_in_result']??0, 
            'type' => $this->item['type'], 
          ]
       );
      
       $item->teachers()->attach($this->teachers);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

    }
        
    #[On('showEditForm')]
    public function showEditForm(Subject $subject): void
    {
        $this->resetErrorBag();
        $this->subject = $subject;
     

        $this->teachers=$subject->teachers()->get()->pluck('id')->toArray();

        $this->item = $subject->toArray();
        $this->confirmingItemEdit = true;
        $this->teachersCollection = Teacher::all();
        
        $this->classes = Classes::orderBy('name')->get();
    }

    public function editItem(): void
    {
        $this->validate([
            'item.name' => 'required|string|max:255',
            'item.code' =>['required',Rule::unique('subjects', 'code')->ignore($this->subject->id)->whereNull('deleted_at')],
            'item.type' => 'required',
            'item.classes_id' => 'required|integer|exists:classes,id',
            'item.exclude_in_result' => 'nullable',
      
        ]);
        DB::beginTransaction();
        try {
        $this->subject->teachers()->detach();
        $item = $this->subject->update(         [
            'name' => $this->item['name'], 
            'code' => $this->item['code'], 
            'classes_id' => $this->item['classes_id'], 
            'exclude_in_result' => $this->item['exclude_in_result']??0, 
            'type' => $this->item['type'], 
          ]);

          $this->subject->teachers()->attach($this->teachers);
       
          DB::commit();
       
        } catch (\Exception $e) {

                
                DB::rollback();
                $this->dispatch('show', 'Failed to update')->to('livewire-toast');
      
            }

        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('subject.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

}

