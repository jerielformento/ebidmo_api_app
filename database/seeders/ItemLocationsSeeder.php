<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemLocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('item_locations')->insert([
            ['name' => 'Metro Manila', 'country' => 1],
            ['name' => 'Cavite', 'country' => 1],
            ['name' => 'Laguna', 'country' => 1],
            ['name' => 'Davao', 'country' => 1],
            ['name' => 'Cebu', 'country' => 1],
            ['name' => 'Baguio', 'country' => 1],
            ['name' => 'Ilocos', 'country' => 1],
            ['name' => 'Bulacan', 'country' => 1],
            ['name' => 'Pampanga', 'country' => 1],
        ]);
    }
}
