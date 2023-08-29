<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['title' => 'Anime'],
            ['title' => 'Marvel'],
            ['title' => 'DC'],
            ['title' => 'Disney'],
            ['title' => 'Star Wars'],
            ['title' => 'Transformer'],
            ['title' => 'Ninja Turtle'],
            ['title' => 'Exclusives'],
            ['title' => 'New Arrival'],
            ['title' => 'Others'],
        ]);
    }
}
