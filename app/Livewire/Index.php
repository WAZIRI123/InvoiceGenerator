<?php

namespace App\Livewire;

use Livewire\Component;

class Index extends Component
{
    
    public function render()
    {
        return view('livewire.index')->layoutData(['title' => 'Admin Dashboard | School Management System']);
    }
}
