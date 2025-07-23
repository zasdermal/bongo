<?php

namespace Module\Access\Policies;

use Module\Access\Models\User;

class RolePolicy
{
    public function read(User $user): bool
    {
        return $user->hasPermission('user-management', 'roles', 'read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('user-management', 'roles', 'create');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('user-management', 'roles', 'update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission('user-management', 'roles', 'delete');
    }
}
