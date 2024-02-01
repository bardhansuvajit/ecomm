<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\ProductInterface;
use App\Interfaces\ProductReviewInterface;

use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    private ProductInterface $productRepository;
    private ProductReviewInterface $productReviewRepository;

    public function __construct(ProductInterface $productRepository, ProductReviewInterface $productReviewRepository)
    {
        $this->productRepository = $productRepository;
        $this->productReviewRepository = $productReviewRepository;
    }

    public function index(Request $request, $slug)
    {
        $data = $this->productRepository->detailFrontend($slug);

        if (!empty($data['data'])) {
            $product = $data['data'];
            $activeReviews = $this->productReviewRepository->paginatedActiveReviewsByProduct($product->id);

            if ($activeReviews['status'] == 'success') {
                return view('front.review.index', compact('product', 'activeReviews'));
            } else {
                return redirect()->route('front.error.404');
            }
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function create(Request $request, $slug)
    {
        $data = $this->productRepository->detailFrontend($slug);

        if (!empty($data['data'])) {
            $product = $data['data'];

            if (auth()->guard('web')->check()) {
                return view('front.review.create', compact('product'));
            } else {
                return redirect()->route('front.error.401', ['login' => 'true', 'redirect' => route('front.product.review.create', $slug)]);
            }
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function upload(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $request->validate([
                'product_id' => 'required|integer|min:1',
                'rating' => 'required|integer|min:1|max:5',
                'heading' => 'required|string|min:2|max:200',
                'review' => 'required|string|min:2',
            ]);

            $data = $this->productReviewRepository->create(array_merge($request->all(), ['user_id' => auth()->guard('web')->user()->id]));

            return redirect()->back()->with('success', $data['message']);
        } else {
            return redirect()->route('front.error.401', ['login' => 'true', 'redirect' => route('front.product.review.create', $slug)]);
        }
    }

}
