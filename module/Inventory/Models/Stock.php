<?php

namespace Module\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'sku',
        'quantity',
        'mrp'
    ];
}
