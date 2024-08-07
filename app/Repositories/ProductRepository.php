<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Interfaces\ActivityLogInterface;
use Illuminate\Support\Facades\DB;

use App\Models\Product;

use Jenssegers\Agent\Agent;

class ProductRepository implements ProductInterface
{
    private ActivityLogInterface $activityLogRepository;

    public function __construct(ActivityLogInterface $activityLogRepository) {
        $this->activityLogRepository = $activityLogRepository;
    }

    public function allProductsToShow(): array
    {
        $frontShowProsuctsID = showInFrontendProductStatusID();
        $data = Product::whereIn('status', $frontShowProsuctsID)->orderBy('title')->get();

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Product fetched successfully',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
        }

        return $response;
    }

    public function activeProductsList(): array
    {
        $frontShowProsuctsID = showInFrontendProductStatusID();
        $data = Product::whereIn('status', $frontShowProsuctsID)->orderBy('title')->get();

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Product fetched successfully',
                'data' => $data,
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
        }

        return $response;
    }

    public function detailFrontend($slug): array
    {
        $frontShowProsuctsID = showInFrontendProductStatusID();
        $data = Product::where('slug', $slug)->whereIn('status', $frontShowProsuctsID)->first();

        if (!empty($data)) {
            // categories
            $categories = DB::select("SELECT pc.level, 
            c1.title AS c1_title, c1.slug AS c1_slug, 
            c2.title AS c2_title, c2.slug AS c2_slug, 
            c3.title AS c3_title, c3.slug AS c3_slug, 
            c4.title AS c4_title, c4.slug AS c4_slug 
            FROM `product_categories` AS pc
            LEFT JOIN product_category1s AS c1
            ON pc.category_id = c1.id AND pc.level = 1
            LEFT JOIN product_category2s AS c2
            ON pc.category_id = c2.id AND pc.level = 2
            LEFT JOIN product_category3s AS c3
            ON pc.category_id = c3.id AND pc.level = 3
            LEFT JOIN product_category4s AS c4
            ON pc.category_id = c4.id AND pc.level = 4
            WHERE product_id = ".$data->id."
            ORDER BY pc.level");

            // add to log
            $this->activityLogRepository->add([
                'id' => $data->id,
                'category' => 'product_watchlist',
                'trigger_type' => 'low',
            ]);

            $response = [
                'status' => 'success',
                'message' => 'Product data found',
                'data' => $data,
                'categories' => $categories,
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Product not found'
            ];
        }

        return $response;
    }

    /*
    public function listAll()
    {
        return Product::orderBy('id', 'desc')->paginate(applicationSettings()->pagination_items_per_page);
    }

    public function listActive()
    {
        return Product::where('status', 1)->orderBy('id', 'desc')->get();
    }

    public function listInactive()
    {
        return Product::where('status', 0)->orderBy('id', 'desc')->get();
    }

    public function findById($id)
    {
        return Product::findOrFail($id);
    }
    */

}
