<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admission_no',
        'date_of_birth',
        'classes_id',
        'stream_id',
        'gender_id',
        'semester_id',
        'date_of_admission',
        'is_graduate',
        'graduation_year',
        'academic_year_id',
    ];

}
