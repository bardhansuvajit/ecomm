<?php

namespace App\Repositories;

use App\Interfaces\CityInterface;

use App\Models\City;

class CityRepository implements CityInterface
{
    public function cityListByState(int $stateId) : array
    {
        $query = City::where('state_id', $stateId)->orderBy('name')->get()->toArray();

        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'City data found',
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
