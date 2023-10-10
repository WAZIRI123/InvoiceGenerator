<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Index;
use App\Traits\DateTime;
use App\Utilities\Date;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    public function test_getFinancialYear_future_year_if_year_is_future()
    {
        $component = new Index();

        $financial_year =$component->getFinancialYear('2024-02-29');

        $start =  $financial_year->copy()->getStartDate()->toDateString();
   
        $end =  $financial_year->copy()->getEndDate()->toDateString();

        $this->assertEquals( "2024-02-29",  $start);
    }

    public function test_getFinancialYear_returns_current_financial_year()
    {
        $component = new Index();

        $financial_year =$component->getFinancialYear();

        $current_year = Date::now()->startOfYear()->year;

        $start =  $financial_year->copy()->getStartDate()->year;

        $this->assertEquals( $current_year,  $start);
    }
}
