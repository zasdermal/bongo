<?php

namespace Module\Market\Seeders;

use Module\Market\Models\Zone;
use Module\Market\Models\Division;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bangladesh = Zone::where('slug', 'bangladesh')->first();

        $divisions = [
            [
                'zone_id' => $bangladesh->id,
                'name' => 'Dhaka'
            ],
            [
                'zone_id' => $bangladesh->id,
                'name' => 'Barishal'
            ]
        ];

        foreach ($divisions as $division) {
            Division::create([
                'zone_id' => $division['zone_id'],
                'name' => $division['name'],
                'slug' => Str::slug($division['name'])
            ]);
        }
    }
}
