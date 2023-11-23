<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSystem extends Model
{
    use HasFactory;

    protected $fillable = [ 'exam_id', 'mark_from', 'mark_to', 'remark'];

    public function exam()
    {

     return $this->belongsTo(Exam::class);

    }


}
