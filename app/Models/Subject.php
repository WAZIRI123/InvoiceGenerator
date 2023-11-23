<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'subject_code',
        'classes_id',
        'description',
    ];

    public function class()
    {
        
return $this->belongsTo(Classes::class,'classes_id');
    }
}
