<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsBidSeeder extends Seeder
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
                'uri' => '/api/v1/bids/all', 
                'name' => 'auctions.index', 
                'headers' => 'application/json', 
                'payload' => '{"category":"filter (optional)","brand":"filter (optional)"}', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get all auctions (randomized list of 16 items)',
            ],
            [
                'router' => 'bid', 
                'method' => 'GET', 
                'uri' => '/api/v1/bid', 
                'name' => 'bid.index', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'View list of customer bid products',
            ],
            [
                'router' => 'bid', 
                'method' => 'POST', 
                'uri' => '/api/v1/bid', 
                'name' => 'bid.add', 
                'headers' => 'application/json', 
                'payload' => '{"product_id":"integer","min_price":"integer","buy_now_price":"integer","currency":"string(3)"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Publish a product for bidding',
            ],
            [
                'router' => 'bid', 
                'method' => 'GET', 
                'uri' => '/api/v1/bid/{id}', 
                'name' => 'bid.show', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get specific bid product details',
            ],
            [
                'router' => 'bid', 
                'method' => 'DELETE', 
                'uri' => '/api/v1/bid/{id}', 
                'name' => 'bid.delete', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Cancel product for bidding (not finalized yet)',
            ],
            [
                'router' => 'bid', 
                'method' => 'GET', 
                'uri' => '/api/v1/bid/{store}/{product}', 
                'name' => 'auction.details', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get auction details',
            ],
            [
                'router' => 'bid', 
                'method' => 'GET', 
                'uri' => '/api/v1/bid/auction/activity/{id}', 
                'name' => 'auction.activity', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get customer auction activity',
            ],
        ]);
    }
}
