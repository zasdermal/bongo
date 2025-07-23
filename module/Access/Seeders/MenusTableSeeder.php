<?php

namespace Module\Access\Seeders;

use Module\Access\Models\Menu;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            'User Management',
            'Location',
            'Sale Point'
        ];

        foreach ($menus as $menu) {
            $slug = strtolower(str_replace(' ', '-', $menu));
            Menu::create([
                'name' => $menu,
                'slug' => $slug
            ]);
        }
    }
}
