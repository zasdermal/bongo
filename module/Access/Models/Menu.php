<?php

namespace Module\Access\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function subMenus() // used in role list
    {
        return $this->hasMany(SubMenu::class);
    }
}
