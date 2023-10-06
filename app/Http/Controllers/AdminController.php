<?php

namespace App\Http\Controllers;

use App\Mail\VendorApproval;
use App\Models\Customers;
use App\Models\Stores;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Throwable;

class AdminController extends Controller
{
    private $setting = [
        'page' => [
            'name' => ''
        ],
        'data' => []
    ];

    public function __construct()
    {
        if(!Auth::guard('web')->user()) {
            return redirect('/ebidmo-admin/login');
        }
    }
    public function index()
    {
        $this->setting['page']['name'] = 'Dashboard';

        if(Auth::guard('web')->user()) {
            return view('admin/home', $this->setting);
        }
        return view('admin/login', $this->setting);
    }

    public function login(Request $request)
    {
        // check customer login status
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => 
            $request->password])) {
            return redirect('/ebidmo-admin');
        } else {
            return redirect('/ebidmo-admin')->with('danger','Invalid login.');  
        }
    }

    public function customers()
    {
        $this->setting['page']['name'] = 'Customers';

        $customers = Customers::with('profile')->get();
        $this->setting['data'] = $customers;

        return view('admin/customers', $this->setting);
    }

    public function vendors()
    {
        $vendors = Stores::with('customer','verification')->get();
        $this->setting['page']['name'] = 'Vendors';
        $this->setting['data'] = $vendors;
        return view('admin/vendors', $this->setting);
    }

    public function approveStore(Request $request)
    {
        try {
            $store = Stores::where([
                'id' => (int)$request->id,
                'verified' => 0
            ])->update(['verified' => 1]);

            if($store) {
                $vendor = Stores::with('customer.profile')->where('id', $request->id)->first();
                Mail::send(new VendorApproval($vendor->customer->profile->email));
            }
        } catch(Throwable $e) {
            return response([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return response([
            'message' => 'Store application approved!'
        ], 200);
    }

    public function auctions()
    {
        $this->setting['page']['name'] = 'Auctions';
        return view('admin/auctions', $this->setting);
    }

    public function products()
    {
        $this->setting['page']['name'] = 'Products';
        return view('admin/products', $this->setting);
    }

    public function transactions()
    {
        $this->setting['page']['name'] = 'Transactions';
        return view('admin/transactions', $this->setting);
    }

    public function create()
    {
        User::create([
            'email' => 'jerielformento@gmail.com',
            'password' => Hash::make('passw0rd'),
            'name' => 'Jeriel Formento',
            'email_verified_at' => date("Y-m-d H:i:s")
        ]);
    }

    public function logout() 
    {
        Auth::guard('web')->logout();
        return redirect('/ebidmo-admin');
    }
}
