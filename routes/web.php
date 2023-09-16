<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Mail\AccountVerification;
use App\Mail\WinnerAcknowledgement;
use App\Models\Auctions;
use App\Models\Customers;
use App\Models\CustomersProfile;
use App\Models\PaymentTransactions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    Route::any('auction', [DocsController::class, 'auction']);
    Route::any('utilities', [DocsController::class, 'utilities']);
});

// Admin Page
Route::get('/ebidmo-admin', [AdminController::class, 'index']);
Route::get('/email', function() {
    Mail::send(new AccountVerification('clash.jeriel@gmail.com', 'd7b40169fd728af8fcb6eb4091580032'));
});

Route::post('/payment-webhook', function(Request $request) {
    try {
        PaymentTransactions::create([
            'payment_id' => $request->payment_id,
            'payment_request_id' => $request->payment_request_id,
            'phone' => $request->phone,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => $request->status,
            'reference_number' => $request->reference_number,
            'hmac' => $request->hmac
        ]);
    } catch(Throwable $e) {
        return response()->json([
            'message' => $e->getMessage()
        ], 301);
    }
    
    return response()->json([
        'message' => 'Success'
    ], 201);
});

Route::get('/linkstorage', function () {
    $targetFolder = base_path().'/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder, $linkFolder);
});