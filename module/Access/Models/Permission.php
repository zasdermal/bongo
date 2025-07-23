<?php

namespace Module\Access\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_menu_id',
        'name',
        'slug',
        'description'
    ];

    public function subMenu() // used in parmission, role list
    {
        return $this->belongsTo(SubMenu::class);
    }

    public function roles() // used in parmission list
    {
        return $this->belongsToMany(Role::class);
    }
}
