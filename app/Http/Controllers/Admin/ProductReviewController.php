<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\ProductReview;

class ProductReviewController extends Controller
{
    public function index(Request $request, $id)
    {
        $status = $request->status ?? '';
        $category = $request->category ?? '';
        $keyword = $request->keyword ?? '';

        $query = ProductReview::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('email', 'like', '%'.$keyword.'%')
            ->orWhere('phone_number', 'like', '%'.$keyword.'%')
            ->orWhere('review', 'like', '%'.$keyword.'%');
        });
        $query->when($status, function($query) use ($status) {
            $query->where('status', $status);
        });

        $data = $query->where('product_id', $id)->latest('id')->paginate(25);

        return view('admin.product-review.index', compact('data', 'id'));
    }
}
