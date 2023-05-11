<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Authenticated Route
Route::group([
    'prefix' => 'v1', 
    'namespace' => 'App\Http\Controllers\API\v1',
    'middleware' => ['auth:sanctum']
], function() {
    Route::apiResource('customers', CustomersController::class);
    Route::apiResource('products', ProductsController::class);
    Route::apiResource('stores', StoresController::class);
    Route::apiResource('bids', BidsController::class);
    
    Route::post('customer/bid', [CustomerController::class, 'bid']);
});

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');