<?php

namespace App\Livewire\CareRental;

use App\Models\Car;
use App\Models\Rental;
use App\Rules\CarAvailabilityRule;
use Livewire\Attributes\On;

use Livewire\Component;

class Create extends Component
{
    public $item=[];
    protected function rules()
    {
        return [
            'item.visitorName' => 'required',
            'item.arrivalDate' => 'required|date',
            'item.safariStartDate' => [
                'required',
                'date',
            
            ],
            'item.safariEndDate' => [
                'required',
                'date',
                'after_or_equal:item.safariStartDate',
              
            ],
            'item.carNumber' => 'required',
            'item.guideName' => 'required',
            'item.specialEvent' => 'required',
        ];
    }
    
    protected $validationAttributes = [
        'item.visitorName' => 'Visitor Name',
        'item.arrivalDate' => 'Arrival Date',
        'item.safariStartDate' => 'Safari Start Date',
        'item.safariEndDate' => 'Safari End Date',
        'item.carNumber' => 'Car Number',
        'item.guideName' => 'Guide Name',
        'item.specialEvent' => 'Special Event',
    ];

      /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    public $rental;

    public $cars;

    public $car;
    
        /**
     * @var bool
     */
    public $confirmingItemCreation = false;

    /**
     * @var bool
     */
    public $confirmingItemEdit = false;
    
    #[On('showDeleteForm')]
    public function showDeleteForm(Rental $rental): void
    {
      
        $this->confirmingItemDeletion = true;

        $this->rental = $rental;
    }

    public function deleteItem(Rental $rental): void
    {

      
        $this->rental->delete();
        $this->confirmingItemDeletion = false;
        $this->rental = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('care-rental.table');
        $this->dispatch('show', 'Record Deleted Successfully')->to('livewire-toast');
    }

   
    #[On('showCreateForm')]
    public function showCreateForm(): void
    {
        $this->confirmingItemCreation = true;
        $this->resetErrorBag();
        $this->reset(['item']);

        $this->cars = Car::orderBy('name')->get();

    }

    public function mount(){
        $this->cars = Car::orderBy('name')->get();
    }
    
    public function createItem(): void
    {
        $this->validate();

        // Check for existing overlapping rentals
        $existingRental = Rental::where('carNumber', $this->item['carNumber'])
            ->where(function ($query) {
                $query->whereBetween('safariStartDate', [$this->item['safariStartDate'], $this->item['safariEndDate']])
                    ->orWhereBetween('safariEndDate', [$this->item['safariStartDate'], $this->item['safariEndDate']])
                    ->orWhere(function ($query) {
                        $query->where('safariStartDate', '<=', $this->item['safariStartDate'])
                            ->where('safariEndDate', '>=', $this->item['safariEndDate']);
                    });
            })
            ->first();
    
        // If no overlapping rental found, create the rental
        if (!$existingRental) {
            $rental = Rental::create([
                'visitorName' => $this->item['visitorName'],
                'arrivalDate' => $this->item['arrivalDate'],
                'safariStartDate' => $this->item['safariStartDate'],
                'safariEndDate' => $this->item['safariEndDate'],
                'carNumber' => $this->item['carNumber'],
                'guideName' => $this->item['guideName'],
                'specialEvent' => $this->item['specialEvent'],
            ]);
            $this->confirmingItemCreation = false;
            $this->dispatch('refresh')->to('care-rental.table');
            $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
        } else {
            // Show an error message indicating overlapping rental
            $this->addError('item.safariStartDate', 'There is an overlapping Car Reserve for the selected dates.');
        }
    }

    #[On('showEditForm')]
    public function showEditForm(Rental $rental): void
    {
        $this->resetErrorBag();
        $this->rental= $rental;
        $this->item['visitorName']=$rental->visitorName;
        $this->item['arrivalDate']=$rental->arrivalDate;
        $this->item['safariStartDate']=$rental->safariStartDate;
        $this->item['safariEndDate']=$rental->safariEndDate;
        $this->item['carNumber']=$rental->car?->car_number;
        $this->item['guideName']=$rental->guideName;
        $this->item['specialEvent']=$rental->specialEvent;
        
        $this->confirmingItemEdit = true;
        

        $this->cars = Car::orderBy('name')->get();
    }

    public function editItem(Rental $rental): void
    {
     // Validate the input data
     $this->validate();

     // Check for existing overlapping rentals
     $existingRental = Rental::where('carNumber', $this->item['carNumber'])
         ->where(function ($query) use ($rental) {
             $query->whereBetween('safariStartDate', [$this->item['safariStartDate'], $this->item['safariEndDate']])
                 ->orWhereBetween('safariEndDate', [$this->item['safariStartDate'], $this->item['safariEndDate']])
                 ->orWhere(function ($query) use ($rental) {
                     $query->where('safariStartDate', '<=', $this->item['safariStartDate'])
                         ->where('safariEndDate', '>=', $this->item['safariEndDate']);
                 });
         })
         ->where('id', '<>', $this->rental->id) // Exclude the current rental
         ->first();

     // If no overlapping rental found, update the rental
     if (!$existingRental) {

        $this->rental->update([
             'visitorName' => $this->item['visitorName'],
             'arrivalDate' => $this->item['arrivalDate'],
             'safariStartDate' => $this->item['safariStartDate'],
             'safariEndDate' => $this->item['safariEndDate'],
             'carNumber' => $this->item['carNumber'],
             'guideName' => $this->item['guideName'],
             'specialEvent' => $this->item['specialEvent'],
         ]);

       
         $this->confirmingItemEdit = false;
         $this->car = '';
         $this->dispatch('refresh')->to('care-rental.table');
         $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
     } else {
         // Show an error message indicating overlapping rental
         $this->addError('item.safariStartDate', 'There is an overlapping rental for the selected dates.');
     }
    }

    public function render()
    {
        return view('livewire.care-rental.create');
    }

}
