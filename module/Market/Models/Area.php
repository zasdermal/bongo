<?php

namespace Module\Market\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Module\Access\Models\User;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'region_id',
        'name',
        'slug',
        'description',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function region() // used
    {
        return $this->belongsTo(Region::class);
    }

    // public function employees()
    // {
    //     return $this->belongsToMany(Employee::class);
    // }

    // public function sub_areas()
    // {
    //     return $this->hasMany(SubArea::class);
    // }
}
