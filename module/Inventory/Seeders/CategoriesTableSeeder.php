<?php

namespace Module\Inventory\Seeders;

use Module\Inventory\Models\Category;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fertilizer',
            'Pesticide',
            'Seed'
        ];

        foreach ($categories as $category) {
            $slug = strtolower(str_replace(' ', '-', $category));
            Category::create([
                'name' => $category,
                'slug' => $slug
            ]);
        }
    }
}
