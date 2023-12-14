<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;

use App\Models\ProductCategory1;

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
        }

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
}
