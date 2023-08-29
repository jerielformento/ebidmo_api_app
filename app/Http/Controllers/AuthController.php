<?php

namespace App\Http\Controllers;

use App\Http\Requests\v1\AuthLoginRequest;
use App\Http\Requests\v1\AuthRegisterRequest;
use App\Mail\AccountVerification;
use App\Models\Customers;
use App\Models\CustomersProfile;
use App\Models\Stores;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session as FacadesSession;
use PhpParser\ErrorHandler\Throwing;
use Throwable;

class AuthController extends Controller
{

    public function register(AuthRegisterRequest $request)
    {
        // create verification token for email
        $verif_token = md5($request->username.Carbon::now()->timestamp);

        // create customer
        $customer = Customers::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 1,
            'auth_type' => 1,
            'is_verified' => 0,
            'verification_token' => $verif_token,
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
            } else {
                try {
                    Mail::send(new AccountVerification($request->email, $verif_token));
                } catch(Throwable $e) {
                    return response([
                        'message' => $e->getMessage()
                    ], 401);
                }
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

    public function authRegister(Request $request)
    {
        $check_exist = Customers::with('profile:customer_id,first_name,last_name')
            ->where('username', $request->username)
            ->where('is_verified', 1)
            ->first();

        // check customer login status
        if (!$check_exist) {
            // create verification token for email
            $verif_token = md5($request->username.Carbon::now()->timestamp);

            // create customer
            $customer = Customers::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => 1,
                'auth_type' => 2,
                'is_verified' => 1,
                'verification_token' => $verif_token,
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
                } else {
                    try {
                        Mail::send(new AccountVerification($request->email, $verif_token));
                    } catch(Throwable $e) {
                        return response([
                            'message' => $e->getMessage()
                        ], 401);
                    }
                }
            } else {
                return response([
                    'message' => 'User creation failed.'
                ], 401);
            }
            
            /* return response([
                'message' => 'Successfully registered!'
            ], 201); */
        }

        try {
            $customer = Customers::with(['profile:customer_id,first_name,last_name,email','store'])
            ->where('username', $request->username)
            ->where('is_verified', 1)
            ->first();

            Auth::guard('customer')->login($customer, $request->remember);
        } catch(Throwable $e) {
            return response([
                'message' => $e->getMessage()
            ], 401);
        }
        
        // generate token to logged in customer
        $token = $customer->createToken('ebid-app-token')->plainTextToken;

        return response([
            'user' => [
                'username' => $customer->username,
                'firstname' => $customer->profile->first_name,
                'lastname' => $customer->profile->first_name,
                'fullname' => $customer->profile->first_name.' '.$customer->profile->last_name,
                'email' => $customer->profile->email,
                'store_name' => ($customer->store ? $customer->store->name : '')
            ],
            'token' => $token
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
            try {
                $customer = Customers::with(['profile:customer_id,first_name,last_name,email','store'])
                ->where('username', $request->username)
                ->where('is_verified', 1)
                ->first();

                Auth::guard('customer')->login($customer, $request->remember);
            } catch(Throwable $e) {
                return response([
                    'message' => 'Login failed.'
                ], 401);
            }
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
                'fullname' => $customer->profile->first_name.' '.$customer->profile->last_name,
                'email' => $customer->profile->email,
                'store_name' => ($customer->store ? $customer->store->name : '')
            ],
            'token' => $token
        ], 201);
    }

    public function accountVerification($token)
    {
        try {
            $customer = Customers::where('is_verified', 0)->where('verification_token', $token)->firstOrFail(['id']);
            if($customer) {
                Customers::where('id', $customer->id)->update(['is_verified' => 1]);
                return view('emails.account_verify_success');
            }
        } catch(Throwable $e) {
            return view('emails.account_verify_error');
        }
    }

    public function logout(Request $request)
    {
        // delete user token
        if(Auth::guard('customer')->check()) {
            FacadesSession::flush();
            Auth::guard('customer')->logout();
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
