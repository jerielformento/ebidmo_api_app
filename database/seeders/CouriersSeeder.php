<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CouriersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('couriers')->insert([
            ['name' => 'Lalamove'],
            ['name' => 'J&T Express'],
            ['name' => 'LBC Express'],
        ]);
    }
}
