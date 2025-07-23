<?php

namespace Module\Market\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Module\Access\Models\Employee;
use Module\Access\Models\User;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'division_id',
        'name',
        'slug',
        'description',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function division() // used
    {
        return $this->belongsTo(Division::class);
    }

    // public function employee()
    // {
    //     return $this->hasOne(Employee::class);
    // }


}
