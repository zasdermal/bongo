<?php

namespace Module\Access\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    public function permissions() // used in role list
    {
        return $this->hasMany(Permission::class);
    }

    public function menu() // used in role list
    {
        return $this->belongsTo(Menu::class);
    }
}
