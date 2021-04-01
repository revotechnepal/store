<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\PosSalesController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\ProductSoldController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('foodproducts', [ProductController::class, 'foodproducts'])->name('foodproducts');
Route::resource('products', ProductController::class);
Route::resource('possales', PosSalesController::class);
Route::resource('productsold', ProductSoldController::class);
Route::resource('customer', CustomerController::class);
