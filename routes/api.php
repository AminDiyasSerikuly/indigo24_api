<?php

use Illuminate\Http\Request;

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

Route::prefix('/user')->group(function () {
    Route::post('/login', 'api\LoginController@login')->name('login');
    Route::post('products/buy', 'api\ProductController@buy')->middleware('auth:api');
    Route::get('/products', 'api\ProductController@show')->middleware('auth:api');
    Route::get('products/payment-history', 'api\ProductController@payment_history')->middleware('auth:api');
});



