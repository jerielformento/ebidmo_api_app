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
Route::get('/products', [HomeController::class, 'view']);
Route::any('/api-docs', [DocsController::class, 'index']);
Route::any('/api-docs/auth', [DocsController::class, 'auth']);
Route::any('/api-docs/customer', [DocsController::class, 'customer']);
Route::any('/api-docs/product', [DocsController::class, 'product']);
Route::any('/api-docs/store', [DocsController::class, 'store']);
Route::any('/api-docs/bid', [DocsController::class, 'bid']);
Route::any('/api-docs/utilities', [DocsController::class, 'utilities']);

Route::get('/ebidmo-admin', [AdminController::class, 'index']);