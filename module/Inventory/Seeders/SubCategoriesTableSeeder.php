<?php

namespace Module\Inventory\Seeders;

use Module\Inventory\Models\Category;
use Module\Inventory\Models\SubCategory;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class SubCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fertilizer = Category::where('slug', 'fertilizer')->first();
        $pesticide = Category::where('slug', 'pesticide')->first();
        $seed = Category::where('slug', 'seed')->first();

        $subCategories = [
            [
                'category_id' => $fertilizer->id,
                'name' => 'Boric Acid'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Humic Gold Plus'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Bongo Mag'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Root Grow'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Solubor Boron'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Bongo Zinc'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Zypsum'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Sakura Gold'
            ],
            [
                'category_id' => $fertilizer->id,
                'name' => 'Tonic'
            ],

            [
                'category_id' => $pesticide->id,
                'name' => 'Bongo Shot'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Cipro'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Imo'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Karmo'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Mestra'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Pairaits'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Rafyel'
            ],
            [
                'category_id' => $pesticide->id,
                'name' => 'Strip'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Bitter Gourd'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Okra'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Bottle Gourd'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Chili'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Pumpkin'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Cucumber'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Snack Gourd'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Ridge Gourd'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Sponge Gourd'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Watermealon'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Brinjal'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Radish'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'KnolKhol'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Tometo'
            ],
            [
                'category_id' => $seed->id,
                'name' => 'Cauliflower'
            ],
        ];

        foreach ($subCategories as $subCategory) {
            SubCategory::create([
                'category_id' => $subCategory['category_id'],
                'name' => $subCategory['name'],
                'slug' => Str::slug($subCategory['name'])
            ]);
        }
    }
}
