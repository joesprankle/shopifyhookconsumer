<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class linetable extends Model
{
    protected $table = 'shopifyfulfillment';
    protected $fillable = [
        'id',
        'order_id',
        'order_created_at',
        'product_id',
        'title',
        'quantity',
        'price',
        'fulfillable_quantity',
    ];
}


