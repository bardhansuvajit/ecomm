<?php

namespace App\Repositories;
use App\Interfaces\VariationInterface;
use Illuminate\Support\Facades\DB;

use App\Models\Variation;

class VariationRepository implements VariationInterface
{
    public function list(array $request, ?array $orderBy) : array
    {
        $status = $request['status'] ?? '';
        $keyword = $request['keyword'] ?? '';
        $page = $request['page'] ?? '';
        $id = $request['parent'] ?? '';
        $category = $request['category'] ?? '';

        DB::enableQueryLog();

        $query = Variation::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('variations.title', 'like', '%'.$keyword.'%');
        });

        $query->when($id, function($query) use ($id) {
            $query->where('variations.id', $id);
        });

        if ($category) {
            $query->join('variation_options', 'variation_options.variation_id', '=', 'variations.id')
                  ->where('variation_options.category', 'like', '%'.$category.'%')
                  ->where('variation_options.status', 1)
                  ->groupBy('variations.id');
        }

        // $query->when($category, function($query) use ($category) {
        //     $query->join('variation_options', 'variation_options.variation_id', '=', 'variations.id')
        //           ->where('variation_options.category', 'like', '%'.$category.'%')
        //           ->groupBy('variations.id');
        // });

        $query->when(($status == 0) || ($status == 1), function($query) use ($status) {
            $query->where('variations.status', $status);
        });

        if (!empty($orderBy) && count($orderBy) > 0) {
            $query->orderBy('variations.'.$orderBy[0], $orderBy[1] ?? 'asc');
        } else {
            $query->latest('variations.id');
        }

        if (empty($page)) {
            $data = $query->paginate(applicationSettings()->pagination_items_per_page);
        } else {
            if ($page == 'all') {
                $data = $query->get();
            } else {
                $data = $query->paginate($page);
            }
        }

        // dd(DB::getQueryLog());

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

    /*
    public function listActive(?array $orderBy) : array
    {
        $query = Variation::query()->where('status', 1);

        if (!empty($orderBy) && count($orderBy) > 0) {
            $query->orderBy($orderBy[0], $orderBy[1] ?? 'asc');
        } else {
            $query->latest('id');
        }

        $data = $query->get();

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
    */

    public function store(array $req) : array
    {
        $data = new Variation();
        $data->title = $req['title'];
        $data->short_description = $req['short_description'] ?? null;
        $data->long_description = $req['long_description'] ?? null;
        $data->position = positionSet('variations');
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
        $data = Variation::find($id);

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
        $data = Variation::find($req['id']);

        if (!empty($data)) {
            $data->title = $req['title'];
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
        $data = Variation::find($id);

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
        $data = Variation::find($id);

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
            $data = Variation::find($id);

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

}
