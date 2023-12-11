<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'classes_id',
        'status',
        'exclude_in_result'
    ];

    protected $casts = [
        'exclude_in_result' => 'bool',

      ];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function class()
    {
        
      return $this->belongsTo(Classes::class,'classes_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }
}
