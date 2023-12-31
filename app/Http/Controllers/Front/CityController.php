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
        dd($stateId);
    }

}
