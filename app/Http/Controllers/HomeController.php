<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {
        return view('welcome');
    }
    
}
