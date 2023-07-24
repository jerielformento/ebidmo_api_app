<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsProductSeeder extends Seeder
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
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products', 
                'name' => 'products.index', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'View all products (store owner)',
            ],
            [
                'router' => 'product', 
                'method' => 'POST', 
                'uri' => '/api/v1/product', 
                'name' => 'products.store', 
                'headers' => 'application/json', 
                'payload' => '{"name":"string","details":"text","condition":"integer","brand":"integer","quantity":"integer","images":"files"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Add new product',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/product/{id}', 
                'name' => 'products.show', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get product details',
            ],
            [
                'router' => 'product', 
                'method' => 'PUT', 
                'uri' => '/api/v1/product/{id}', 
                'name' => 'products.update', 
                'headers' => 'application/json', 
                'payload' => '{"name":"string","details":"text","condition":"integer","brand":"integer","quantity":"integer","images":"files"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Update product information',
            ],
            [
                'router' => 'product', 
                'method' => 'DELETE', 
                'uri' => '/api/v1/product/{id}', 
                'name' => 'products.delete', 
                'headers' => 'application/json', 
                'payload' => '{"name":"string","details":"text","condition":"integer","brand":"integer","quantity":"integer","images":"files"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Delete product',
            ],
        ]);
    }
}
