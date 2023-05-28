<?php

namespace App\Http\Controllers;

use App\Http\Requests\v1\AuthLoginRequest;
use App\Http\Requests\v1\AuthRegisterRequest;
use App\Models\Customers;
use App\Models\CustomersProfile;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request)
    {
        // create customer
        $customer = Customers::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 1,
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
        //$customer = Customers::where('username', $request->username)->first();

        $remember_me  = $request->remember;

        // check customer login status
        if (Auth::guard('customer')->attempt(['username' => $request->username, 'password' => 
            $request->password])) {
            $customer = Customers::with('profile:customer_id,first_name,last_name')->where('username', $request->username)->first();
            Auth::guard('customer')->login($customer, $request->remember);
        } else {
            return response([
                'message' => 'Login failed.'
            ], 401);
        }

        /*if(!$customer || !Hash::check($request->password, $customer->password)) {
            return response([
                'message' => 'Login failed.'
            ], 401);
        }*/
        
        // generate token to logged in customer
        $token = $customer->createToken('ebid-app-token')->plainTextToken;

        return response([
            'user' => [
                'username' => $customer->username,
                'firstname' => $customer->profile->first_name,
                'lastname' => $customer->profile->first_name,
                'fullname' => $customer->profile->first_name.' '.$customer->profile->last_name
            ],
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
        return view('map');
    }

}
