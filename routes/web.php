<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FrontController;



Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::put('/profile', [FrontController::class, 'updateProfile'])->name('profile.update');

Route::get('/bouquet/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/bouquet/{category:slug}/{bouquet:slug}', [FrontController::class, 'detail'])->name('front.detail');
Route::get('/tes', function () {
    return view('front.paymentSuccess');
});

Route::middleware('auth')->group(function () {
    Route::get('/setting', [UserController::class, 'setting'])->name('profile.setting');
    Route::get('/transactions', [UserController::class, 'transactions'])->name('profile.transactions');
    // Show the profile edit form
    Route::get('/setting/profile', [UserController::class, 'edit'])->name('profile.edit');

    // Update the profile
    Route::put('/setting/profile', [UserController::class, 'update'])->name('profile.update');

    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{bouquet:id}', [CartController::class, 'cartAdd'])->name('cart.add');

    Route::post('/cart/checkout', [FrontController::class, 'checkout'])
    ->name('checkout.add')
    ->block($lockSeconds = 5, $waitSeconds = 10);

    Route::get('/cart/checkout', [FrontController::class, 'cartCheckout'])
    ->name('cart.checkout.add')
    ->block($lockSeconds = 5, $waitSeconds = 10);

    Route::delete('/cart/{bouquet:id}', [CartController::class, 'deleteCart'])->name('cart.delete');


    Route::get('/cart/quantity/add/{bouquet:id}', [CartController::class, 'addQuantity'])->name('cart.quantity.add');
    Route::get('/cart/quantity/remove/{bouquet:id}', [CartController::class, 'removeQuantity'])->name('cart.quantity.remove');


    Route::post('/cart/checkout-process', [FrontController::class, 'checkoutProcess'])->name('front.checkoutProcess');


    Route::post('/cart/cart-checkout/checkout-process', [FrontController::class, 'cartCheckoutProcess'])
    ->name('front.cart.checkoutProcess');


    // Payment routes
    Route::get('/payment/thank-you/{uniqueTrxId}', [FrontController::class, 'payment'])->name('front.payment');
    Route::patch('/payment/{uniqueTrxId}/save', [FrontController::class, 'paymentStore'])->name('front.paymentStore');
    Route::get('/payment/sucessfull', [FrontController::class, 'paymentSuccess'])->name('front.paymentSuccess');
});
