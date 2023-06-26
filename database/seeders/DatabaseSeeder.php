<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserAuthTypesSeeder::class,
            UserRolesSeeder::class,
            ProductConditionsSeeder::class,
            ProductBrandsSeeder::class,
            BidStatusSeeder::class,
            CurrenciesSeeder::class,
            CategoriesSeeder::class
        ]);
    }
}
