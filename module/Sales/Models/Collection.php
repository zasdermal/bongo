<?php

namespace Module\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Module\Access\Models\User;

class Collection extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_invoice_id',
        'user_id',
        'status',
        'collection_amount',
        'addi_dis_amount',
        'ait',
        'partial_paid',
        'full_paid',
        'return_amount',
        'due',
        // 'money_receipt_status'
    ];

    public function orderInvoice()
    {
        return $this->belongsTo(OrderInvoice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
