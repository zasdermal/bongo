<?php

namespace Module\Market\Policies;

use Module\Access\Models\User;

class ZonePolicy
{
    public function read(User $user): bool
    {
        return $user->hasPermission('location', 'zones', 'read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('location', 'zones', 'create');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('location', 'zones', 'update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission('location', 'zones', 'delete');
    }
}
