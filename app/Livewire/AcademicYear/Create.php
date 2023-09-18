<?php

namespace App\Livewire\AcademicYear;

use App\Models\AcademicYear;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;


class Create extends Component
{
    use AuthorizesRequests;

    public $item=[];
    public $academicYear;
  
    protected function rules()
    {
        return [
           
            'item.academic_year' =>  ['required',Rule::unique('academic_years','academic_year')->ignore($this->academicYear->academic_year??0)],
            'item.start_date' => 'required|date_format:Y-m-d',
            'item.end_date' => 'required|date_format:Y-m-d|after:start_date',
            'item.status' => 'required|in:active,inactive',
    ];
}

    /**0626 506 672
     * @var array
     */
    protected $validationAttributes = [
        'item.academic_year' => 'academic year',
        'item.start_date' => 'start date',
        'item.end_date' => 'end date',
        'item.status' => 'status',
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

    public function addAcademicYear()
    {
          // Calculate the academic_year based on start_date and end_date
    $startYear = date('Y', strtotime($this->item['start_date']));
    $endYear = date('Y', strtotime($this->item['end_date']));
    $academicYear = $startYear . '-' . $endYear;

    // Add the academic_year to the data array
    return  $academicYear;
    }

    public function render(): View
    {
        return view('livewire.academic-year.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(AcademicYear $academicYear): void
    {

        $this->authorize('delete', $academicYear);
        $this->confirmingItemDeletion = true;

        $this->academicYear = $academicYear;
    }
    
    public function setItemEndDate($value)
    {
     
        // Check if the start_date field is not empty
        if (!empty($value)) {
            // Calculate the end_date by adding one year to the start_date
          return   date('Y-m-d', strtotime($value . ' +1 year'));
        }
    }
   
    public function deleteItem(AcademicYear $academicYear): void
    {

        $this->authorize('delete', $academicYear);
        $this->academicYear->delete();
        $this->confirmingItemDeletion = false;
        $this->academicYear = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('academic-year.table');
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
        $this->authorize('create', [AcademicYear::class]);
        
        $this->item['end_date']=$this->setItemEndDate($this->item['start_date']);
        $this->item['academic_year']=$this->addAcademicYear();
        $this->validate();
       
         $academicYear = AcademicYear::create([
            'academic_year' => $this->item['academic_year'],
            'start_date' => $this->item['start_date'], 
            'end_date' => $this->item['end_date'],
            'status' => $this->item['status'],
        ]);
       
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('academic-year.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }
    #[On('showEditForm')]
    public function showEditForm(AcademicYear $academicYear): void
    {
       
        $this->authorize('update', $academicYear);
        $this->resetErrorBag();
        $this->academicYear= $academicYear;
        $this->item['academic_year']=$academicYear->academic_year;
        $this->item['start_date']=$academicYear->start_date;
        $this->item['end_date']=$academicYear->end_date;
        $this->item['status']=$academicYear->status;
        $this->confirmingItemEdit = true;

    }

    public function editItem(AcademicYear $academicYear): void
    {
        $this->authorize('update', $academicYear);
        $this->item['academic_year']=$this->addAcademicYear();
        
        $this->validate();
        $this->academicYear->update([
            'academic_year' => $this->item['academic_year'],
            'start_date' => $this->item['start_date'], 
            'end_date' => $this->item['end_date'],
            'status' => $this->item['status'],
        ]);


        $this->confirmingItemEdit = false;
        $this->academicYear = '';
        $this->dispatch('academic-year.table', 'refresh');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
