<?php

namespace Module\Market\Seeders;

use Module\Market\Models\Zone;

use Illuminate\Database\Seeder;

class ZonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $zones = [
            'Bangladesh'
        ];

        foreach ($zones as $zone) {
            $slug = strtolower(str_replace(' ', '-', $zone));
            Zone::create([
                'name' => $zone,
                'slug' => $slug
            ]);
        }
    }
}
