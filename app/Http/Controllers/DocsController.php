<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocsController extends Controller
{
    
    public function index()
    {
        $name = 'Home';
        return view('docs.home', ['page' => ['name' => $name]]);
    }

    public function auth()
    {
        $name = 'Authentication';
        $active = 'active';
        return view('docs.auth', ['page' => ['name' => $name, 'active' => $active]]);
    }

    public function customer()
    {
        $name = 'Customer';
        return view('docs.customer', ['page' => ['name' => $name]]);
    }

    public function product()
    {
        $name = 'Product';
        return view('docs.product', ['page' => ['name' => $name]]);
    }

    public function store()
    {
        $name = 'Store';
        return view('docs.store', ['page' => ['name' => $name]]);
    }

    public function bid()
    {
        $name = 'Bid';
        return view('docs.bid', ['page' => ['name' => $name]]);
    }

    public function utilities()
    {
        $name = 'Utilities';
        return view('docs.utilities', ['page' => ['name' => $name]]);
    }
}
