<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProductCategory1;
use App\Models\Product;
use App\Models\ProductKeyFeature;
use App\Models\ProductBoxItem;
use App\Models\ProductManual;
use App\Models\ProductDatasheet;
use App\Models\ProductImage;
use App\Models\ProductFeature;
use App\Models\ProductStatus;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $activeCategories = ProductCategory1::where('status', 1)->orderBy('title')->get();

        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = Product::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });
        $query->when($category, function($query) use ($category) {
            $query->where('category_id', $category);
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->latest('id')->paginate(25);

        // active products only
        $activeProducts = Product::where('status', 1)->orderBy('title')->get();
        $statuses = ProductStatus::get();

        return view('admin.product.index', compact('data', 'statuses', 'activeCategories', 'activeProducts'));
    }

    public function fetch(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $query = ProductFeature::query()->select('product_features.id', 'product_features.product_id')->join('products', 'products.id', '=', 'product_features.product_id');

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('products.title', 'like', '%'.$keyword.'%')
            ->orWhere('products.short_description', 'like', '%'.$keyword.'%');
        });
        $data = $query->orderBy('product_features.position')->get();

        if (!empty($data) && count($data) > 0) {
            $resp = [];
            foreach($data as $product) {
                $resp[] = [
                    'feature_id' => $product->id,
                    'id' => $product->product_id,
                    'title' => $product->productDetail->title,
                    'short_desc' => $product->productDetail->short_description,
                    'link' => route('admin.product.detail', $product->product_id),
                    'image' => ( count($product->productDetail->frontImageDetails) > 0 ) ? asset($product->productDetail->frontImageDetails[0]->img_medium) : asset('backend-assets/images/placeholder.jpg'),
                ];
            }

            return response()->json([
                'status' => 200,
                'message' => 'Featured products found',
                'data' => $resp,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data not found'
            ]);
        }
    }

    public function detail(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $statuses = ProductStatus::get();

        return view('admin.product.detail', compact('data', 'statuses'));
    }

    public function delete(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.product.list.all')->with('success', 'Product deleted');
    }

    public function status(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Status updated',
        ]);
    }

    public function saveDraft(Request $request, $id)
    {
        $data = Product::findOrFail($id);
        $data->status = 0;
        $data->update();

        return redirect()->route('admin.product.detail', $id)->with('success', 'Product saved as draft');
    }

}
