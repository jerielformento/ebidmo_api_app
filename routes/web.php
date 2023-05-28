<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
/*Route::get('/login', [HomeController::class, 'login']);
Route::get('/register', [HomeController::class, 'register']);
Route::get('/store', [HomeController::class, 'store']);
Route::get('/product/details', [HomeController::class, 'productDetails']);
Route::get('/account/forgot-password', [HomeController::class, 'forgot']); */

// API Documentation
Route::group(['prefix' => 'api-docs'], function() {
    Route::any('/', [DocsController::class, 'index']);
    Route::any('auth', [DocsController::class, 'auth']);
    Route::any('customer', [DocsController::class, 'customer']);
    Route::any('product', [DocsController::class, 'product']);
    Route::any('store', [DocsController::class, 'store']);
    Route::any('bid', [DocsController::class, 'bid']);
    Route::any('utilities', [DocsController::class, 'utilities']);
});

// Admin Page
Route::get('/ebidmo-admin', [AdminController::class, 'index']);