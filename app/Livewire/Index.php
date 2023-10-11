<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Employee;
use App\Models\Rental;
use App\Traits\DateTime;
use Livewire\Component;
use App\Utilities\Date;

use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, DateTime;


    public $totalCars;


    public $Reservations;
    
    public $latestReservations;

    public function render()
    {
    
     
        return view('livewire.index')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }

}