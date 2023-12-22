<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamRule extends Model
{
    use HasFactory,SoftDeletes;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'classes_id',
        'subject_id',
        'exam_id',
        'combine_subject_id',
        'marks_distribution',
        'passing_rule',
        'total_exam_marks',
        'over_all_pass',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'classes_id');
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function combineSubject()
    {
        return $this->belongsTo(Subject::class, 'combine_subject_id'); 
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
}
