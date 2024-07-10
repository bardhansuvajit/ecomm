<?php

namespace App\Repositories;
use App\Interfaces\VariationOptionInterface;

use App\Models\VariationOption;

class VariationOptionRepository implements VariationOptionInterface
{
    public function list(array $request, ?array $orderBy) : array
    {
        $status = $request['status'] ?? '';
        $keyword = $request['keyword'] ?? '';
        $variation = $request['variation'] ?? '';
        $category = $request['category'] ?? '';

        $query = VariationOption::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('value', 'like', '%'.$keyword.'%')
            ->orWhere('category', 'like', '%'.$keyword.'%')
            ->orWhere('equivalent', 'like', '%'.$keyword.'%')
            ->orWhere('information', 'like', '%'.$keyword.'%');
        });

        $query->when($variation, function($query) use ($variation) {
            $query->where('variation_id', $variation);
        });

        $query->when($category, function($query) use ($category) {
            $query->where('category', 'like', '%'.$category.'%');
        });

        $query->when(($status == 0) || ($status == 1), function($query) use ($status) {
            $query->where('status', $status);
        });

        if (!empty($orderBy) && count($orderBy) > 0) {
            $query->orderBy($orderBy[0], $orderBy[1] ?? 'asc');
        } else {
            $query->latest('id');
        }

        $data = $query->paginate(applicationSettings()->pagination_items_per_page);

        if (count($data) > 0) {
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Data not found',
            ];
        }

        return $response;
    }

    public function store(array $req) : array
    {
        $data = new VariationOption();
        $data->variation_id = $req['variation_id'];
        $data->value = $req['value'];
        $data->category = $req['category'] ?? 'all';
        $data->equivalent = $req['equivalent'] ?? null;
        $data->information = $req['information'] ?? null;
        $data->short_description = $req['short_description'] ?? null;
        $data->long_description = $req['long_description'] ?? null;
        $data->position = positionSet('variation_options');
        $data->save();

        if ($data) {
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data added',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Something happened',
            ];
        }

        return $response;
    }

    public function detail(int $id) : array
    {
        $data = VariationOption::find($id);

        if (!empty($data)) {
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Data not found',
            ];
        }

        return $response;
    }

    public function update(array $req) : array
    {
        $data = VariationOption::find($req['id']);

        if (!empty($data)) {
            $data->variation_id = $req['variation_id'];
            $data->value = $req['value'];
            $data->category = $req['category'] ?? 'all';
            $data->equivalent = $req['equivalent'] ?? null;
            $data->information = $req['information'] ?? null;
            $data->short_description = $req['short_description'] ?? null;
            $data->long_description = $req['long_description'] ?? null;
            $data->save();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data updated',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Something happened',
            ];
        }

        return $response;
    }

    public function delete(int $id) : array {
        $data = VariationOption::find($id);

        if (!empty($data)) {
            $data->delete();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data removed',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Something happened',
            ];
        }

        return $response;
    }

    public function status(int $id) : array {
        $data = VariationOption::find($id);

        if (!empty($data)) {
            $data->status = ($data->status == 1) ? 0 : 1;
            $data->update();

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data status updated',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'Something happened',
            ];
        }

        return $response;
    }

    public function position(array $ids) : array {
        $count = 1;
        foreach($ids as $id) {
            $data = VariationOption::find($id);

            if (!empty($data)) {
                $data->position = $count;
                $data->save();

                $count++;
            } else {
                $response = [
                    'code' => 400,
                    'status' => 'failure',
                    'message' => 'Something happened',
                ];
            }
        }

        $response = [
            'code' => 200,
            'status' => 'success',
            'message' => 'Position updated',
            'data' => $data
        ];

        return $response;
    }

    public function categories() : array {
        $all_categories = VariationOption::select('category')
        ->where('category', '!=', null)
        ->groupBy('category')
        ->get();

        if (count($all_categories) > 0) {
            $data = [];

            foreach($all_categories as $category) {
                $new = explode(',', $category->category);
                $data = array_merge($data, $new);
            }
            $data = array_unique($data);

            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Data found',
                'data' => $data
            ];
        } else {
            $response = [
                'code' => 400,
                'status' => 'failure',
                'message' => 'No data found',
            ];
        }

        return $response;
    }

}
