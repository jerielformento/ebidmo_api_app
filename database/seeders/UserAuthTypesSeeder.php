<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAuthTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_auth_types')->insert([
            ['description' => 'Registered'],
            ['description' => 'OAuth'],
        ]);
    }
}
