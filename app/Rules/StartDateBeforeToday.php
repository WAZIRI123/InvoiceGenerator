<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StartDateBeforeToday implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!(Carbon::parse($value)->isToday() || Carbon::parse($value)->isFuture())){

            $fail('The :attribute must be a date that is today or in the future.');

        }
         // Check if the 'start_date' is a valid date and is before today.
         

    }
}
