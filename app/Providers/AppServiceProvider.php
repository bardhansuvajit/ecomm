<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\ApplicationSetting;
use App\Models\OfficeInformation;
use App\Models\OfficeAddress;
use App\Models\Currency;
use App\Models\Notice;
use App\Models\SocialMedia;
use App\Models\ProductCategory1;
use App\Models\Cart;
use App\Models\IpCountry;

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
            $cartContent = [];
            $existingCurrencyId = 1;
            $cartCount = 0;

            // insert first site visit to db
            $ip_chk = IpCountry::where('ip_address', ipfetch())->first();
            if (empty($ip_chk)) {
                $ipData = new IpCountry();
                $ipData->ip_address = ipfetch();
                $ipData->country = "India";
                $ipData->currency_id = 1;
                $ipData->save();
            }

            $applicationSetting = ApplicationSetting::first();

            $officeInformationTableExists = Schema::hasTable('office_information');
            if ($officeInformationTableExists) {
                $officeInfo = OfficeInformation::first();
            }

            $currencyTableExists = Schema::hasTable('currencies');
            if ($currencyTableExists) {
                if (!empty($ip_chk)) {
                    $existingCurrencyId = $ip_chk->currency_id;
                }
                $currencies = Currency::where('status', 1)->orderBy('position')->get();
            }

            // cart count
            $cartExists = Schema::hasTable('carts');
            if ($cartExists) {
                if (auth()->guard('web')->check()) {
                    $cartCount = Cart::where('user_id', auth()->guard('web')->user()->id)->where('save_for_later', 0)->count();
                    // $cartContent = Cart::where('user_id', auth()->guard('web')->user()->id)->where('save_for_later', 0)->get();
                } else {
                    if (!empty($_COOKIE['_cart-token'])) {
                        $token = $_COOKIE['_cart-token'];
                        $cartCount = Cart::where('guest_token', $token)->where('save_for_later', 0)->count();
                        // $cartContent = Cart::where('guest_token', $token)->where('save_for_later', 0)->get();
                    }
                }
            }

            /*
            $officeAddressTableExists = Schema::hasTable('office_addresses');
            if ($officeAddressTableExists) {
                $officeAddress = OfficeAddress::orderBy('position')->first();
            }

            $noticesTableExists = Schema::hasTable('notices');
            if ($noticesTableExists) {
                $notice = Notice::where('status', 1)->orderBy('position')->first();
            }

            $socialMediaTableExists = Schema::hasTable('social_media');
            if ($socialMediaTableExists) {
                $socialMedia = SocialMedia::where('status', 1)->orderBy('position')->get();
            }

            $categoryTableExists = Schema::hasTable('categories');
            if ($categoryTableExists) {
                $categories = ProductCategory1::where('status', 1)->orderBy('position')->get();
            }
            */


            // view()->share('customGlobal', $customGlobal);
            view()->share('applicationSetting', $applicationSetting);
            view()->share('officeInfo', $officeInfo);
            view()->share('currencies', $currencies);
            view()->share('existingCurrencyId', $existingCurrencyId);
            view()->share('cartCount', $cartCount);
            /*
            view()->share('cartContent', $cartContent);
            view()->share('officeAddress', $officeAddress);
            view()->share('notice', $notice);
            view()->share('socialMedia', $socialMedia);
            view()->share('categories', $categories);
            */
        });
    }
}
