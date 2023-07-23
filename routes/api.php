<?php

use App\Http\Controllers\API\v1\BidController;
use App\Http\Controllers\API\v1\CustomerController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\StoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
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
    Route::post('customer/bid/join', [CustomerController::class, 'joinBid']);
    Route::get('customer/auction/{id}', [BidController::class, 'auction']);
    Route::get('customer/auction/bid/{id}', [BidController::class, 'auctionBid']);
    Route::get('customer/product/{id}', [ProductController::class, 'product']);
    Route::get('customer/bid/history/{id}', [CustomerController::class, 'history']);
    

    // Products
    Route::resource('product', ProductController::class)->except(['index', 'show']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/auction', [ProductController::class, 'indexAuction']);
    
    Route::get('product/store/search/{key}', [ProductController::class, 'storeSearch']);
    Route::get('auction/store/search/{key}', [ProductController::class, 'storeSearchAuction']);
    
    Route::delete('product/image/remove/{id}', [ProductController::class, 'destroyImage']);

    // Vendor
    Route::resource('store', StoreController::class)->except(['index','show']);
    Route::get('store/dashboard', [StoreController::class, 'dashboardReport']);

    // Bid
    Route::apiResource('bid', BidController::class)->except(['index','show']);
    
    Route::get('bids', [BidController::class, 'index']);
    Route::get('bid/auction/activity/{id}', [BidController::class, 'activity']);
});

Route::group(['prefix'=>'v1'], function() {
    Route::get('products/all', [ProductController::class, 'all']);
    Route::get('bids/all', [BidController::class, 'all']);

    Route::get('product/search/{key}', [ProductController::class, 'search']);
    Route::get('product/{store}/{product}', [ProductController::class, 'productDetails']);
    Route::get('products/{store}/suggestion', [ProductController::class, 'suggestions']);
    Route::get('products/{store}/{category}/similar', [ProductController::class, 'similar']);
    
    Route::get('store/{slug}', [StoreController::class, 'show']);
    Route::get('stores', [StoreController::class, 'index']);
    Route::get('store/{store}/products', [StoreController::class, 'products']);
    Route::get('store/{store}/auctions', [StoreController::class, 'auctions']);
    Route::get('bid/{store}/{product}', [BidController::class, 'auctionDetails'])->middleware('allow.guest');
});

// Utilities Routes
Route::group(['prefix' => 'util'], function() {
    Route::get('user/auth/types', [UserAuthTypesController::class, 'index']);
    Route::get('user/roles', [UserRolesController::class, 'index']);
    Route::get('product/conditions', [ProductConditionsController::class, 'index']);
    Route::get('product/brands', [ProductBrandsController::class, 'index']);
    Route::get('product/categories', [CategoriesController::class, 'index']);
    Route::get('currencies', [CurrenciesController::class, 'index']);
});

// Public Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/account-verification/{token}', [AuthController::class, 'accountVerification']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


