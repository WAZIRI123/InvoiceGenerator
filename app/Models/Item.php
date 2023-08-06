<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use  HasFactory;

    protected $table = 'items';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name', 'description', 'sale_price', 'purchase_price', 'category_id', 'quantity','enabled'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sale_price'        => 'double',
        'purchase_price'    => 'double',
        'enabled'           => 'boolean',
        'deleted_at'        => 'datetime',
    ];

}
