<?php

namespace Module\Market\Seeders;

use Module\Market\Models\Area;
use Module\Market\Models\Territory;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class TerritoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rangpur = Area::where('slug', 'rangpur')->first();
        $rajshahi = Area::where('slug', 'rajshahi')->first();
        $thakurgaon = Area::where('slug', 'thakurgaon')->first();
        $dinajpur = Area::where('slug', 'dinajpur')->first();
        $bogura = Area::where('slug', 'bogura')->first();
        $khulna = Area::where('slug', 'khulna')->first();
        $barishal = Area::where('slug', 'barishal')->first();
        $chuadanga = Area::where('slug', 'chuadanga')->first();
        $dhaka = Area::where('slug', 'dhaka')->first();
        $jamalpur = Area::where('slug', 'jamalpur')->first();
        $cumilla = Area::where('slug', 'cumilla')->first();

        $territories = [
            [
                'area_id' => $rangpur->id,
                'name' => 'Mithapukur'
            ],
            [
                'area_id' => $rangpur->id,
                'name' => 'Nilphamari'
            ],
            [
                'area_id' => $rajshahi->id,
                'name' => 'Natore'
            ],
            [
                'area_id' => $rajshahi->id,
                'name' => 'Tanore'
            ],
            [
                'area_id' => $thakurgaon->id,
                'name' => 'Thakurgaon'
            ],
            [
                'area_id' => $thakurgaon->id,
                'name' => 'Panchagarh'
            ],
            [
                'area_id' => $dinajpur->id,
                'name' => 'Birol'
            ],
            [
                'area_id' => $dinajpur->id,
                'name' => 'Dinajpur'
            ],
            [
                'area_id' => $dinajpur->id,
                'name' => 'Birgonj'
            ],
            [
                'area_id' => $bogura->id,
                'name' => 'Bogura'
            ],
            [
                'area_id' => $bogura->id,
                'name' => 'Joypurhat'
            ],
            [
                'area_id' => $bogura->id,
                'name' => 'Ghoraghat'
            ],
            [
                'area_id' => $bogura->id,
                'name' => 'Rangpur'
            ],
            [
                'area_id' => $khulna->id,
                'name' => 'Faridpur'
            ],
            [
                'area_id' => $khulna->id,
                'name' => 'Khulna'
            ],
            [
                'area_id' => $khulna->id,
                'name' => 'Gopalgonj'
            ],
            [
                'area_id' => $khulna->id,
                'name' => 'Monirumpur'
            ],
            [
                'area_id' => $khulna->id,
                'name' => 'Jessore'
            ],
            [
                'area_id' => $barishal->id,
                'name' => 'Barishal'
            ],
            [
                'area_id' => $barishal->id,
                'name' => 'Amtoli'
            ],
            [
                'area_id' => $barishal->id,
                'name' => 'Bhola'
            ],
            [
                'area_id' => $chuadanga->id,
                'name' => 'Meherpur'
            ],
            [
                'area_id' => $chuadanga->id,
                'name' => 'Jhenaidah'
            ],
            [
                'area_id' => $chuadanga->id,
                'name' => 'Kushtia'
            ],
            [
                'area_id' => $chuadanga->id,
                'name' => 'Chuadanga'
            ],
            [
                'area_id' => $dhaka->id,
                'name' => 'Manikgonj'
            ],
            [
                'area_id' => $dhaka->id,
                'name' => 'Dhaka'
            ],
            [
                'area_id' => $jamalpur->id,
                'name' => 'Jamalpur'
            ],
            [
                'area_id' => $jamalpur->id,
                'name' => 'Sorisabari'
            ],
            [
                'area_id' => $jamalpur->id,
                'name' => 'Kishorgonj'
            ],
            [
                'area_id' => $cumilla->id,
                'name' => 'Cumilla'
            ],
            [
                'area_id' => $cumilla->id,
                'name' => 'Chittagong'
            ],
            [
                'area_id' => $cumilla->id,
                'name' => 'Brahmanbaria'
            ]
        ];

        foreach ($territories as $territorie) {
            Territory::create([
                'area_id' => $territorie['area_id'],
                'name' => $territorie['name'],
                'slug' => Str::slug($territorie['name'])
            ]);
        }
    }
}
