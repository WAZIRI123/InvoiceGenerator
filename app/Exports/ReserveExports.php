<?php 
namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReserveExports implements FromCollection
{
    public function collection()
    {
        return Rental::all();
    }
}