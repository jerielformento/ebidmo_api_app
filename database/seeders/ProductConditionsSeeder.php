<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductConditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_conditions')->insert([
            ['description' => 'Brand new'],
            ['description' => 'Fair'],
            ['description' => 'Used'],
        ]);
    }
}
