<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DBResetController extends Controller
{
    public function index(Request $request)
    {
        DB::select('TRUNCATE table carts');
        DB::select('TRUNCATE table coupon_usages');
        DB::select('TRUNCATE table orders');
        DB::select('TRUNCATE table order_addresses');
        DB::select('TRUNCATE table order_products');
        DB::select('TRUNCATE table user_addresses');
        DB::select('TRUNCATE table product_wishlists');

        dd('done');
    }
}
