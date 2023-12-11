<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'classes_id',
        'name',
        'marks_distribution_types',
        'status',
        'open_for_marks_entry'
    ];

    protected $casts = [
        'open_for_marks_entry' => 'bool',

      ];

    
    public function class()
    {
        return $this->belongsTo(Classes::class,'classes_id');
    }

    public function scopeIclass($query, $classId)
    {
        if($classId){
            return $query->where('classes_id', $classId);
        }

        return $query;
    }

    public function marks()
    {
        return $this->hasMany(Mark::class, 'exam_id');

    }

    public function result()
    {
        return $this->hasMany(Result::class);

    }

}
