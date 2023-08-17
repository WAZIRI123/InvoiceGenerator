<?php

namespace App\Livewire\Car;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

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

    /**
     * @var int
     */

     public $per_page = 15;

    public function render()
    {
        $results = $this->query()
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
        ->paginate($this->per_page);

    return view('livewire.car.table', [
        'results' => $results
    ])->layoutData(['title' => 'Car | Car Reservation Management System']);
       
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
        return Car::query();
    }



}
