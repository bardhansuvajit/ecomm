<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\StateInterface;

class StateController extends Controller
{
    private StateInterface $stateRepository;

    public function __construct(StateInterface $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function listByCountry(Request $request, $countryId)
    {
        $resp = $this->stateRepository->stateListByCountry($countryId);

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
