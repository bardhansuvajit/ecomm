<?php

namespace App\Repositories;

use App\Interfaces\StateInterface;
use App\Interfaces\CityInterface;

use App\Models\State;

class StateRepository implements StateInterface
{
    private CityInterface $cityRepository;

    public function __construct(CityInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function listAll(string $keyword) : array
    {
        $query = State::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('shortname', 'like', '%'.$keyword.'%')
            ->orWhere('phonecode', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(25);

        $response = [
            'status' => 'success',
            'message' => 'State data found',
            'data' => $data
        ];
        return $response;
    }

    public function listActive() : array
    {
        $query = State::where('shipping_available', 1)->orderBy('name')->get();

        $response = [
            'status' => 'success',
            'message' => 'State data found',
            'data' => $query
        ];
        return $response;
    }

    public function stateListByCountry(int $countryId) : array
    {
        $query = State::where('country_id', $countryId)->orderBy('name')->get()->toArray();

        if ($query) {
            $response = [
                'status' => 'success',
                'message' => 'State data found',
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

    public function detail(int $stateId) : array
    {
        $query = State::findOrFail($stateId);

        if ($query) {
            $cities = $this->cityRepository->cityListByState($stateId);

            $response = [
                'status' => 'success',
                'message' => 'City data found',
                'data' => $cities
            ];
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Data not found'
            ];
        }

        return $response;
    }
}
