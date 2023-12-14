<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Interfaces\AuthInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\OrderInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\CouponInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\CurrencyInterface;
use App\Interfaces\PaymentMethodInterface;
use App\Interfaces\CountryInterface;
use App\Interfaces\StateInterface;
use App\Interfaces\CityInterface;
use App\Interfaces\UserAddressInterface;
use App\Interfaces\CollectionInterface;
use App\Interfaces\WishlistInterface;
use App\Interfaces\CategoryInterface;

use App\Repositories\AuthRepository;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CartRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\CountryRepository;
use App\Repositories\StateRepository;
use App\Repositories\CityRepository;
use App\Repositories\UserAddressRepository;
use App\Repositories\CollectionRepository;
use App\Repositories\WishlistRepository;
use App\Repositories\CategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CouponInterface::class, CouponRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
        $this->app->bind(CurrencyInterface::class, CurrencyRepository::class);
        $this->app->bind(PaymentMethodInterface::class, PaymentMethodRepository::class);
        $this->app->bind(CountryInterface::class, CountryRepository::class);
        $this->app->bind(StateInterface::class, StateRepository::class);
        $this->app->bind(CityInterface::class, CityRepository::class);
        $this->app->bind(UserAddressInterface::class, UserAddressRepository::class);
        $this->app->bind(CollectionInterface::class, CollectionRepository::class);
        $this->app->bind(WishlistInterface::class, WishlistRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
