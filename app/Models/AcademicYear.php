<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year',
        'start_date',
        'end_date',
        'status',
    ];

public static function  checkUserAcademicYear(){
        // Check the current PHP year
$currentYear = date('Y');

// Get the current academic year from the database
$currentAcademicYear = AcademicYear::where('status', 'active')->first();

if ($currentAcademicYear) {
    // Check if the current academic year is behind the current PHP year
    $academicYearStartYear = (int) substr($currentAcademicYear->academic_year, 0, 4);

    if ($academicYearStartYear < $currentYear) {
        // Check if the user has a preference to set the academic year to a previous one
        // You should implement a way for users to specify this preference
        $userPreviousAcademicYear = 1; // You should fetch this from user preferences

        if (!$userPreviousAcademicYear ) {
            self::createNewAcademicYear();
        }
        else {
            $userPreviousAcademicYear =AcademicYear::find($userPreviousAcademicYear );
            $currentAcademicYear->status='inactive';
            $userPreviousAcademicYear->status='active';
            $userPreviousAcademicYear->save();
            $currentAcademicYear->save();

        }
    }
}
}
}
