<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

use App\Interfaces\CollectionInterface;

// use App\Models\ProductCollection;

class CollectionController extends Controller
{
    private CollectionInterface $collectionRepository;

    public function __construct(CollectionInterface $collectionRepository)
    {
        $this->collectionRepository = $collectionRepository;
    }

    public function index(Request $request)
    {
        $resp = $this->collectionRepository->listAllActive();

        if ($resp['status'] == 'success') {
            $data = $resp['data'];
            return view('front.collection.index', compact('data'));
        } else {
            return redirect()->route('front.error.404');
        }
    }

    public function detail(Request $request, $slug)
    {
        $resp = $this->collectionRepository->detailBySlug($slug);

        if ($resp['status'] == 'success') {
            $data = $resp['data'];

            // products
            // $query = ProductCollection::select('products.*')
            // ->join('products', 'products.id', '=', 'product_collections.product_id');
            // $products = $query->where('collection_id', $data->id)->get();

            // $products = DB::select('SELECT products.* from product_collections
            // JOIN products ON products.id = product_collections.product_id
            // WHERE product_collections.collection_id = '.$data->id.'
            // ');

            // dd($products);

            return view('front.collection.detail', compact('data'));
        } else {
            return redirect()->route('front.error.404');
        }

        /*
        $orderBy = "products.view_count";
        $sortBy = "desc";

        if($request->order == "date-desc") {
            $orderBy = "products.id";
            $sortBy = "desc";
        } elseif($request->order == "price-asc") {
            $orderBy = "product_pricings.selling_price";
            $sortBy = "asc";
        } elseif($request->order == "price-desc") {
            $orderBy = "product_pricings.selling_price";
            $sortBy = "desc";
        }

        $category = ProductCategory1::where('slug', $slug)->where('parent_id', 0)->where('status', 1)->first();

        $products = Product::select('products.*')->join('product_categories', 'products.id', '=', 'product_categories.product_id')
        ->leftJoin('product_pricings', 'products.id', '=', 'product_pricings.product_id')
        ->where('product_categories.category_id', $category->id)
        ->where('products.status', 1)
        ->orderBy($orderBy, $sortBy)
        ->groupBy('products.id')
        ->paginate(30);

        if (!empty($category)) {
            return view('front.category.index', compact('category', 'products', 'request'));
        } else {
            return redirect()->route('front.error.404');
        }
        */
    }

}
