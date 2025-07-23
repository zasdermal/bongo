<?php

namespace Module\Market\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Module\Access\Models\User;

class Division extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'zone_id',
        'name',
        'slug',
        'description',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function zone() // used
    {
        return $this->belongsTo(Zone::class);
    }
}
