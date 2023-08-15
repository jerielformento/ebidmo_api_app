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
                'query' => '?category=&brand[]=',
                'payload' => '', 
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
                'query' => '?page=',
                'payload' => '', 
                'response' => '{"current_page":1,"data":[],"first_page_url":"products?page=1","from":1,"last_page":1,"last_page_url":"products?page=1","links":[{"url":null,"label":"&laquo; Previous","active":false},{"url":"products?page=1","label":"1","active":true},{"url":null,"label":"Next &raquo;","active":false}],"next_page_url":null,"path":"products","per_page":10,"prev_page_url":null,"to":1,"total":1}',
                'auth_type' => 'AUTH',
                'description' => 'View all products for specific vendor',
            ],
            [
                'router' => 'product', 
                'method' => 'POST', 
                'uri' => '/api/v1/products', 
                'name' => 'products.store', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '{"name":"string","details":"text","condition":"integer","brand":"integer","quantity":"integer","images":"files"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Add new product',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/{id}', 
                'name' => 'products.show', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get product details',
            ],
            [
                'router' => 'product', 
                'method' => 'PUT', 
                'uri' => '/api/v1/products/{id}', 
                'name' => 'products.update', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '{"name":"string","details":"text","condition":"integer","brand":"integer","quantity":"integer","images":"files"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Update product information',
            ],
            [
                'router' => 'product', 
                'method' => 'DELETE', 
                'uri' => '/api/v1/products/{id}', 
                'name' => 'product.delete', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Delete product',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/search/{key}', 
                'name' => 'product.search', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Product search',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/{store}/{product}', 
                'name' => 'product.details', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get product details',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/{store}/suggestion', 
                'name' => 'products.store.suggestion', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get product suggestions from store',
            ],
            [
                'router' => 'product', 
                'method' => 'GET', 
                'uri' => '/api/v1/products/{store}/{category}/similar', 
                'name' => 'products.store.category.similar', 
                'headers' => 'application/json', 
                'query' => '',
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get similar product suggestions with same category',
            ],
        ]);
    }
}
