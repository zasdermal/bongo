<?php

namespace Module\Access\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role_id',
        'username',
        'name',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed'
        ];
    }

    public function role() // used
    {
        return $this->belongsTo(Role::class);
    }

    public function employee() // used
    {
        return $this->hasOne(Employee::class);
    }

    public function hasPermission($menuSlug, $subMenuSlug, $action)
    {
        if ($this->role->slug === 'admin') {
            return true;
        }

        return $this->role->permissions->contains(function ($permission) use ($menuSlug, $subMenuSlug, $action) {
            return $permission->subMenu->menu->slug === $menuSlug &&
                   $permission->subMenu->slug === $subMenuSlug &&
                   $permission->slug === $action;
        });
    }
}
