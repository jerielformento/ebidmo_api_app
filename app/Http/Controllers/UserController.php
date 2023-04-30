<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ResponseTrait;
    //
    public function index()
    {
        echo "ok";
    }

    public function unauthenticated()
    {
       echo "Unauthorized";
    }
}
