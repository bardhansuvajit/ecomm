<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    public function create(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'rating' => 'required|integer|min:1|max:5',
            'first_name' => 'required|string|min:2|max:200',
            'last_name' => 'required|string|min:2|max:200',
            'review' => 'required|string|min:2',
        ]);

        $data = new ProductReview();
        $data->product_id = $request->product_id;
        $data->rating = $request->rating;
        $data->name = $request->first_name.' '.$request->last_name;
        $data->review = $request->review;
        $data->save();

        return redirect()->back()->with('success', 'Product review submitted');


        // check if user is logged in
        if (!auth()->guard('web')->check()) {
            return response()->json([
                'status' => 400,
                'message' => 'You have to login to wishlist product'
            ]);
        }

        // check if product is already wishlisted
        $wishlistCheck = ProductWishlist::where('user_id', auth()->guard('web')->user()->id)->where('product_id', $id)->first();

        if (!empty($wishlistCheck)) {
            ProductWishlist::where('id', $wishlistCheck->id)->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Product removed from wishlist',
            ]);
        }

        $data = new ProductWishlist();
        $data->user_id = auth()->guard('web')->user()->id;
        $data->product_id = $id;
        $data->save();

        return response()->json([
            'status' => 200,
            'message' => 'Product added to wishlist',
        ]);
    }

}
