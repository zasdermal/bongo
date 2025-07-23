<?php

namespace Module\Access\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function permissions() // used in role list
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class);
    // }
}
