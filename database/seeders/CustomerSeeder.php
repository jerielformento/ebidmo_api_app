<?php

namespace Database\Seeders;

use App\Models\Customers;
use App\Models\CustomersProfile;
use App\Models\Products;
use App\Models\Stores;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = Customers::factory()
                    ->hasProfile()
                    ->create();

        Stores::factory()->hasProducts(2)->create([
            'customer_id' => $customer->id
        ]);
    }
}
