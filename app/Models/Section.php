<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'capacity',
        'classes_id',
        'teacher_id',
        'note',
        'status',
    ];


    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }

    public function marks()
    {
        return $this->hasMany(Mark::class);
    }

    public function student()
    {
        return $this->hasMany(Student::class);
    }

}
