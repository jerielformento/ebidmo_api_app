<?php

namespace App\Http\Controllers;

use App\Models\ApiDocs;
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
        $data = ApiDocs::where('router', 'authentication')->get();
        $active = 'active';
        return view('docs.main', [
            'page' => ['name' => $name, 'active' => $active],
            'result' => collect($data)
        ]);
    }

    public function customer()
    {
        $name = 'Customer';
        $data = ApiDocs::where('router', 'customer')->get();

        return view('docs.main', [
            'page' => ['name' => $name],
            'result' => collect($data)
        ]);
    }

    public function product()
    {
        $name = 'Product';
        $data = ApiDocs::where('router', 'product')->get();

        return view('docs.main', [
            'page' => ['name' => $name],
            'result' => collect($data)
        ]);
    }

    public function store()
    {
        $name = 'Store';
        $data = ApiDocs::where('router', 'store')->get();

        return view('docs.main', [
            'page' => ['name' => $name],
            'result' => collect($data)
        ]);
    }

    public function auction()
    {
        $name = 'Auction';
        $data = ApiDocs::where('router', 'auction')->get();

        return view('docs.main', [
            'page' => ['name' => $name],
            'result' => collect($data)
        ]);
    }

    public function utilities()
    {
        $name = 'Utilities';
        $data = ApiDocs::where('router', 'util')->get();

        return view('docs.main', [
            'page' => ['name' => $name],
            'result' => collect($data)
        ]);
    }

    // helper
    function get_method_status($value)
    {
        if($value === 'POST') {
            return 'primary';
        } else if($value === 'GET') {
            return 'success';
        } else if($value === 'PUT') {
            return 'warning';
        } else if($value === 'DELETE') {
            return 'danger';
        }
    }

    // helper
    function get_auth_status($value)
    {
        if($value === 'GUEST') {
            return 'primary';
        } else if($value === 'AUTH') {
            return 'success';
        } else {
            return 'info';
        }
    }
}
