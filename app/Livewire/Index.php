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
        $financial_year = $this->getFinancialYear();

        $start = Date::parse(request('start_date', $financial_year->copy()->getStartDate()->toDateString()))->year;
        $end = Date::parse(request('end_date', $financial_year->copy()->getEndDate()->toDateString()))->year;
     
        return view('livewire.index')->layoutData(['title' => 'Admin Dashboard | School Management System',
   'academic_year_start'=>$start,'academic_year_end'=>$end]);
    }

}