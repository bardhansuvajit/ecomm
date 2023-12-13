<?php
namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Auth::routes();

// Front
Route::name('front.')->group(function() {
    Route::prefix('user')->name('user.')->group(function() {
        Route::middleware('guest:web', 'PreventBackHistory')->group(function() {
            Route::get('/login', [AuthController::class, 'login'])->name('login');
            Route::get('/register', [AuthController::class, 'register'])->name('register');
            Route::post('/create', [AuthController::class, 'create'])->name('create');
            Route::post('/check', [AuthController::class, 'check'])->name('check');

            Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
            Route::post('/forgot-password/check', [AuthController::class, 'forgotPasswordCheck'])->name('forgot.password.check');

            // working social login
            Route::post('/login/google', [SocialLoginController::class, 'loginWithGoogle'])->name('login.google');
        });

        Route::middleware('auth:web', 'PreventBackHistory')->group(function() {
            // account
            Route::get('/account', [AuthController::class, 'account'])->name('account');

            // profile
            Route::get('/profile', [AuthController::class, 'profile'])->name('profile.index');
            Route::post('/profile/update', [AuthController::class, 'edit'])->name('profile.edit');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

            // password
            Route::get('/password', [ProfileController::class, 'passwordEdit'])->name('password.edit');
            Route::post('/password/verify', [ProfileController::class, 'oldPassVerify'])->name('password.old.verify');
            Route::post('/password/update', [ProfileController::class, 'passUpdate'])->name('password.update');

            // address
            Route::get('/address', [AddressController::class, 'index'])->name('address.index');
            Route::post('/address/store', [AddressController::class, 'store'])->name('address.store');
            Route::post('/address/billing/store', [AddressController::class, 'billingStore'])->name('address.billing.store');
            Route::get('/address/default/{id}', [AddressController::class, 'default'])->name('address.default');
            Route::get('/address/remove/{id}', [AddressController::class, 'remove'])->name('address.remove');
            Route::get('/address/edit/{id}', [AddressController::class, 'edit'])->name('address.edit');
            Route::post('/address/update', [AddressController::class, 'update'])->name('address.update');

            // order
            Route::get('/order', [OrderController::class, 'index'])->name('order.index');
            Route::get('/order/{orderNo}', [OrderController::class, 'detail'])->name('order.detail');

            // wishlist
            Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

            /*
            // profile
            Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
            Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
            Route::view('/profile/edit', 'front.profile.edit')->name('profile.edit');
            Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

            // password
            Route::view('/password/edit', 'front.profile.password')->name('password.edit');
            Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('password.update');

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
            */
        });
    });

    // homepage
    Route::get('/', [IndexController::class, 'index'])->name('home');

    // category
    Route::prefix('category')->name('category.')->group(function() {
        Route::get('/{slug}', [CategoryController::class, 'detail'])->name('detail');
    });
    // Route::get('/category-detail', [CategoryController::class, 'detail'])->name('category.detail');

    // category
    Route::prefix('category')->name('category.')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/{slug}', [CategoryController::class, 'detail'])->name('detail');
    });

    // collection
    Route::prefix('collection')->name('collection.')->group(function() {
        Route::get('/', [CollectionController::class, 'index'])->name('index');
        Route::get('/{slug}', [CollectionController::class, 'detail'])->name('detail');
    });

    // checkout
    Route::prefix('checkout')->name('checkout.')->group(function() {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/login/check', [CheckoutController::class, 'loginCheck'])->name('login.check');
        Route::post('/user/detail', [CheckoutController::class, 'userDetail'])->name('user.detail');
        Route::get('/billing-address/remove/all', [CheckoutController::class, 'removeBillingAddressAll'])->name('billing.address.remove.all');
        Route::post('/store', [CheckoutController::class, 'store'])->name('store');
        Route::get('/complete', [CheckoutController::class, 'complete'])->name('complete');
    });

    // cart
    Route::prefix('cart')->name('cart.')->group(function() {
        Route::get('json', [CartController::class, 'indexJson'])->name('index.json');
        Route::get('remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::get('save-later/{id}', [CartController::class, 'save'])->name('save');
        Route::post('qty/update', [CartController::class, 'qtyUpdate'])->name('qty.update');
    });

    // coupon
    Route::prefix('coupon')->name('coupon.')->group(function() {
        Route::post('/check', [CouponController::class, 'check'])->name('check');
        Route::post('/check/json', [CouponController::class, 'checkJson'])->name('check.json');
        Route::get('/remove', [CouponController::class, 'remove'])->name('remove');
        Route::get('/list', [CouponController::class, 'list'])->name('list');
    });

    // wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function() {
        Route::get('toggle/{productId}', [WishlistController::class, 'toggle'])->name('toggle');
    });

    // error
    Route::prefix('error')->name('error.')->group(function() {
        Route::get('404', [ErrorController::class, 'err404'])->name('404');
        Route::get('401', [ErrorController::class, 'err401'])->name('401');
    });

    // product
    Route::name('product.')->group(function() {
        Route::get('{slug}', [ProductController::class, 'detail'])->name('detail');
    });

    /*
    // search
    Route::prefix('search')->name('search.')->group(function() {
        Route::post('/json', [SearchController::class, 'index'])->name('index');
        Route::get('/', [SearchController::class, 'redirect'])->name('redirect');
    });

    // content
    Route::name('content.')->group(function() {
        Route::get('/our-story', [ContentController::class, 'ourStory'])->name('ourstory.index');
    });

    // blog
    Route::prefix('blog')->name('blog.')->group(function() {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('{slug}', [BlogController::class, 'detail'])->name('detail');
    });

    // shop
    Route::prefix('shop')->name('shop.')->group(function() {
        Route::get('/', [ShopController::class, 'index'])->name('index');
    });

    // category
    Route::prefix('category')->name('category.')->group(function() {
        Route::get('/{slug}', [CategoryController::class, 'detail'])->name('detail');
    });

    // cart
    Route::prefix('cart')->name('cart.')->group(function() {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::post('/qty/update', [CartController::class, 'qtyUpdate'])->name('qty.update');
    });

    // coupon
    Route::prefix('coupon')->name('coupon.')->group(function() {
        Route::post('/check', [CouponController::class, 'check'])->name('check');
        Route::get('/remove', [CouponController::class, 'remove'])->name('remove');
    });

    // checkout
    Route::prefix('checkout')->name('checkout.')->group(function() {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/store', [CheckoutController::class, 'store'])->name('store');
        Route::get('/complete', [CheckoutController::class, 'complete'])->name('complete');
    });

    // product
    Route::prefix('product')->name('product.')->group(function() {
        Route::get('/{slug}', [ProductController::class, 'detail'])->name('detail');
        Route::get('/wishlist/{id}', [ProductController::class, 'wishlistToggle'])->name('wishlist.toggle');

        // review
        Route::prefix('review')->name('review.')->group(function() {
            Route::post('/create', [ProductReviewController::class, 'create'])->name('create');
        });
    });
    */
});

// Admin
Route::prefix('admin')->group(function() {
    require 'custom/admin.php';
});