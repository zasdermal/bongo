<?php

namespace Module\Market\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Module\Access\Models\User;
use Module\Access\Models\Employee;

class Zone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'is_active'
    ];

    public function user() // used
    {
        return $this->belongsTo(User::class);
    }

    public function division()
    {
        return $this->hasOne(Division::class);
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
