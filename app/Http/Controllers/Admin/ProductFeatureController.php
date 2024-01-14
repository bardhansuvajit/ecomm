<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductFeature;

class ProductFeatureController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';

        $query = Product::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('title', 'like', '%'.$keyword.'%');
        });

        $productList = $query->whereIn('status', showInFrontendProductStatusID())->orderBy('title')->paginate(25);
        $productFeatures = ProductFeature::pluck('product_id')->toArray();

        return view('admin.product.feature.index', compact('productList', 'productFeatures'));
    }

    public function position(Request $request)
    {
        $request->validate([
            'position' => 'required|array',
            'position.*' => 'required|integer|min:1'
        ]);

        $count = 1;
        foreach($request->position as $position) {
            $data = ProductFeature::findOrFail($position);
            $data->position = $count;
            $data->save();

            $count++;
        }

        return response()->json([
            'status' => 200,
            'message' => 'Position updated',
        ]);
    }

    
}
