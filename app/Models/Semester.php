<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name','classes_id','description','start_date','end_date'];

    public function class()
    {
    return $this->belongsTo(Classes::class);
    }

    public function subjects()
    {
    return $this->belongsToMany(Subject::class);
    }
}
