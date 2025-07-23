<?php

namespace Module\Market\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalePoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'territory_id',
        'name',
        'code_number',
        'address',
        'contact_name',
        'contact_number',
        // 'pharmacy_type',
        // 'payment_type',
        // 'credit_limit',
        // 'credit_duration',
        // 'sell_discount_type',
        // 'sell_discount',
        // 'lat_lng',
        'is_active'
    ];

    public function territory() // used
    {
        return $this->belongsTo(Territory::class);
    }
}
