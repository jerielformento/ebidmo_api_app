<?php

use App\Http\Controllers\API\v1\AuctionController;
use App\Http\Controllers\API\v1\CustomerController;
use App\Http\Controllers\API\v1\PaymentController;
use App\Http\Controllers\API\v1\ProductController;
use App\Http\Controllers\API\v1\ShipmentTransactionsController;
use App\Http\Controllers\API\v1\StoreController;
use App\Http\Controllers\API\v1\VendorController;
use App\Http\Controllers\AuctionTypesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CouriersController;
use App\Http\Controllers\CurrenciesController;
use App\Http\Controllers\ItemLocationsController;
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
    Route::post('customer/buy', [CustomerController::class, 'buy']);
    Route::post('customer/bid/join', [CustomerController::class, 'joinBid']);
    Route::get('customer/auction/{id}', [AuctionController::class, 'auction']);
    Route::get('customer/auction/bid/{id}', [AuctionController::class, 'auctionBid']);
    Route::get('customer/product/{id}', [ProductController::class, 'product']);
    Route::get('customer/bid/history/{id}', [CustomerController::class, 'history']);
    Route::get('customer/transactions/bids', [CustomerController::class, 'activities']);
    Route::get('customer/transactions/wins', [CustomerController::class, 'transactions']);
    Route::get('customer/transactions/checkout/{token}', [CustomerController::class, 'checkout']);
    Route::get('customer/transactions/checkout/success/{token}', [CustomerController::class, 'checkoutSuccess']);
    Route::get('customer/billing/shipping', [CustomerController::class, 'billingInfo']);
    Route::post('customer/billing/shipping', [CustomerController::class, 'saveBillingInfo']);
    Route::get('customer/notifications/list', [CustomerController::class, 'notifications']);
    Route::put('customer/notifications/read/{id}', [CustomerController::class, 'readNotification']);

    Route::get('payment/transaction/{token}', [PaymentController::class, 'oldcheckout']);
    Route::get('payment/transaction/{token}/process', [PaymentController::class, 'checkout']);

    // Products
    Route::resource('products', ProductController::class)->except(['all','show']);
    Route::delete('products/image/{id}', [ProductController::class, 'destroyImage']);

    // Stores
    Route::resource('stores', StoreController::class)->except(['show']);
    Route::get('store/dashboard', [StoreController::class, 'dashboardReport']);
    Route::get('store/products/search/{key}', [StoreController::class, 'search']);
    Route::get('store/auctions/search/{key}', [StoreController::class, 'searchAuction']);

    // Auctions
    Route::resource('auctions', AuctionController::class)->except(['all','show','auctionDetails','activity']);
    Route::get('auction/activity/{id}', [AuctionController::class, 'activity']);
    Route::post('auctions/future', [AuctionController::class, 'storeFuture']);

    //Route::resource('vendor', VendorController::class);
    Route::get('vendor/transactions', [VendorController::class, 'transactions']);
    Route::get('vendor/shipments', [VendorController::class, 'shipments']);
    Route::get('vendor/shipments/complete', [VendorController::class, 'completeShipments']);
    Route::get('vendor/transactions/details/{token}', [VendorController::class, 'transactionInfo']);
    Route::get('vendor/transactions/report', [VendorController::class, 'transactionReport']);

    // Shipment Transactions
    Route::resource('shipments', ShipmentTransactionsController::class);
});

Route::group(['prefix'=>'v1'], function() {
    // Products
    Route::get('products/all', [ProductController::class, 'all']);
    Route::get('products/search/{key}', [ProductController::class, 'search']);
    Route::get('products/{store}/suggestion', [ProductController::class, 'suggestions']);
    Route::get('products/{store}/{product}', [ProductController::class, 'productDetails']);
    Route::get('products/{store}/{category}/similar', [ProductController::class, 'similar']);
    
    // Stores
    Route::get('stores/{slug}', [StoreController::class, 'show']);
    Route::get('stores', [StoreController::class, 'index']);
    Route::get('stores/{store}/products', [StoreController::class, 'products']);
    Route::get('stores/{store}/auctions', [StoreController::class, 'auctions']);

    // Auctions
    Route::get('auctions/all', [AuctionController::class, 'all']);
    Route::get('auctions/{store}/{product}', [AuctionController::class, 'auctionDetails'])->middleware('allow.guest');
});

// Utilities Routes
Route::group(['prefix' => 'util'], function() {
    Route::get('user/auth/types', [UserAuthTypesController::class, 'index']);
    Route::get('user/roles', [UserRolesController::class, 'index']);

    Route::get('product/conditions', [ProductConditionsController::class, 'index']);
    Route::get('product/brands', [ProductBrandsController::class, 'index']);
    Route::get('product/categories', [CategoriesController::class, 'index']);
    Route::get('product/locations', [ItemLocationsController::class, 'index']);

    Route::get('auction/types', [AuctionTypesController::class, 'index']);
    Route::get('currencies', [CurrenciesController::class, 'index']);
    Route::get('couriers', [CouriersController::class, 'index']);
});

// Public Routes - Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/authenticate', [AuthController::class, 'authRegister']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/refresh-token', [AuthController::class, 'refreshToken'])->middleware('auth:sanctum');
Route::get('/account-verification/{token}', [AuthController::class, 'accountVerification']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');