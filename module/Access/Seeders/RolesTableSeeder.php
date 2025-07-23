<?php

namespace Module\Access\Seeders;

use Module\Access\Models\Role;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Admin',
            'Editor',
            'Employee'
        ];

        foreach ($roles as $role) {
            $slug = strtolower(str_replace(' ', '-', $role));
            Role::create([
                'name' => $role,
                'slug' => $slug
            ]);
        }
    }
}
