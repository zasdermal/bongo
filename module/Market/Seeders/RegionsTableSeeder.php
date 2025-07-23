<?php

namespace Module\Market\Seeders;

use Module\Market\Models\Region;
use Module\Market\Models\Division;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $dhaka = Division::where('slug', 'dhaka')->first();
        // $barishal = Division::where('slug', 'barishal')->first();

        $regions = [
            [
                // 'division_id' => $dhaka->id,
                'name' => 'North'
            ],
            [
                // 'division_id' => $dhaka->id,
                'name' => 'South'
            ],
            [
                // 'division_id' => $barishal->id,
                'name' => 'East'
            ],
            [
                // 'division_id' => $barishal->id,
                'name' => 'West'
            ],
        ];

        foreach ($regions as $region) {
            Region::create([
                // 'division_id' => $region['division_id'],
                'name' => $region['name'],
                'slug' => Str::slug($region['name'])
            ]);
        }
    }
}
