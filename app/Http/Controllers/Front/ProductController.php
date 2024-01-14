<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductInterface;

use App\Models\Product;

class ProductController extends Controller
{
    private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request) {
        $data = $this->productRepository->allProductsToShow();
        return view('front.product.index', compact('data'));
    }

    public function detail(Request $request, $slug)
    {
        $data = $this->productRepository->detailFrontend($slug);

        if (!empty($data['data'])) {
            $categories = $data['categories'];
            $data = $data['data'];

            return view('front.product.detail', compact('data', 'categories'));
        } else {
            return redirect()->route('front.error.404');
        }

        /*
        $cartRedirectTo = $wishlistToggle = '';
        $data = Product::where('slug', $slug)->where('status', 1)->first();

        // if product exists
        if (!empty($data)) {
            Product::where('slug', $slug)->update([
                'view_count' => $data->view_count + 1
            ]);

            $allCategories = $data->categoryDetails;
            $related_products = [];

            foreach ($allCategories as $index => $category) {
                $related_products[] = ProductProductCategory1::where('category_id', $category->category_id)->where('product_id', '!=', $data->id)->get();
            }

            // if user is logged in
            if (auth()->guard('web')->check()) {
                $productExistsInCart = Cart::where('user_id', auth()->guard()->user()->id)->where('product_id', $data->id)->first();

                if (!empty($productExistsInCart)) {
                    $cartRedirectTo = 'cart';
                }

                $wishlistCheck = ProductWishlist::where('user_id', auth()->guard()->user()->id)->where('product_id', $data->id)->first();

                if (!empty($wishlistCheck)) {
                    $wishlistToggle = 'active';
                }
            }
            // if user not logged in
            else {
                if (!empty($_COOKIE['_cart-token'])) {
                    $token = $_COOKIE['_cart-token'];
                    $productExistsInCart = Cart::where('guest_token', $token)->where('product_id', $data->id)->first();

                    if (!empty($productExistsInCart)) {
                        $cartRedirectTo = 'cart';
                    }
                }
            }

            return view('front.product.detail', compact('data', 'related_products', 'cartRedirectTo', 'wishlistToggle'));
        } else {
            return redirect()->route('front.error.404');
        }
        */
    }
}
