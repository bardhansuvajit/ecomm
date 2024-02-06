<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Interfaces\CouponInterface;
use App\Interfaces\CurrencyInterface;
use App\Interfaces\ProductInterface;

class CouponController extends Controller
{
    private CouponInterface $couponRepository;
    private CurrencyInterface $currencyRepository;
    private ProductInterface $productRepository;

    public function __construct(CouponInterface $couponRepository, CurrencyInterface $currencyRepository, ProductInterface $productRepository)
    {
        $this->couponRepository = $couponRepository;
        $this->currencyRepository = $currencyRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $resp = $this->couponRepository->listAll($keyword);
        $data = $resp['data'];
        return view('admin.coupon.index', compact('data'));
    }

    public function create(Request $request)
    {
        $currencies = $this->currencyRepository->listAll();
        $products = $this->productRepository->activeProductsList();

        if ($currencies['status'] == "success" && $products['status'] == "success") {
            $data = (object) [];
            $data->currencies = $currencies['data'];
            $data->products = $products['data'];

            return view('admin.coupon.create', compact('data'));
        } else {
            return view('front.error.404');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:1000',
            'code' => 'required|string|min:2|max:255',
            'max_no_of_usage' => 'required|integer|min:1|max:10000',
            'user_max_no_of_usage' => 'required|integer|min:1|lt:max_no_of_usage',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
            'currency_id' => 'required|array',
            'currency_id.*' => 'required|integer|min:1',
            'discount_type' => 'required|array',
            'discount_type.*' => 'required|integer|in:1,2',
            'discount_amount' => 'required|array',
            'discount_amount.*' => 'required|min:1',
            'minimum_cart_amount' => 'nullable|array',
            'minimum_cart_amount.*' => 'nullable|min:1',
            'duallistbox' => 'nullable|array',
            'duallistbox.*' => 'nullable|integer|min:1',
        ]);

        $resp = $this->couponRepository->create($request->except('_token'));

        return redirect()->route('admin.coupon.list.all')->with($resp['status'], $resp['message']);
    }

    public function detail(Request $request, $id)
    {
        $resp = $this->couponRepository->detail($id);

        if ($resp['status'] == "success") {
            $data = $resp['data'];
            return view('admin.coupon.detail', compact('data'));
        } else {
            return view('front.error.404');
        }
    }

    public function edit(Request $request, $id)
    {
        $resp = $this->couponRepository->detail($id);
        $currencies = $this->currencyRepository->listAll();
        $products = $this->productRepository->activeProductsList();

        if ($resp['status'] == "success") {
            if ($currencies['status'] == "success" && $products['status'] == "success") {
                $data = (object) [];
                $data->currencies = $currencies['data'];
                $data->products = $products['data'];
                $data->item = $resp['data'];
                return view('admin.coupon.edit', compact('data'));
            }
        } else {
            return view('front.error.404');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2|max:1000',
            'code' => 'required|string|min:2|max:255',
            'max_no_of_usage' => 'required|integer|min:1|max:10000',
            'user_max_no_of_usage' => 'required|integer|min:1|lt:max_no_of_usage',
            'start_date' => 'required|date',
            'expiry_date' => 'required|date',
            'currency_id' => 'required|array',
            'currency_id.*' => 'required|integer|min:1',
            'discount_type' => 'required|array',
            'discount_type.*' => 'required|integer|in:1,2',
            'discount_amount' => 'required|array',
            'discount_amount.*' => 'required|min:1',
            'minimum_cart_amount' => 'nullable|array',
            'minimum_cart_amount.*' => 'nullable|min:1',
            'duallistbox' => 'nullable|array',
            'duallistbox.*' => 'nullable|integer|min:1',
        ]);

        $resp = $this->couponRepository->update($request->except('_token'));

        return redirect()->route('admin.coupon.edit', $request->id)->with($resp['status'], $resp['message']);
    }

    public function delete(Request $request, $id)
    {
        $resp = $this->couponRepository->delete($id);
        return redirect()->route('admin.coupon.list.all')->with($resp['status'], $resp['message']);
    }

    public function status(Request $request, $id)
    {
        $resp = $this->couponRepository->status($id);

        return response()->json([
            'status' => $resp['status'],
            'message' => $resp['message'],
        ]);
    }

    public function position(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $resp = $this->couponRepository->position($request->position);

        return response()->json([
            'status' => $resp['status'],
            'message' => $resp['message'],
        ]);
    }
}
