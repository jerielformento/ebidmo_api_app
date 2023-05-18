<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            ['code' => 'PHP', 'description' => 'Philippine Peso'],
            ['code' => 'USD', 'description' => 'US Dollar'],
        ]);
    }
}
