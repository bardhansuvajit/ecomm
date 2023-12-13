<?php

namespace App\Repositories;

use App\Interfaces\PaymentMethodInterface;
use Illuminate\Support\Facades\DB;

use App\Models\PaymentMethod;

class PaymentMethodRepository implements PaymentMethodInterface
{
    public function listAll(string $keyword) : array
    {
        $query = PaymentMethod::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('value', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(25);

        $response = [
            'status' => 'success',
            'message' => 'Payment method data found',
            'data' => $data
        ];
        return $response;
    }

    public function listActive() : array
    {
        $query = PaymentMethod::where('status', 1)->orderBy('position')->get();

        $response = [
            'status' => 'success',
            'message' => 'Payment method data found',
            'data' => $query
        ];
        return $response;
    }

    public function listActiveCODCheck(int $codFlag) : array
    {
        if ($codFlag == 1) {
            $query = PaymentMethod::orderBy('position')->get()->toArray();
        } else {
            $query = PaymentMethod::where('value', '!=', 'cash-on-delivery')->orderBy('position')->get()->toArray();
        }

        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'Payment method data found',
                'data' => $query
            ];
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'Data not found',
            ];
        }

        return $response;
    }


}
