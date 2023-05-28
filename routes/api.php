<?php

use App\Http\Controllers\API\v1\BidController;
use App\Http\Controllers\API\v1\CustomerController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\Api\v1\StoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\ProductBrandsController;
use App\Http\Controllers\ProductConditionsController;
use App\Http\Controllers\UserAuthTypesController;
use App\Http\Controllers\UserRolesController;
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

// Authenticated Route
Route::group([
    'prefix' => 'v1', 
    'middleware' => ['auth:sanctum']
], function() {
    // Customers
    Route::resource('customer', CustomerController::class);
    Route::post('customer/bid', [CustomerController::class, 'bid']);
    Route::get('customer/auction/create/{id}', [BidController::class, 'showAuction']);
    Route::get('customer/bid/history/{id}', [CustomerController::class, 'history']);

    // Products
    Route::resource('product', ProductController::class)->except(['index']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/all', [ProductController::class, 'all']);

    // Vendor
    Route::resource('store', StoreController::class)->except(['index']);
    Route::get('stores', [StoreController::class, 'index']);

    // Bid
    Route::apiResource('bid', BidController::class)->except(['index']);
    Route::get('bids', [BidController::class, 'index']);
});

// Utilities Routes
Route::group(['prefix' => 'util'], function() {
    Route::get('user/auth/types', [UserAuthTypesController::class, 'index']);
    Route::get('user/roles', [UserRolesController::class, 'index']);
    Route::get('product/conditions', [ProductConditionsController::class, 'index'])->middleware('auth:sanctum');
    Route::get('product/brands', [ProductBrandsController::class, 'index'])->middleware('auth:sanctum');
    Route::get('currencies', [CurrenciesController::class, 'index']);
});

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


