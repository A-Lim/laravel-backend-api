<?php

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

Route::get('/', 'HomeController@index');
Route::get('privacy-policy', 'HomeController@privacy_policy');
Route::post('contact-us', 'HomeController@contact_us');

Route::namespace('Cart')->group(function () {
    Route::get('cart', 'CartController@details');
    Route::post('cart', 'CartController@add');
    Route::delete('cart', 'CartController@remove');
});

Route::namespace('Order')->group(function () {
    Route::get('order/fail', 'OrderController@fail');
    Route::get('order/details', 'OrderController@view');
    Route::get('order/{refNo}', 'OrderController@details');
    Route::get('order/{refNo}/thankyou', 'OrderController@order_submitted');

    Route::get('order/pay/{refNo}', 'OrderController@payment');
    Route::get('order/requirement/{refNo}', 'OrderController@requirement');
    

    Route::post('order', 'OrderController@store');
    Route::post('order/requirement', 'OrderController@submit_requirement');
});

Route::namespace('Payment')->group(function () {
    // Route::get('payment/paypal/pay', function () {
    //     dd("OK");
    // });
    Route::get('payment/paypal/status', 'PaypalController@status');
    Route::post('payment/paypal/pay', 'PaypalController@charge');

    Route::get('payment/stripe/integration', 'StripeController@integration');
    Route::post('payment/stripe/pay', 'StripeController@charge');
});
