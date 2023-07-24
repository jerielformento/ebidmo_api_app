<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsCustomerSeeder extends Seeder
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
                'router' => 'customer', 
                'method' => 'GET', 
                'uri' => '/api/v1/customer', 
                'name' => 'customer.index', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'View customers',
            ],
            [
                'router' => 'customer', 
                'method' => 'GET', 
                'uri' => '/api/v1/customer/{id}', 
                'name' => 'customer.show', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get customer details',
            ],
            [
                'router' => 'customer', 
                'method' => 'PUT', 
                'uri' => '/api/v1/customer/{id}', 
                'name' => 'customer.update', 
                'headers' => 'application/json', 
                'payload' => '{"email":"email","firstname":"string","lastname":"string","middlename":"string","phone":"number","password":"string","password_confirmation":"string"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Update customer information',
            ],
            [
                'router' => 'customer', 
                'method' => 'DELETE', 
                'uri' => '/api/v1/customer/{id}', 
                'name' => 'customer.delete', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Update customer information',
            ],
            [
                'router' => 'customer', 
                'method' => 'POST', 
                'uri' => '/api/v1/customer/bid', 
                'name' => 'customer.bid', 
                'headers' => 'application/json', 
                'payload' => '{"bid_id":"integer","price":"integer"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Customer bid',
            ],
            [
                'router' => 'customer', 
                'method' => 'POST', 
                'uri' => '/api/v1/customer/auction/{product_slug}', 
                'name' => 'auction.bid', 
                'headers' => 'application/json', 
                'payload' => '{"bid_id":"integer","price":"integer"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get vendor auction item details',
            ],
            [
                'router' => 'customer', 
                'method' => 'POST', 
                'uri' => '/api/v1/customer/bid/history/{customer_id}', 
                'name' => 'customer.bid.history', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get customer bid history for specific auction item',
            ],
        ]);
    }
}
