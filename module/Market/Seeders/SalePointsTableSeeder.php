<?php

namespace Module\Market\Seeders;

use Module\Market\Models\SalePoint;

use Illuminate\Database\Seeder;

class SalePointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $salePoints = [
            [
                'name' => 'Sale Point 1',
                'code_number' => '102030',
            ],
            [
                'name' => 'Sale Point 2',
                'code_number' => '102040',
            ]
        ];

        foreach ($salePoints as $salePoint) {
            SalePoint::create([
                'name' => $salePoint['name'],
                'code_number' => $salePoint['code_number']
            ]);
        }
    }
}
