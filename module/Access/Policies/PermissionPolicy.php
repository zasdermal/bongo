<?php

namespace Module\Access\Policies;

use Module\Access\Models\User;

class PermissionPolicy
{
    public function read(User $user): bool
    {
        return $user->hasPermission('user-management', 'permissions', 'read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('user-management', 'permissions', 'create');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('user-management', 'permissions', 'update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission('user-management', 'permissions', 'delete');
    }
}
