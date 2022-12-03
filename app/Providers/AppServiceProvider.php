<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Cart;
use App\Models\UserPincode;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view::composer('*', function($view) {
            $ip = $_SERVER['REMOTE_ADDR'];

            // cart count
            $cartExists = Schema::hasTable('carts');
            if ($cartExists) {
                if (auth()->guard('web')->check()) {
                    $cartCount = Cart::where('user_id', auth()->guard('web')->user()->id)->where('save_for_later', 0)->count();
                } else {
                    $cartCount = 0;
                    if (!empty($_COOKIE['_cart-token'])) {
                        $token = $_COOKIE['_cart-token'];
                        $cartCount = Cart::where('guest_token', $token)->where('save_for_later', 0)->count();
                    }
                }
            }

            // fetch pincode
            $userPinExists = Schema::hasTable('user_pincodes');
            if ($userPinExists) {
                if (auth()->guard('web')->check()) {
                    $userPincode = UserPincode::where('ip_address', $ip)->latest('id')->first();
                } else {
                    $userPincode = UserPincode::where('ip_address', $ip)->latest('id')->first();
                }
            }

            view()->share('cartCount', $cartCount);
            view()->share('userPincode', $userPincode);
        });
    }
}
