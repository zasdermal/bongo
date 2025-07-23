<?php

namespace Module\Market\Seeders;

use Module\Market\Models\Area;
use Module\Market\Models\Region;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $north = Region::where('slug', 'north')->first();
        $south = Region::where('slug', 'south')->first();
        $east = Region::where('slug', 'east')->first();
        $west = Region::where('slug', 'west')->first();

        $areas = [
            [
                'region_id' => $north->id,
                'name' => 'Rangpur'
            ],
            [
                'region_id' => $north->id,
                'name' => 'Rajshahi'
            ],
            [
                'region_id' => $north->id,
                'name' => 'Thakurgaon'
            ],
            [
                'region_id' => $north->id,
                'name' => 'Dinajpur'
            ],
            [
                'region_id' => $north->id,
                'name' => 'Bogura'
            ],
            [
                'region_id' => $south->id,
                'name' => 'Khulna'
            ],
            [
                'region_id' => $south->id,
                'name' => 'Barishal'
            ],
            [
                'region_id' => $west->id,
                'name' => 'Chuadanga'
            ],
            [
                'region_id' => $west->id,
                'name' => 'Dhaka'
            ],
            [
                'region_id' => $east->id,
                'name' => 'Jamalpur'
            ],
            [
                'region_id' => $east->id,
                'name' => 'Cumilla'
            ]
        ];

        foreach ($areas as $area) {
            Area::create([
                'region_id' => $area['region_id'],
                'name' => $area['name'],
                'slug' => Str::slug($area['name'])
            ]);
        }
    }
}
