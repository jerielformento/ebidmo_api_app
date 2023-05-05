<?php

namespace Database\Seeders;

use App\Models\Stores;
use Database\Factories\StoresFactory;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Stores::factory()->count(5)->create();
    }
}
