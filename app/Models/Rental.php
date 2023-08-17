<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'visitorName',
        'arrivalDate',
        'safariStartDate',
        'safariEndDate',
        'carNumber',
        'guideName',
        'specialEvent',
    ];

    protected $dates = [
        'arrivalDate',
        'safariStartDate',
        'safariEndDate',
    ];
    
    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
