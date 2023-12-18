<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;

use App\Models\ProductCategory1;
use App\Models\ProductCategory2;
use App\Models\ProductCategory3;
use App\Models\ProductCategory4;

class CategoryRepository implements CategoryInterface
{
    public function listAllActiveCat1() : array
    {
        $data = ProductCategory1::where('status', 1)->orderBy('position')->get();

        if (!empty($data)) {
            $response = [
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No data found',
            ];
        }

        return $response;
    }

    public function detailBySlug(string $slug, int $type) : array
    {
        if ($type == 1) {
            $data = ProductCategory1::where('slug', $slug)->where('status', 1)->first();
        } elseif ($type == 2) {
            $data = ProductCategory2::where('slug', $slug)->where('status', 1)->first();
        } elseif ($type == 3) {
            $data = ProductCategory3::where('slug', $slug)->where('status', 1)->first();
        } elseif ($type == 4) {
            $data = ProductCategory4::where('slug', $slug)->where('status', 1)->first();
        }

        if (!empty($data)) {
            $subs = [];
            if ($type == 1) {
                $subs = ProductCategory2::where('cat1_id', $data->id)
                ->where('status', 1)
                ->orderBy('position')
                ->get();
            } elseif ($type == 2) {
                $subs = ProductCategory3::where('cat2_id', $data->id)
                ->where('status', 1)
                ->orderBy('position')
                ->get();
            } elseif ($type == 3) {
                $subs = ProductCategory4::where('cat3_id', $data->id)
                ->where('status', 1)
                ->orderBy('position')
                ->get();
            }

            $response = [
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data,
                'subs' => $subs
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No data found',
            ];
        }

        return $response;
    }
}
