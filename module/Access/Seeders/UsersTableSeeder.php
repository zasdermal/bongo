<?php

namespace Module\Access\Seeders;

use Module\Access\Models\Role;
use Module\Access\Models\User;
use Module\Access\Models\Employee;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $role_admin = Role::where('slug', 'admin')->first();
        $role_editor = Role::where('slug', 'editor')->first();
        $role_employee = Role::where('slug', 'employee')->first();

        $users = [
            [
                'role_id' => $role_admin->id,
                'username' => 'eusufahamed',
                'name' => 'Eusuf Ahamed',
                'password' => Hash::make('123456')
            ],
            [
                'role_id' => $role_editor->id,
                'username' => 'shuvo',
                'name' => 'Shuvo',
                'password' => Hash::make('123456')
            ],
            [
                'role_id' => $role_employee->id,
                'username' => 'arif',
                'name' => 'Arif',
                'password' => Hash::make('123456')
            ]
        ];

        foreach ($users as $user) {
            $user = User::create([
                'role_id' => $user['role_id'],
                'username' => $user['username'],
                'name' => $user['name'],
                'password' => $user['password']
            ]);

            Employee::create([
                'user_id' => $user->id
            ]);
        }
    }
}
