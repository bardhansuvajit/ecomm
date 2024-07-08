<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\VariationInterface;
use App\Interfaces\VariationOptionInterface;

use App\Models\Product;

class ProductVariationController extends Controller
{
    private VariationInterface $variationRepository;
    private VariationOptionInterface $variationOptionRepository;

    public function __construct(VariationInterface $variationRepository, VariationOptionInterface $variationOptionRepository)
    {
        $this->variationRepository = $variationRepository;
        $this->variationOptionRepository = $variationOptionRepository;
    }

    public function index(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.variation.index', compact('request', 'data'));
    }

    public function create(Request $request, $id)
    {
        $data = Product::findOrFail($id);

        $moreData = array_merge($request->all(), [
            'status' => 1,
            'page' => 'all',
        ]);
        $variations = $this->variationRepository->listPaginated($moreData, ['position', 'asc']);
        $categories = $this->variationOptionRepository->categories();

        return view('admin.product.variation.create', compact('request', 'data', 'variations', 'categories'));
    }
















    public function variationParentPosition(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        return view('admin.product.setup.variation-parent-position', compact('request', 'data'));
    }

    public function variationParentDetail(Request $request, $id, $variationParentId)
    {
        $data = Product::findOrFail($id);
        $parent_variation = ProductVariationParent::findOrFail($variationParentId);
        return view('admin.product.setup.variation-parent-detail', compact('request', 'data', 'parent_variation'));
    }

    public function variationParentEdit(Request $request, $id, $variationParentId)
    {
        $data = Product::findOrFail($id);
        $parent_variation = ProductVariationParent::findOrFail($variationParentId);
        return view('admin.product.setup.variation-parent-edit', compact('request', 'data', 'parent_variation'));
    }

    public function variationChildCreate(Request $request, $id, $variationParentId)
    {
        $data = Product::findOrFail($id);
        $parent_variation = ProductVariationParent::findOrFail($variationParentId);
        $currencies = Currency::where('status', 1)->orderBy('position')->get();
        $productCurrencies = ProductPricing::where('product_id', $id)->get();
        return view('admin.product.setup.variation-child-create', compact('request', 'data', 'parent_variation', 'variationParentId', 'currencies', 'productCurrencies'));
    }


















    public function variationParent(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'title' => 'required|string|min:2|max:1000',
            'product_id' => 'required|integer|min:1',
        ]);

        $chk = ProductVariationParent::where('product_id', $request->product_id)->where('title', $request->title)->first();

        if (!empty($chk)) {
            return redirect()->back()->with('failure', 'This variation already exists');
        }

        $data = new ProductVariationParent();
        $data->product_id = $request->product_id;
        $data->title = $request->title;
        $data->position = positionSet('product_variation_parents');
        $data->save();

        return redirect()->back()->with('success', 'New Variation added');
    }

    public function variationParentUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'id' => 'required|integer|min:1',
            'title' => 'required|string|min:1|max:255',
            'short_desc' => 'nullable|string|min:2|max:1000',
            'detailed_desc' => 'nullable|string|min:2|max:10000',
        ]);

        $item = ProductVariationParent::findOrFail($request->id);
        $item->title = $request->title;
        $item->short_desc = $request->short_desc ?? '';
        $item->detailed_desc = $request->detailed_desc ?? '';

        $item->save();

        return redirect()->route('admin.product.setup.variation', $request->product_id)->with('success', 'Product variation update successfull');
    }

    public function variationChild(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'parent_id' => 'required|integer|min:1',
            'product_id' => 'required|integer|min:1',
            'title' => 'required|string|min:2|max:1000',
            'product_title' => 'nullable|string|min:2|max:1000',
            'short_description' => 'nullable|string|min:2|max:1000',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,svg|max:1000',

            'currency_id' => 'required|array|min:1',
            'currency_id.*' => 'required|integer|min:1',

            'cost' => 'nullable|array',
            'cost.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1',
            'mrp' => 'nullable|array|min:1',
            'mrp.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1|gt:selling_price.*',
            'selling_price' => 'nullable|array',
            'selling_price.*' => 'nullable|regex:/^\d{1,13}(\.\d{1,4})?$/|min:1|gt:cost.*',
        ], [
            'image' => 'The image must not be greater than 1MB.',
            'cost.*.integer' => 'Cost must be an integer',
            'mrp.*.integer' => 'MRP must be an integer',
            'mrp.*.gt' => 'The MRP must be greater than selling price',
            'selling_price.*.integer' => 'Selling price must be an integer',
            'selling_price.*.gt' => 'The selling price must be greater than cost',
        ]);

        $chk = ProductVariationChild::where('parent_id', $request->parent_id)->where('title', $request->title)->first();

        if (!empty($chk)) {
            return redirect()->back()->with('failure', 'This variation already exists')->withInput($request->all());
        }

        DB::beginTransaction();

        try {
            $data = new ProductVariationChild();
            $data->parent_id = $request->parent_id;
            $data->title = $request->title;
            $data->product_title = $request->product_title ?? '';
            $data->position = positionSet('product_variation_children');

            // image upload
            if (isset($request->image)) {
                $fileUpload = fileUpload($request->image, 'variation');

                $data->image_small = $fileUpload['file'][0];
                $data->image_medium = $fileUpload['file'][1];
                $data->image_large = $fileUpload['file'][2];
                $data->image_org = $fileUpload['file'][3];
            }

            $data->save();

            // currency
            if (!empty($request->selling_price[0])) {
                foreach($request->currency_id as $currencyIndex => $currency) {
                    $pricing = new ProductPricing();
                    $pricing->product_id = $request->product_id;
                    $pricing->currency_id = $currency;
                    $pricing->variation_child_id = $data->id;
                    $pricing->cost = $request->cost[$currencyIndex] ?? null;
                    $pricing->mrp = $request->mrp[$currencyIndex] ?? null;
                    $pricing->selling_price = $request->selling_price[$currencyIndex] ?? 0;
                    $pricing->save();
                }
            }

            DB::commit();

            // dd($data);

            return redirect()->route('admin.product.setup.variation', $request->product_id)->with('success', 'New Variation added');

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public function variationParentDelete(Request $request, $id)
    {
        ProductVariationParent::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Variation deleted')->withInput($request->all());
    }

    public function variationParentPositionUpdate(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductVariationParent::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function variationChildPosition(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductVariationChild::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    public function variationParentStatus(Request $request, $id)
    {
        $data = ProductVariationParent::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function variationChildStatus(Request $request, $id)
    {
        $data = ProductVariationChild::findOrFail($id);
        $data->status = ($data->status == 1) ? 0 : 1;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function variationChildDelete(Request $request, $id)
    {
        ProductVariationChild::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Variation deleted')->withInput($request->all());
    }

}
