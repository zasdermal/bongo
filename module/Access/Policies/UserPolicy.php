<?php

namespace Module\Access\Policies;

use Module\Access\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function read(User $user): bool
    {
        return $user->hasPermission('user-management', 'users', 'read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('user-management', 'users', 'create');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('user-management', 'users', 'update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission('user-management', 'users', 'delete');
    }
}
