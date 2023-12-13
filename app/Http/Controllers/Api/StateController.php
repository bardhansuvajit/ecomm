<?php

namespace App\Http\Controllers\Api;

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

    public function detail(Request $request, $id) {
        $resp = $this->stateRepository->detail($id);

        if ($resp) {
            return response()->json([
                'status' => 200,
                'message' => 'State detail found',
                'data' => $resp,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Data not found'
            ]);
        }
    }
}
