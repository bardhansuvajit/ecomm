<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

use App\Interfaces\VariationInterface;
use App\Interfaces\VariationOptionInterface;
use App\Interfaces\ProductVariationInterface;

use App\Models\Product;
use App\Models\ProductPricing;

class ProductVariationController extends Controller
{
    private VariationInterface $variationRepository;
    private VariationOptionInterface $variationOptionRepository;
    private ProductVariationInterface $productVariationRepository;

    public function __construct(VariationInterface $variationRepository, VariationOptionInterface $variationOptionRepository, ProductVariationInterface $productVariationRepository)
    {
        $this->variationRepository = $variationRepository;
        $this->variationOptionRepository = $variationOptionRepository;
        $this->productVariationRepository = $productVariationRepository;
    }

    public function index(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.variation.index', compact('request', 'data'));
    }

    public function detail(Request $request, $id, $prodVarId)
    {
        $data = Product::findOrFail($id);
        $resp = $this->productVariationRepository->detail($prodVarId);

        if ($resp['status'] == 'success') {
            $item = $resp['data'];
            $productCurrencies = ProductPricing::where('product_id', $id)->get();
            return view('admin.product.variation.detail', compact('request', 'data', 'item', 'productCurrencies'));
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function create(Request $request, $id)
    {
        $data = Product::findOrFail($id);

        $moreData = array_merge($request->all(), [
            'status' => 1,
            'page' => 'all'
        ]);
        $variations = $this->variationRepository->list($moreData, ['position', 'asc']);

        // grouping by category
        if (!empty($variations['data']) && count($variations['data']) > 0) {
            $new_variations = collect($variations['data']);

            $new_variations = $new_variations->map(function ($parent) {
                $groupedOptions = $parent->activeOptions->groupBy('category');
                $parent->groupedOptions = $groupedOptions;
                return $parent;
            });
        }

        $categories = $this->variationOptionRepository->categories();
        $all_variations = $this->variationRepository->list(['status' => 1, 'page' => 'all'], ['position', 'asc']);

        return view('admin.product.variation.create', compact('request', 'data', 'all_variations', 'variations', 'categories'));
    }

    public function toggle(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|min:1',
            'variation_option_id' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->errors()->first()
            ]);
        }

        $resp = $this->productVariationRepository->toggle($request->all());

        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }

    public function update(Request $request, $productId)
    {
        // dd($request->all());

        $request->validate([
            'tag' => 'nullable|string|min:2|max:100',
            'thumb_path' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000'
        ], [
            'thumb_path.max' => 'The image must not be greater than 1MB.'
        ]);

        $resp = $this->productVariationRepository->update($request->all());

        if ($resp['status'] == 'success') {
            return redirect()->back()->with($resp['status'], $resp['message']);
            // return redirect()->route('admin.product.setup.variation.index', $productId)->with($resp['status'], $resp['message']);
        } else {
            return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
        }
    }

    public function status(Request $request, $prodVarId)
    {
        $resp = $this->productVariationRepository->status($prodVarId);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }

    public function thumbRemove(Request $request, $id, $prodVarId)
    {
        $data = Product::findOrFail($id);
        $resp = $this->productVariationRepository->thumbRemove($prodVarId);

        if ($resp['status'] == 'success') {
            $item = $resp['data'];
            return redirect()->back()->with($resp['status'], $resp['message']);
        } else {
            return redirect()->route('admin.error.404')->with($resp['status'], $resp['message']);
        }
    }

    public function thumbStatus(Request $request, $prodVarId)
    {
        $resp = $this->productVariationRepository->thumbStatus($prodVarId);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }

    public function position(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.variation.position', compact('request', 'data'));
    }

    public function positionUpdate(Request $request)
    {
        $resp = $this->productVariationRepository->position($request->position);
        return response()->json([
            'status' => $resp['code'],
            'message' => $resp['message'],
        ]);
    }

    public function delete(Request $request, $id, $prodVarId)
    {
        $resp = $this->productVariationRepository->delete($prodVarId);
        return redirect()->back()->with($resp['status'], $resp['message']);
    }

    public function updatePricing(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'product_variation_id' => 'required|integer|min:1',
            'currency_id' => 'required|array|min:1',
            'currency_id.*' => 'required|integer|min:1',

            'cost' => 'nullable|array',
            'cost.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1',
            'mrp' => 'nullable|array|min:1',
            'mrp.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1|gt:selling_price.*',
            'selling_price' => 'nullable|array',
            'selling_price.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1|gt:cost.*',
        ], [
            'cost.*.integer' => 'Cost must be an integer',
            'mrp.*.integer' => 'MRP must be an integer',
            'mrp.*.gt' => 'The MRP must be greater than selling price',
            'selling_price.*.integer' => 'Selling price must be an integer',
            'selling_price.*.gt' => 'The selling price must be greater than cost',
        ]);

        $resp = $this->productVariationRepository->price($request->all());
        return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

    public function images(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required|integer|min:1',
            'product_variation_id' => 'required|integer|min:1',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',
        ], [
            'images.max' => 'The image must not be greater than 1MB.',
        ]);

        $resp = $this->productVariationRepository->images($request->all());
        return redirect()->back()->with($resp['status'], $resp['message'])->withInput($request->all());
    }

}
