<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\ProductInterface;
use App\Interfaces\ProductSubscriptionInterface;
use App\Interfaces\ActivityLogInterface;

use App\Models\Product;

class ProductController extends Controller
{
    private ProductInterface $productRepository;
    private ProductSubscriptionInterface $productSubscriptionRepository;
    private ActivityLogInterface $activityLogRepository;

    public function __construct(
        ProductInterface $productRepository, 
        ProductSubscriptionInterface $productSubscriptionRepository, 
        ActivityLogInterface $activityLogRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productSubscriptionRepository = $productSubscriptionRepository;
        $this->activityLogRepository = $activityLogRepository;
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

            // recently viewed products
            $user_id = auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0;
            $recentlyViewedProducts = $this->activityLogRepository->distinctProducts($user_id, 'product_watchlist', $data->id);

            return view('front.product.detail', compact('data', 'categories', 'recentlyViewedProducts'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function subscribe(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'product_status' => 'required|string|min:1|max:20|exists:product_statuses,name',
            'prod_sub_mail' => 'required|email|min:5|max:70'
        ], [
            'prod_sub_mail.*' => 'Please enter a valid email address'
        ]);

        $user_id = auth()->guard('web')->check() ? auth()->guard('web')->user()->id : 0;

        $data = $this->productSubscriptionRepository->create([
            'product_id' => (int) $request->product_id, 
            'user_id' => $user_id, 
            'email_id' => $request->prod_sub_mail, 
            'current_product_status' => $request->product_status
        ]);

        return redirect()->back()->with($data['status'], $data['message']);
    }

}
