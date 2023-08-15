<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsUtilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('api_docs')->insert([
            [
                'router' => 'util', 
                'method' => 'GET', 
                'uri' => '/api/v1/util/user/auth/types', 
                'name' => 'auth.types', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'List of user authentication type',
            ],
            [
                'router' => 'util', 
                'method' => 'GET', 
                'uri' => '/api/v1/util/user/roles', 
                'name' => 'user.roles', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'List of user role',
            ],
            [
                'router' => 'util', 
                'method' => 'GET', 
                'uri' => '/api/v1/util/product/categories', 
                'name' => 'product.categories', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'List of product categories',
            ],
            [
                'router' => 'util', 
                'method' => 'GET', 
                'uri' => '/api/v1/util/product/brands', 
                'name' => 'product.brands', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'List of product brands',
            ],
            [
                'router' => 'util', 
                'method' => 'GET', 
                'uri' => '/api/v1/util/product/conditions', 
                'name' => 'product.conditions', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'List of product conditions',
            ],
            [
                'router' => 'util', 
                'method' => 'GET', 
                'uri' => '/api/v1/util/currencies', 
                'name' => 'product.currencies', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'List of currencies',
            ],
        ]);
    }
}
