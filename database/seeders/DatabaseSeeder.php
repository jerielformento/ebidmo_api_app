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
           /*  UserAuthTypesSeeder::class,
            UserRolesSeeder::class,
            ProductConditionsSeeder::class,
            ProductBrandsSeeder::class,
            AuctionStatusSeeder::class,
            CurrenciesSeeder::class,
            CategoriesSeeder::class, */
            // Docs
            DocsAuthSeeder::class,
            DocsCustomerSeeder::class,
            DocsAuctionSeeder::class,
            DocsProductSeeder::class,
            DocsStoreSeeder::class,
            DocsUtilSeeder::class,
        ]);
    }
}
