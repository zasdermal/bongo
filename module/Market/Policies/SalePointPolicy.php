<?php

namespace Module\Market\Policies;

use Module\Access\Models\User;

class SalePointPolicy
{
    public function read(User $user): bool
    {
        return $user->hasPermission('sale-point', 'sale-points', 'read');
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('sale-point', 'sale-points', 'create');
    }

    public function update(User $user): bool
    {
        return $user->hasPermission('sale-point', 'sale-points', 'update');
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission('sale-point', 'sale-points', 'delete');
    }
}
