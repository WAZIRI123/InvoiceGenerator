<?php

namespace Tests\Feature;

use App\Traits\DateTime;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetFinancialStartTest extends TestCase
{
    public function test_getStartAndEndDates_with_request_params()
    {
        $start_date = Carbon::parse('2023-03-01');
        $end_date = Carbon::parse('2023-03-31');

        request()->merge([
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
        ]);

        $dateTime = new DateTime();
        $dates = $dateTime->getStartAndEndDates();

        $this->assertEquals($start_date, $dates[0]);
        $this->assertEquals($end_date, $dates[1]);
    }

    public function test_getStartAndEndDates_without_request_params()
    {
        $financial_year = Carbon::now()->startOfYear();
        $start_date = $financial_year->copy()->getStartDate();
        $end_date = $financial_year->copy()->getEndDate();

        $dateTime = new DateTime();
        $dates = $dateTime->getStartAndEndDates();

        $this->assertEquals($start_date, $dates[0]);
        $this->assertEquals($end_date, $dates[1]);
    }
}
