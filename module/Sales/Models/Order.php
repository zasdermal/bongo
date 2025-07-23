<?php

namespace Module\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Module\Inventory\Models\Stock;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_id',
        'order_number',
        'product_name',
        'sku',
        'quantity',
        'unit_price',
        'return_qty',
        'total_amount'
    ];

    public function orderInvoices()
    {
        return $this->belongsToMany(OrderInvoice::class);
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }
}
