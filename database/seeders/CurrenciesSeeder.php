<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            ['code' => 'PHP', 'description' => 'Philippine Peso', 'prefix' => '₱'],
            ['code' => 'USD', 'description' => 'US Dollar', 'prefix' => '$'],
        ]);
    }
}
