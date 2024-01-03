<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'start_date',
        'end_date',
        'status',
        'is_open_for_admission'
    ];

public static function  checkUserAcademicYear(){
        // Check the current PHP year
     
$currentYear = Carbon::createFromFormat('d/m/Y', '31/12/'.date('Y'));

// Get the current academic year from the database
$currentAcademicYear = AcademicYear::where('status', '1')->orWhere('start_date', $currentYear)->orWhere('end_date', $currentYear)->first();



if (!$currentAcademicYear) {

    
  $data['title'] = date('Y');
  $data['start_date'] = Carbon::createFromFormat('d/m/Y', '01/01/'.date('Y'));
  $data['end_date'] = Carbon::createFromFormat('d/m/Y', '31/12/'.date('Y'));
  $data['status'] = '1';

  return  $currentAcademicYear=AcademicYear::create($data)->combined_dates;

}else{


    return  $currentAcademicYear->combined_dates;
}

}

public function getCombinedDatesAttribute()
{
    return $this->start_date . ' - ' . $this->end_date;
}

}
