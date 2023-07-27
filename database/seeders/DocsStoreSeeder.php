<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsStoreSeeder extends Seeder
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
                'router' => 'store', 
                'method' => 'GET', 
                'uri' => '/api/v1/stores', 
                'name' => 'store.index', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'View list of store',
            ],
            [
                'router' => 'store', 
                'method' => 'POST', 
                'uri' => '/api/v1/store', 
                'name' => 'store.add', 
                'headers' => 'application/json', 
                'payload' => '{"store_name":"string"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Create own store',
            ],
            [
                'router' => 'store', 
                'method' => 'GET', 
                'uri' => '/api/v1/store/{id}', 
                'name' => 'store.show', 
                'headers' => 'application/json', 
                'payload' => '{"customer_id":"integer"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get other customer store details',
            ],
            [
                'router' => 'store', 
                'method' => 'PUT', 
                'uri' => '/api/v1/store/{id}', 
                'name' => 'store.update', 
                'headers' => 'application/json', 
                'payload' => '{"store_name":"string"}', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Update own store information',
            ],
            [
                'router' => 'store', 
                'method' => 'DELETE', 
                'uri' => '/api/v1/store/{id}', 
                'name' => 'store.delete', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Deactivate store (not finalized yet)',
            ],
            [
                'router' => 'store', 
                'method' => 'GET', 
                'uri' => '/api/v1/store/dashboard', 
                'name' => 'store.dashboard', 
                'headers' => 'application/json', 
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Get store dashboard details',
            ],
            
        ]);
    }
}
