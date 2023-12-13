<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\Review;
use App\Models\ReviewFile;

class ReviewController extends Controller
{
    public function index(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        $cartRedirectTo = $wishlistToggle = '';

        if ($product) {
            if (auth()->guard('web')->check()) {
                $productExistsInCart = Cart::where('user_id', auth()->guard()->user()->id)->where('product_id', $product->id)->first();

                if (!empty($productExistsInCart)) {
                    $cartRedirectTo = 'cart';
                }

                $wishlistCheck = Wishlist::where('user_id', auth()->guard()->user()->id)->where('product_id', $product->id)->first();

                if (!empty($wishlistCheck)) {
                    $wishlistToggle = 'active';
                }
            } else {
                if (!empty($_COOKIE['_cart-token'])) {
                    $token = $_COOKIE['_cart-token'];
                    $productExistsInCart = Cart::where('guest_token', $token)->where('product_id', $product->id)->first();

                    if (!empty($productExistsInCart)) {
                        $cartRedirectTo = 'cart';
                    }
                }
            }

            if (!empty($request->filter) == 'on') {
                $keyword = $request->keyword;
                $sortBy = $request->input('sort_by');

                $reviews = Review::where('product_id', $product->id)
                ->when($sortBy == "top-reviews", function ($query) {
                    return $query->orderBy('rating', 'desc');
                })
                ->when($sortBy == "recent-reviews", function ($query) {
                    return $query->latest('id');
                })
                ->paginate(10);
            } else {
                $reviews = Review::where('product_id', $product->id)->orderBy('rating', 'desc')->paginate(10);
            }

            return view('front.review.index', compact('product', 'cartRedirectTo', 'wishlistToggle', 'reviews'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function create(Request $request, $slug)
    {
        if (Auth::guard('web')->check()) {
            $data = Product::where('slug', $slug)->first();

            if ($data) {
                return view('front.review.create', compact('data'));
            } else {
                return redirect()->route('front.error.404');
            }
        } else {
            return redirect()->route('front.user.login');
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer',
            'rating' => 'required|integer|in:1,2,3,4,5',
            'description' => 'required|string',
            'title' => 'nullable|string|max:255',
            'file' => 'nullable|array',
            'file.*' => 'mimes:jpeg,png,jpg,gif,svg,mp4,mov|max:5000'
        ], [
            'file' => 'Please upload one or multiple product related image or video'
        ]);

        $review = new Review();
        $review->user_id = Auth::guard('web')->user()->id;
        $review->product_id = $request->product_id;
        $review->rating = $request->rating;
        $review->description = $request->description ?? '';
        $review->title = $request->title ?? '';
        $review->save();

        if (!empty($request->file) && count($request->file) > 0) {
            foreach($request->file as $file) {
                $reviewFile = new ReviewFile();
                $reviewFile->review_id = $review->id;

                $fileUpload = fileUpload($file, 'review');
                $reviewFile->type = $fileUpload['type'];
                $reviewFile->extension = $fileUpload['extension'];
                $reviewFile->file_smaller = $fileUpload['file'][0];
                $reviewFile->file_medium = $fileUpload['file'][1] ?? '';
                $reviewFile->file_large = $fileUpload['file'][2] ?? '';

                $reviewFile->save();
            }
        }

        return redirect()->back()->with('success', 'Thanks for your review');
    }

}
