<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductBrandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_brands')->insert([
            ['description' => 'Funko'],
            ['description' => 'Nendoroid'],
            ['description' => 'Cosbaby by Hot Toys'],
            ['description' => 'Hot Toys'],
            ['description' => 'McFarlane'],
            ['description' => 'Bandai'],
            ['description' => 'Banpresto'],
            ['description' => 'Bear Brick'],
            ['description' => 'Kotobokiya'],
            ['description' => 'Iron Studios'],
            ['description' => 'Mattel'],
            ['description' => 'Hasbro'],
            ['description' => 'Lego'],
        ]);
    }
}
