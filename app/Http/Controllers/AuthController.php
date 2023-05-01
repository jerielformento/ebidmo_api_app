<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\CustomersProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'middlename' => 'sometimes|required|nullable',
            'phone' => 'required|string',
            'email' => 'required|string|unique:customers_profile,email',
            'password' => 'required|string|confirmed',
            'role' => 'required|integer'
        ]);

        // create customer
        $customer = Customers::create([
            'username' => $fields['username'],
            'password' => Hash::make($fields['password']),
            'role' => $fields['role'],
            'auth_type' => 1,
            'is_verified' => 0,
            'remember_token' => 'asdasd',
            'registered_at' => date("Y-m-d H:i:s")
        ]);

        if($customer) {
            // create profile
            $customer_profile = CustomersProfile::create([
                'customer_id' => $customer->id,
                'email' => $fields['email'],
                'first_name' => $fields['firstname'],
                'last_name' => $fields['lastname'],
                'middle_name' => $fields['middlename'],
                'phone' => $fields['phone']
            ]); 

            if(!$customer_profile) {
                return response([
                    'message' => 'User creation failed.'
                ], 401);
            }
        } else {
            return response([
                'message' => 'User creation failed.'
            ], 401);
        }
        
        return response([
            'message' => 'Successfully registered!'
        ], 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        // create customer
        $customer = Customers::where('username', $fields['username'])->first();

        // check customer login status
        if(!$customer || !Hash::check($fields['password'], $customer->password)) {
            return response([
                'message' => 'Login failed.'
            ], 401);
        }
        
        // generate token to logged in customer
        $token = $customer->createToken('ebid-app-token')->plainTextToken;

        return response([
            'user' => $customer,
            'token' => $token
        ], 201);
    }

    public function logout(Request $request)
    {
        // delete user token
        if(!auth()->user()->tokens()->delete()) {
            return response([
                'message' => 'Invalid request.'
            ], 401);
        }

        return response([
            'message' => 'logged out.'
        ], 201);
    }
}
