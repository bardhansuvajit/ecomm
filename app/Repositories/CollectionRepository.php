<?php

namespace App\Repositories;

use App\Interfaces\CollectionInterface;

use App\Models\Collection;

class CollectionRepository implements CollectionInterface
{
    public function listAllActive()
    {
        $data = Collection::where('status', 1)->orderBy('position')->get();

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

    public function detailBySlug(string $slug)
    {
        $data = Collection::where('slug', $slug)->where('status', 1)->first();

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
