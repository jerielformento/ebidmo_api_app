<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\Customers;
use App\Models\CustomersProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request)
    {
        // create customer
        $customer = Customers::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'auth_type' => 1,
            'is_verified' => 0,
            'remember_token' => 'asdasd',
            'registered_at' => date("Y-m-d H:i:s")
        ]);

        if($customer) {
            // create profile
            $customer_profile = CustomersProfile::create([
                'customer_id' => $customer->id,
                'email' => $request->email,
                'first_name' => $request->firstname,
                'last_name' => $request->lastname,
                'middle_name' => $request->middlename,
                'phone' => $request->phone
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

    public function login(AuthLoginRequest $request)
    {
        // create customer
        $customer = Customers::where('username', $request->username)->first();

        // check customer login status
        if(!$customer || !Hash::check($request->password, $customer->password)) {
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

    public function mapping()
    {
        redirect('map');
    }

}
