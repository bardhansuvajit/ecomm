<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Interfaces\CountryInterface;

class CountryController extends Controller
{
    private CountryInterface $countryRepository;

    public function __construct(CountryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function detail(Request $request, $id) {
        $resp = $this->countryRepository->detail($id);

        if ($resp) {
            return response()->json([
                'status' => 200,
                'message' => 'Country detail found',
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
