<?php

namespace App\Livewire\CareRental;

use App\Models\Rental;
use App\Exports\ReserveExports;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Table extends Component
{
    use WithPagination;

        /**
     * @var array
     */
    protected $listeners = ['refresh' => '$refresh'];
    /**
     * @var string
     */
    public $sortBy = 'id';

       /**
     * @var bool
     */
    public $sortAsc = true;

   public $per_page = 15;

   public function getResultsProperty(){
    return $this->query()
    ->with(['car'])
    ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
    ->get();
}

public function export() 
{
    return Excel::download(new ReserveExports, 'Car-Reservation.xlsx');
}
   public function render(): View
    {
        $results = $this->query()
            ->with(['car'])
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.care-rental.table', [
            'results' => $results
        ])->layoutData(['title' => 'Reservation | Car Reservation Management System']);
    }
    public function sortBy(string $field): void
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function updatingPerPage(): void
    {
        $this->resetPage();
    }

    
    public function query(): Builder
    {
        return Rental::query();
    }

    public function print(){
    
        $results=$this->results;
       
        session()->put('results',$results);

        
        return redirect()->route('sale-reports');

    }
  
}
