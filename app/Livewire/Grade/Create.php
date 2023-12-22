<?php

namespace App\Livewire\Grade;

use App\Http\Helpers\AppHelper;
use Livewire\Attributes\On;
use Livewire\Component;
use \Illuminate\View\View;
use App\Models\Grade;
use Illuminate\Validation\Rule;

class Create extends Component
{

    public $item=[];

    public $gradings=[];

    /**
     * @var array
     */
    protected $listeners = [
        'showDeleteForm',
        'showCreateForm',
        'showEditForm',
    ];

    public function rules()
    {
        $rules = [];
    
        $rules["item.name"] = ['required','string',Rule::unique('grades', 'name')->ignore($this->grade->id)->whereNull('deleted_at')];
    
        $rules["item.marks_from"] = 'required|numeric|min:0|max:100';

       $rules["item.marks_upto"] = "required|numeric|gte:item.marks_from|min:0|max:100";
 
    
        return $rules;
    }
    


    /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'Name',
        'item.marks_from' => 'marks from',
        'item.marks_upto'=>'marks upto',
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

    public $grade ;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;

    public function render(): View
    {
        return view('livewire.grade.create');
    }

 
    
    #[On('showDeleteForm')]
    public function showDeleteForm(Grade $grade): void
    {
        $this->confirmingItemDeletion = true;
        $this->grade = $grade;
    }

    public function deleteItem(): void
    {
        $this->grade->delete();
        $this->confirmingItemDeletion = false;
        $this->grade = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('grade.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');

    }

 
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        session()->forget('grade.exists');
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);
    }

    public function createItem(): void
    {
        session()->forget('grade.exists');
        $this->validate();
        //get all grades in the class group
        $gradesInDb = Grade::all();

        if ($this->gradeRangeExists(['marks_from' => $this->item['marks_from'], 'marks_upto' => $this->item['marks_upto']], $gradesInDb)) {
            session()->put('grade.exists', 'Grade range is in another range');

            return;
        }
        
        $item = Grade::create([
            'name' => $this->item['name'], 
            'marks_from' => $this->item['marks_from'], 
            'marks_upto'=>$this->item['marks_upto'],
        ]);

        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('grade.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');

        }
        
 
        
    #[On('showEditForm')]
    public function showEditForm(Grade $grade): void
    {
        session()->forget('grade.exists');
        $this->resetErrorBag();
        $this->grade = $grade;

        $this->item = $grade->toArray();

        $this->confirmingItemEdit = true;
    }

    public function editItem(): void
    {
        session()->forget('grade.exists');
        $rules["item.name"] = ['required','string',Rule::unique('grades', 'name')->ignore($this->grade->id)->whereNull('deleted_at')];
        $this->validate();

        $gradesInDb = Grade::all()->except($this->grade->id);

        if ($this->gradeRangeExists(['marks_from' => $this->item['marks_from'], 'marks_upto' => $this->item['marks_upto']], $gradesInDb)) {
            session()->put('grade.exists', 'Grade range is in another range');
            return;
        }
        
        $item = $this->grade->update([
            'name' => $this->item['name'], 
            'marks_from' => $this->item['marks_from'], 
            'marks_upto'=>$this->item['marks_upto'],
        ]);
        $this->confirmingItemEdit = false;
        $this->primaryKey = '';
        $this->dispatch('refresh')->to('grade.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');

    }

    public function gradeRangeExists($grade, $grades)
    {
        foreach ($grades as $i) {
            //check if given grade is in range of grade in array
            if ($grade['marks_from'] >= $i['marks_from'] && $grade['marks_upto'] <= $i['marks_upto']) {
                return true;
            }
            //check if array grade is in range of given grade
            if ($i['marks_from'] >= $grade['marks_from'] && $i['marks_upto'] <= $grade['marks_upto']) {
                return true;
            }
            //check if given grade starts at array grade
            if (in_array($grade['marks_from'], range($i['marks_from'], $i['marks_upto']))) {
                return true;
            }
            //check if given grade ends at array grade
            if (in_array($grade['marks_upto'], range($i['marks_from'], $i['marks_upto']))) {
                return true;
            }
        }

        return false;
    }

}
