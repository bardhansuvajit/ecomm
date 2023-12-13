<?php
namespace App\Http\Controllers\Api;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// login
Route::name('api.')->group(function() {
    Route::prefix('user')->name('user.')->group(function() {
        Route::middleware('guest:web', 'PreventBackHistory')->group(function() {
            // user
            // Route::view('/login', 'front.auth.login')->name('login');
            // Route::view('/register', 'front.auth.register')->name('register');
            Route::post('/create', [AuthController::class, 'create'])->name('create');
            Route::post('/check', [AuthController::class, 'check'])->name('check');
            Route::post('/check/mobile', [AuthController::class, 'checkMobile'])->name('check.mobile');
        });
    });
});

// currency update
Route::get('/currency/update/{currencyId}', [CurrencyController::class, 'update'])->name('currency.update');

// pincode
Route::get('/pincode/status', [PincodeController::class, 'status'])->name('pincode.status');
Route::post('/pincode/store', [PincodeController::class, 'store'])->name('pincode.store');

// coupon
Route::get('/coupon/status', [CouponController::class, 'status'])->name('coupon.status');
Route::get('/coupon/remove', [CouponController::class, 'remove'])->name('coupon.remove');

// address
Route::post('address/store', [AddressController::class, 'store'])->name('address.store');
Route::post('address/default', [AddressController::class, 'default'])->name('address.default');
Route::post('address/detail', [AddressController::class, 'detail'])->name('address.detail');
Route::post('address/update', [AddressController::class, 'update'])->name('address.update');

// cart
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/', [CartController::class, 'index'])->name('cart.index');

// wishlist
Route::post('wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// review interact
Route::post('review/interact', [ReviewController::class, 'check'])->name('review.toggle');

// country
Route::get('/country/detail/{id}', [CountryController::class, 'detail'])->name('country.detail');

// state
Route::get('/state/detail/{id}', [StateController::class, 'detail'])->name('state.detail');

// product
Route::post('product/fetch', [ProductController::class, 'fetch'])->name('product.featured.fetch');
Route::post('product/add', [ProductController::class, 'add'])->name('product.featured.add');

// blog
Route::post('blog/fetch', [BlogController::class, 'fetch'])->name('blog.featured.fetch');
Route::post('blog/add', [BlogController::class, 'add'])->name('blog.featured.add');

// guest cart
// Route::post('guest/cart/add', [GuestCartController::class, 'add'])->name('guest.cart.add');
