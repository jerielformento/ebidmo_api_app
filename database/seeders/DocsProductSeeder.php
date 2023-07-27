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
                'uri' => '/api/v1/products/all', 
                'name' => 'products.index', 
                'headers' => 'application/json', 
                'payload' => '{"category":"filter (optional)","brand":"filter (optional)"}', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get all products (randomized list of 20 items)',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products', 
                'name' => 'products.index', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'View all products for specific vendor',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/auction', 
                'name' => 'auctions.index', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'View all auctions for specific vendor',
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
                'name' => 'product.delete', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Delete product',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/product/auction', 
                'name' => 'products.delete', 
                'headers' => 'application/json', 
                'payload' => '{"name":"string","details":"text","condition":"integer","brand":"integer","quantity":"integer","images":"files"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Delete product',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/product/search/{key}', 
                'name' => 'product.search', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Product search',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/product/{store}/{product}', 
                'name' => 'product.details', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get product details',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/{store}/suggestion', 
                'name' => 'store.suggestion', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get product suggestions from store',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/{store}/{category}/similar', 
                'name' => 'product.similar', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get similar product suggestions with same category',
            ],
        ]);
    }
}
