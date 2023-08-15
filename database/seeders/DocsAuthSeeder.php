<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocsAuthSeeder extends Seeder
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
                'router' => 'authentication', 
                'method' => 'POST', 
                'uri' => '/api/register', 
                'name' => 'auth.register', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '{"username":"string","email":"email","password":"string","password_confirmation":"string","role":"integer","firstname":"string","lastname":"string","middlename":"string","phone":"number"}', 
                'response' => '',
                'auth_type' => 'GUEST',
                'description' => 'Customer registration',
            ],
            [
                'router' => 'authentication', 
                'method' => 'POST', 
                'uri' => '/api/login', 
                'name' => 'auth.login', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '{"username":"string","password":"string"}', 
                'response' => '{"user":"object","token":"string"}',
                'auth_type' => 'GUEST',
                'description' => 'Login',
            ],
            [
                'router' => 'authentication', 
                'method' => 'POST', 
                'uri' => '/api/logout', 
                'name' => 'auth.logout', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'AUTH',
                'description' => 'Logout user',
            ],
            [
                'router' => 'authentication', 
                'method' => 'GET', 
                'uri' => '/api/account-verification/{token}', 
                'name' => 'user.verification', 
                'headers' => 'application/json',
                'query' => '',  
                'payload' => '', 
                'response' => '',
                'auth_type' => 'GUEST',
                'description' => 'User email verification after registration',
            ],
        ]);
    }
}
