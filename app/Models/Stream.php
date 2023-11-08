<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stream extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'classes_id',
    ];

    public function class()
    {
return $this->belongsTo(Classes::class,'classes_id');
    }
}
