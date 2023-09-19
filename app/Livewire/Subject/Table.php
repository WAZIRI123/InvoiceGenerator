<?php

namespace App\Livewire\Subject;

use App\Models\Subject; // Import the Subject model
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class Table extends Component
{
    use WithPagination;

    protected $listeners = ['refresh' => '$refresh'];
    public $sortBy = 'id';
    public $sortAsc = true;
    public $per_page = 15;

    public function mount(): void
    {
    }

    public function render(): View
    {
        $results = $this->query()
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC')
            ->paginate($this->per_page);

        return view('livewire.subject.table', [
            'results' => $results
        ])->layoutData(['title' => 'Subject | School Management System']);
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
        return Subject::query(); // Update to use the Subject model
    }
}
