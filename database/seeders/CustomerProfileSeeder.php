<?php

namespace Database\Seeders;

use App\Models\CustomersProfile;
use Illuminate\Database\Seeder;

class CustomerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomersProfile::factory()->count(10)->create();
    }
}
