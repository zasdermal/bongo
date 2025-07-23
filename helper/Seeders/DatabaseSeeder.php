<?php

namespace Helper\Seeders;

use Illuminate\Database\Seeder;

use Module\Access\Seeders\RolesTableSeeder;
use Module\Access\Seeders\UsersTableSeeder;
use Module\Access\Seeders\MenusTableSeeder;
use Module\Access\Seeders\SubMenusTableSeeder;
use Module\Access\Seeders\AssignPermissionRole;
use Module\Access\Seeders\PermissionsTableSeeder;
use Module\Access\Seeders\DesignationsTableSeeder;

use Module\Inventory\Seeders\ProductsTableSeeder;
use Module\Inventory\Seeders\CategoriesTableSeeder;
use Module\Inventory\Seeders\SubCategoriesTableSeeder;

use Module\Market\Seeders\AreasTableSeeder;
use Module\Market\Seeders\ZonesTableSeeder;
use Module\Market\Seeders\RegionsTableSeeder;
use Module\Market\Seeders\DivisionsTableSeeder;
use Module\Market\Seeders\SalePointsTableSeeder;
use Module\Market\Seeders\TerritoriesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DesignationsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(SubMenusTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AssignPermissionRole::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ZonesTableSeeder::class);
        $this->call(DivisionsTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(TerritoriesTableSeeder::class);
        // $this->call(SalePointsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SubCategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
    }
}
