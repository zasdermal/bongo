<?php

namespace Module\Access\Seeders;

use Module\Access\Models\Role;
use Module\Access\Models\Permission;

use Illuminate\Database\Seeder;

class AssignPermissionRole extends Seeder
{
    public function run(): void
    {
        $editor_role = Role::where('slug', 'editor')->first();

        $readRoles = Permission::whereHas('subMenu', function ($query) {
                $query->where('slug', 'roles');
            })
            ->where('slug', 'read')
            ->first();

        $readUsers = Permission::whereHas('subMenu', function ($query) {
                $query->where('slug', 'users');
            })
            ->where('slug', 'read')
            ->first();

        $readPermissions = Permission::whereHas('subMenu', function ($query) {
                $query->where('slug', 'permissions');
            })
            ->where('slug', 'read')
            ->first();

        $editor_role->permissions()->attach([
            $readRoles->id,
            $readUsers->id,
            $readPermissions->id
        ]);
    }
}
