<?php

namespace Module\Access\Seeders;

use Module\Access\Models\SubMenu;
use Module\Access\Models\Permission;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run(): void
    {
        // user management
        $roles = SubMenu::where('slug', 'roles')->first();
        $users = SubMenu::where('slug', 'users')->first();
        $permissions = SubMenu::where('slug', 'permissions')->first();
        // location
        $zones = SubMenu::where('slug', 'zones')->first();
        $divisions = SubMenu::where('slug', 'divisions')->first();
        $regions = SubMenu::where('slug', 'regions')->first();
        $areas = SubMenu::where('slug', 'areas')->first();
        $territories = SubMenu::where('slug', 'territories')->first();
        // sale point
        $sale_points = SubMenu::where('slug', 'sale-points')->first();

        $permissions = [
            [
                'sub_menu_id' => $roles->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $roles->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $roles->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $roles->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $users->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $users->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $users->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $users->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $permissions->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $permissions->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $permissions->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $permissions->id,
                'name' => 'Delete',
            ],
            
            [
                'sub_menu_id' => $zones->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $zones->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $zones->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $zones->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $divisions->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $divisions->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $divisions->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $divisions->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $regions->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $regions->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $regions->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $regions->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $areas->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $areas->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $areas->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $areas->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $territories->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $territories->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $territories->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $territories->id,
                'name' => 'Delete',
            ],

            [
                'sub_menu_id' => $sale_points->id,
                'name' => 'Create',
            ],
            [
                'sub_menu_id' => $sale_points->id,
                'name' => 'Read',
            ],
            [
                'sub_menu_id' => $sale_points->id,
                'name' => 'Update',
            ],
            [
                'sub_menu_id' => $sale_points->id,
                'name' => 'Delete',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'sub_menu_id' => $permission['sub_menu_id'],
                'name' => $permission['name'],
                'slug' => Str::slug($permission['name'])
            ]);
        }
    }
}
