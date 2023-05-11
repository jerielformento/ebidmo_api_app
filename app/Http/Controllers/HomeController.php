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

    public function view()
    {
        $products = Products::with('images:product_id,filename,url,mime_type,size')
        ->get(['id','name','slug','details','quantity','brand','condition','created_at']);
        return view('products', ['products' => $products]);
    }
}
