<?php
namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     // return view('welcome');
//     return view('front.index');
// })2;

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Front
Route::name('front.')->group(function() {
    Route::prefix('user')->name('user.')->group(function() {
        Route::middleware('guest:web', 'PreventBackHistory')->group(function() {
            // Route::view('/login', 'front.auth.login')->name('login');
            // Route::view('/register', 'front.auth.register')->name('register');
            Route::get('/login', [AuthController::class, 'login'])->name('login');
            Route::get('/register', [AuthController::class, 'register'])->name('register');
            Route::post('/create', [AuthController::class, 'create'])->name('create');
            Route::post('/check', [AuthController::class, 'check'])->name('check');
            // Route::post('/check/mobile', [AuthController::class, 'checkMobile'])->name('check.mobile');
        });

        Route::middleware('auth:web', 'PreventBackHistory')->group(function() {
            // profile
            Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::view('/profile/edit', 'front.profile.edit')->name('profile.edit');
            Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

            // password
            Route::view('/password/edit', 'front.profile.password')->name('password.edit');
            Route::post('/password/update', [ProfileController::class, 'update'])->name('password.update');

            // order
            Route::get('/order', [ProfileController::class, 'order'])->name('order');
            Route::get('/order/{id}', [ProfileController::class, 'orderDetail'])->name('order.detail');

            // address
            Route::get('/address', [ProfileController::class, 'address'])->name('address');
            Route::post('/address/store', [ProfileController::class, 'addressStore'])->name('address.store');
            Route::get('/address/edit/{id}', [ProfileController::class, 'addressedit'])->name('address.edit');
            Route::get('/address/update/{id}', [ProfileController::class, 'addressUpdate'])->name('address.update');
            Route::get('/address/delete/{id}', [ProfileController::class, 'addressdelete'])->name('address.delete');

            Route::get('/wishlist', [ProfileController::class, 'wishlist'])->name('wishlist');
        });
    });

    Route::view('/', 'front.index')->name('home');

    // product
    // Route::prefix('product')->name('product.')->group(function() {
    //     Route::get('/{slug}', [ProductController::class, 'detail'])->name('detail');
    // });

    // cart
    Route::prefix('cart')->name('cart.')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::get('{id}/remove', [CartController::class, 'remove'])->name('remove');
        Route::get('{id}/save', [CartController::class, 'save'])->name('save');
        Route::post('quantity', [CartController::class, 'quantity'])->name('quantity');
    });

    // address
    Route::prefix('address')->name('address.')->group(function() {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::post('/store', [AddressController::class, 'store'])->name('store');
    });

    // checkout
    Route::prefix('checkout')->name('checkout.')->group(function() {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/order/place', [CheckoutController::class, 'order'])->name('order.place');
        // Route::get('/confirm', [CheckoutController::class, 'confirm'])->name('confirm');
        // Route::get('/failure', [CheckoutController::class, 'failure'])->name('failure');
    });

    // payment
    // Route::prefix('payment')->name('payment.')->group(function() {
    //     Route::get('/', [CheckoutController::class, 'index'])->name('index');
    //     Route::post('/order/place', [CheckoutController::class, 'order'])->name('order.place');
    // });

    // coming soon
    Route::view('/coming-soon', 'front.static.coming-soon')->name('coming.soon');

    // product
    Route::name('product.')->group(function() {
        Route::get('{slug}', [ProductController::class, 'detail'])->name('detail');
        Route::get('{slug}/product-reviews', [ReviewController::class, 'index'])->name('detail.review.list');
        Route::get('{slug}/write-review', [ReviewController::class, 'create'])->name('detail.review.create');
        Route::post('/review/post', [ReviewController::class, 'store'])->name('detail.review.post');
    });
});

// Admin
Route::prefix('admin')->group(function() {
    require 'custom/admin.php';
});