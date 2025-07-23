<?php

namespace Module\Access\Seeders;

use Module\Access\Models\Designation;

use Illuminate\Database\Seeder;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $designations = [
            'Managing Director',
            'Human Resources Manager',
            'Human Resources Assistant',
            'Sells Manager', // zone
            'Divisional Manager', // division
            'Regional Manager', // region
            'Area Sells Manager', // area
            'Marketing Officer', // territory
        ];

        foreach ($designations as $designation) {
            $slug = strtolower(str_replace(' ', '-', $designation));
            Designation::create([
                'name' => $designation,
                'slug' => $slug
            ]);
        }
    }
}
