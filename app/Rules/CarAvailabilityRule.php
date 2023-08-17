<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use App\Models\Rental;

class CarAvailabilityRule implements Rule
{
    public function passes($attribute, $value)
    {
       
        $carNumber = request()->input('item.carNumber');
        $startDate = Carbon::parse(request()->input('item.safariStartDate'))->toDateTimeString();
        $endDate = Carbon::parse(request()->input('item.safariEndDate'))->toDateTimeString();

        $existingRental = Rental::where('carNumber', $carNumber)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('safariStartDate', [$startDate, $endDate])
                    ->orWhereBetween('safariEndDate', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('safariStartDate', '<=', $startDate)
                            ->where('safariEndDate', '>=', $endDate);
                    });
            })
            ->where('id', '<>', request()->input('rental.id', 0)) // Exclude current rental when editing
            ->first();
          
            dd($existingRental);
        return !$existingRental;
    }

    public function message()
    {
        return 'The selected car is already reserved for the specified date range.';
    }
}
