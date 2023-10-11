<?php

use App\Traits\DateTime;

use App\Utilities\Date;

use Illuminate\Support\Facades\Storage;

if (! function_exists('user')) {
    /**
     * Get the authenticated user.
     *
     * @return \App\Models\Auth\User
     */
    function user()
    {
        return auth()->user();
    }
}

if (! function_exists('getFinancialYear')) {

 
 
    function getFinancialYear($startDate = null, $endDate = null)
    {
        $date_time = new class() { use DateTime; };
        $financial_year = $date_time->getFinancialYear();

        $start = Date::parse(request('start_date', $financial_year->copy()->getStartDate()->toDateString()))->year;
        $end = Date::parse(request('end_date', $financial_year->copy()->getEndDate()->toDateString()))->year;

       // Return start and end years as an array
       return ['start' => $start, 'end' => $end];
    }
}
