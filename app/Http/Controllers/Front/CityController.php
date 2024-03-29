<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CityInterface;

class CityController extends Controller
{
    private CityInterface $cityRepository;

    public function __construct(CityInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function listByState(Request $request, $stateId)
    {
        $resp = $this->cityRepository->cityListByState($stateId);

        if ($resp['status'] == 'success') {
            return response()->json([
                'status' => 200,
                'message' => $resp['message'],
                'data' => $resp['data'],
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Something happened. Try again'
            ]);
        }
    }

}
