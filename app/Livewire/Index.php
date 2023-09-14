<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Employee;
use App\Models\Rental;
use Livewire\Component;

use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;



    public $totalCars;


    public $Reservations;
    
    public $latestReservations;

    public function render()
    {
      
     
        return view('livewire.index')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }

}