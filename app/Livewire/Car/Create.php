<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;

class Create extends Component

{
    public $item=[];

     /**
     * @var array
     */

     protected function rules()
     {
        $carId = $this->car ? $this->car->id : null; // Get the current car ID being edited
    
        return [
            'item.name' => 'required',
            'item.CarNumber' => [
                'required',
                Rule::unique('cars', 'car_number')
                    ->ignore($carId) // Ignore the current car ID
                    ->whereNull('deleted_at')
            ],
        ];

    }

       /**
     * @var array
     */
    protected $validationAttributes = [
        'item.name' => 'name',
        'item.CarNumber' => 'Car Number',
    ];

    /**
     * @var bool
     */
    public $confirmingItemDeletion = false;

    public $car;

        /**
     * @var bool
     */
    public $confirmingItemCreation = false;

     /**
     * @var bool
     */
    public $confirmingItemEdit = false;


    public function render()
    {
        return view('livewire.car.create');
    }

    #[On('showDeleteForm')]
    public function showDeleteForm(Car $car): void
    {
       
        $this->confirmingItemDeletion = true;

        $this->car = $car;
    }

    public function deleteItem(Car $car): void
    {
        $this->car->delete();
        $this->confirmingItemDeletion = false;
        $this->car = '';
        $this->reset(['item']);
        $this->dispatch('refresh')->to('car.table');
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


        $this->validate();
         $car = Car::create([
            'name' => $this->item['name'],
            'car_number' => $this->item['CarNumber']
        ]);
        $this->confirmingItemCreation = false;
        $this->dispatch('refresh')->to('car.table');
        $this->dispatch('show', 'Record Added Successfully')->to('livewire-toast');
    }

    #[On('showEditForm')]
    public function showEditForm(Car $car): void
    {
       
        $this->resetErrorBag();
        $this->car= $car;
        $this->item['name']=$car->name;
        $this->item['CarNumber']=$car->car_number;
        $this->confirmingItemEdit = true;
    }

    public function editItem(Car $car): void
    {
        $this->validate();
         $this->car->update([
            'name' => $this->item['name'],
            'car_number' => $this->item['CarNumber']
        ]);

        $this->confirmingItemEdit = false;
        $this->car = '';
        $this->dispatch('refresh')->to('car.table');
        $this->dispatch('show', 'Record Updated Successfully')->to('livewire-toast');
    }

}
