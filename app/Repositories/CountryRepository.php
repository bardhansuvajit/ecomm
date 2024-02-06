<?php

namespace App\Repositories;

use App\Interfaces\CountryInterface;
use App\Interfaces\PaymentMethodInterface;
use App\Interfaces\StateInterface;

use App\Models\Country;

class CountryRepository implements CountryInterface
{
    private PaymentMethodInterface $paymentMethodRepository;
    private StateInterface $stateRepository;

    public function __construct(PaymentMethodInterface $paymentMethodRepository, StateInterface $stateRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->stateRepository = $stateRepository;
    }

    public function listAll(string $keyword) : array
    {
        $query = Country::query();

        $query->when($keyword, function($query) use ($keyword) {
            $query->where('name', 'like', '%'.$keyword.'%')
            ->orWhere('shortname', 'like', '%'.$keyword.'%')
            ->orWhere('phonecode', 'like', '%'.$keyword.'%');
        });

        $data = $query->orderBy('position')->paginate(applicationSettings()->pagination_items_per_page);

        $response = [
            'status' => 'success',
            'message' => 'Country data found',
            'data' => $data
        ];
        return $response;
    }

    public function listShippingOnly() : array
    {
        $query = Country::where('shipping_available', 1)->orderBy('name')->get();

        $response = [
            'status' => 'success',
            'message' => 'Country data found',
            'data' => $query
        ];
        return $response;
    }

    public function detail(int $id) : array
    {
        $query = Country::findOrFail($id);

        if ($query) {
            $payment_methods = $this->paymentMethodRepository->listActiveCODCheck($query->cash_on_delivery_available);
            $states = $this->stateRepository->stateListByCountry($id);

            $data = [
                'country_detail' => $query,
                'payment_methods' => $payment_methods,
                'states' => $states
            ];

            $response = [
                'status' => 'success',
                'message' => 'Country data found',
                'data' => $data
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
