<?php

namespace App\Livewire\Invoice;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component

{
    use WithFileUploads;

    public $itemList = [];

    public $item = [];

    public $itemAmount;

    public $itemTotal;

    public function render()
    {
        return view('livewire.invoice.create')->layoutData(['title' => 'Create Invoice | School Management System']);
    }

    public function addItem()
    {
        $this->itemList[] = ['description' => '', 'quantity' => 1, 'price' => 0];
    }


    public function removeItem($index)
    {
        if (isset($this->itemList[$index])) {
            unset($this->itemList[$index]);
            unset($this->item[$index]);
            $this->calculateTotal();
        }

        
    }

    public function calculateTotal()
    {
        if (isset($this->itemList) && is_array($this->itemList) && count($this->itemList) > 0) {
            $total = [];
    
            foreach ($this->itemList as $key => $value) {
                if (
                    isset($this->item[$key]['quantity']) &&
                    isset($this->item[$key]['price'])
                ) {
                    $this->item[$key]['amount'] = $this->item[$key]['quantity'] * $this->item[$key]['price'];
                    $total[] = $this->item[$key]['amount'];
                }
            }
    
            $this->itemTotal = array_sum($total);
        } else {
            // Handle the case where itemList is not set or empty
            $this->itemTotal = 0;
        }
    }
    




    public function save()
    {
        // You can directly pass the $this->item array to the view
        if (isset($this->item['logo'])) {
            $logoPath = $this->item['logo']->store('logos', 'public'); // Store the logo in the 'public' disk under 'logos' directory
            $this->item['logo_path'] = $logoPath; // Update the path in your database model
        }
        return redirect()->route('print-Invoice', ['item' => $this->item,'itemTotal' => $this->itemTotal]);
    }
}
