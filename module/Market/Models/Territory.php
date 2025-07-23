<?php

namespace Module\Market\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Module\Access\Models\User;

class Territory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'area_id',
        'name',
        'slug',
        'description',
        'is_active'
    ];

    public function user() // used
    {
        return $this->belongsTo(User::class);
    }

    public function area() // used
    {
        return $this->belongsTo(Area::class);
    }

    // public function employee()
    // {
    //     return $this->hasOne(Employee::class);
    // }

    // public function doctors()
    // {
    //     return $this->belongsToMany(Doctor::class);
    // }
}
