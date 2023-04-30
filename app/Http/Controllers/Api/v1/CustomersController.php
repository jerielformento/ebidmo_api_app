<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customers;

class CustomersController extends Controller
{
    //
    public function index()
    {
        return Customers::all();
    }
}
