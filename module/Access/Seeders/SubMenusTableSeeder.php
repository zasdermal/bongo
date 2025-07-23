<?php

namespace Module\Access\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

use Module\Access\Models\Menu;
use Module\Access\Models\SubMenu;

class SubMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_management = Menu::where('slug', 'user-management')->first();
        $location = Menu::where('slug', 'location')->first();
        $sale_point = Menu::where('slug', 'sale-point')->first();

        $sub_menus = [
            // user management
            [
                'menu_id' => $user_management->id,
                'name' => 'Roles'
            ],
            [
                'menu_id' => $user_management->id,
                'name' => 'Users'
            ],
            [
                'menu_id' => $user_management->id,
                'name' => 'Permissions'
            ],

            // location
            [
                'menu_id' => $location->id,
                'name' => 'Zones'
            ],
            [
                'menu_id' => $location->id,
                'name' => 'Divisions'
            ],
            [
                'menu_id' => $location->id,
                'name' => 'Regions'
            ],
            [
                'menu_id' => $location->id,
                'name' => 'Areas'
            ],
            [
                'menu_id' => $location->id,
                'name' => 'Territories'
            ],

            // sale point
            [
                'menu_id' => $sale_point->id,
                'name' => 'Sale Points'
            ]
        ];

        foreach ($sub_menus as $sub_menu) {
            SubMenu::create([
                'menu_id' => $sub_menu['menu_id'],
                'name' => $sub_menu['name'],
                'slug' => Str::slug($sub_menu['name'])
            ]);
        }
    }
}
