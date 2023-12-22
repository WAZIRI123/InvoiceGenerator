<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'registration_no',
        'date_of_employment',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function classes(){
        return $this->belongsToMany(Classes::class);
    }

    public function subjects(){
        return $this->belongsToMany(Teacher::class);
    }
}
