<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductFeature;

class ProductController extends Controller
{
    public function fetch(Request $request) {
        $keyword = $request->keyword ?? '';

        $query = ProductFeature::query()
        ->select('product_features.id as feature_id', 'products.id', 'products.title', 'products.short_description', 'product_images.img_medium')
        ->join('products', 'products.id', '=', 'product_features.product_id')
        ->leftJoin('product_images', 'products.id', '=', 'product_images.product_id');

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('products.title', 'like', '%'.$keyword.'%')
            ->orWhere('products.short_description', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('product_features.position')->get();

        if (!empty($data) && count($data) > 0) {
            $resp = [];
            foreach($data as $product) {
                $resp[] = [
                    'feature_id' => $product->feature_id,
                    'id' => $product->id,
                    'title' => $product->title,
                    'short_desc' => $product->short_description,
                    'link' => route('admin.product.detail', $product->id),
                    'image' => $product->img_medium ? asset($product->img_medium) : asset('backend-assets/images/placeholder.jpg'),
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

    public function add(Request $request) {
        $request->validate([
            'product_id' => 'required|integer|min:1'
        ]);

        $checkFirst = ProductFeature::where('product_id', $request->product_id)->first();

        if (!empty($checkFirst)) {
            $checkFirst->delete();

            return response()->json([
                'status' => 200,
                'message' => 'Product removed from Feature list',
            ]);
        } else {
            $productFeature = new ProductFeature();
            $productFeature->product_id = $request->product_id;
            $productFeature->position = positionSet('product_features');
            $productFeature->save();

            return response()->json([
                'status' => 200,
                'message' => 'Product added to Feature list',
            ]);
        }
    }
}
