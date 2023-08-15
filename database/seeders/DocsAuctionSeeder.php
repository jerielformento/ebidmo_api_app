<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsAuctionSeeder extends Seeder
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
                'router' => 'auction', 
                'method' => 'GET', 
                'uri' => '/api/v1/auctions/all', 
                'name' => 'auctions.index', 
                'headers' => 'application/json',
                'query' => '?category=&brand[]=',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get all auctions (randomized list of 16 items)',
            ],
            [
                'router' => 'auction', 
                'method' => 'GET', 
                'uri' => '/api/v1/auctions', 
                'name' => 'auctions.index', 
                'headers' => 'application/json',
                'query' => '?page=',
                'payload' => '', 
                'response' => '{"current_page":1,"data":[],"first_page_url":"products?page=1","from":1,"last_page":1,"last_page_url":"products?page=1","links":[{"url":null,"label":"&laquo; Previous","active":false},{"url":"products?page=1","label":"1","active":true},{"url":null,"label":"Next &raquo;","active":false}],"next_page_url":null,"path":"products","per_page":10,"prev_page_url":null,"to":1,"total":1}',
                'auth_type' => 'AUTH',
                'description' => 'View list of customer auction items',
            ],
            [
                'router' => 'auction', 
                'method' => 'POST', 
                'uri' => '/api/v1/auctions', 
                'name' => 'auctions.add', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '{"product_id":"integer","min_price":"integer","buy_now_price":"integer","currency":"string(3)"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Publish a product for bidding',
            ],
            [
                'router' => 'auction', 
                'method' => 'GET', 
                'uri' => '/api/v1/auctions/{id}', 
                'name' => 'auctions.show', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get specific bid product details',
            ],
            [
                'router' => 'auction', 
                'method' => 'DELETE', 
                'uri' => '/api/v1/auctions/{id}', 
                'name' => 'auctions.delete', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Cancel product for bidding (not finalized yet)',
            ],
            [
                'router' => 'auction', 
                'method' => 'GET', 
                'uri' => '/api/v1/auctions/{store}/{product}', 
                'name' => 'auction.details', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'ALL',
                'description' => 'Get auction details',
            ],
            [
                'router' => 'auction', 
                'method' => 'GET', 
                'uri' => '/api/v1/auction/activity/{id}', 
                'name' => 'auction.activity', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get customer auction activity',
            ],
        ]);
    }
}
