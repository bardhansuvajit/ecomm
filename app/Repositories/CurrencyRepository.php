<?php

namespace App\Repositories;

use App\Interfaces\CurrencyInterface;

use App\Models\Currency;

class CurrencyRepository implements CurrencyInterface
{
    public function listAll()
    {
        $data = Currency::where('status', 1)->orderBy('position')->get();

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Currency data found',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Currency data error'
            ];
        }

        return $response;
    }

    public function listPaginate(string $keyword)
    {
        $query = Currency::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('country', 'like', '%'.$keyword.'%')
            ->orWhere('full_name', 'like', '%'.$keyword.'%')
            ->orWhere('short_name', 'like', '%'.$keyword.'%')
            ->orWhere('entity', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(25);

        $response = [
            'status' => 'success',
            'message' => 'Currency data found',
            'data' => $data
        ];
        return $response;
    }
}
