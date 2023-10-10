<?php

namespace App\Traits;

use App\Utilities\Date;
use Carbon\CarbonPeriod;

trait DateTime
{
    
    public function getStartAndEndDates($year = null): array
    {
        if (request()->filled('start_date') && request()->filled('end_date')) {
            $start = Date::parse(request('start_date'))->startOfDay();
            $end = Date::parse(request('end_date'))->endOfDay();
        } else {
            $financial_year = $this->getFinancialYear($year);

            $start = $financial_year->copy()->getStartDate();
            $end = $financial_year->copy()->getEndDate();
        }

        return [$start, $end];
    }

    public function getFinancialStart($year = null): Date
    {
        $start_of_year = Date::now()->startOfYear();
        $start_date = request()->filled('start_date') ? Date::parse(request('start_date')) : null;

        $setting = explode('-', setting('localisation.financial_start'));

        $day = ! empty($setting[0]) ? $setting[0] : (! empty($start_date) ? $start_date->day : $start_of_year->day);
        $month = ! empty($setting[1]) ? $setting[1] : (! empty($start_date) ? $start_date->month : $start_of_year->month);
        $year = $year ?? (! empty($start_date) ? $start_date->year : $start_of_year->year);

        $financial_start = Date::create($year, $month, $day);

       

        return $financial_start;
    }

 

   
    public function getFinancialYear($year = null): CarbonPeriod
    {
        $financial_start = $this->getFinancialStart($year);

        return CarbonPeriod::create($financial_start, $financial_start->copy()->addYear()->subDay()->endOfDay());
    }

  
}