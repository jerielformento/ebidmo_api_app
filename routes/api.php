<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\ProductBrandsController;
use App\Http\Controllers\ProductConditionsController;
use App\Http\Controllers\UserAuthTypesController;
use App\Http\Controllers\UserRolesController;
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

// Authenticated Route
Route::group([
    'prefix' => 'v1', 
    'namespace' => 'App\Http\Controllers\API\v1',
    'middleware' => ['auth:sanctum']
], function() {
    Route::apiResource('customer', CustomerController::class);
    Route::apiResource('product', ProductController::class);
    Route::apiResource('store', StoreController::class);
    Route::apiResource('bid', BidController::class);
    
    Route::post('customer/bid', [CustomerController::class, 'bid']);
});

// Utilities Routes
Route::group(['prefix' => 'utilities'], function() {
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


