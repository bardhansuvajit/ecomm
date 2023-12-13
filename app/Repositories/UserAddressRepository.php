<?php

namespace App\Repositories;

use App\Interfaces\UserAddressInterface;

use App\Models\UserAddress;

class UserAddressRepository implements UserAddressInterface
{
    public function store(array $data) : array
    {
        // check
        $addressCheck = UserAddress::where('user_id', $data['user_id'])
        ->where('contact_no1', $data['contact_no1'])
        ->where('zipcode', $data['zipcode'])
        ->where('locality', $data['locality'])
        ->first();

        if (!empty($addressCheck)) {
            $response = [
                'status' => 'failure',
                'message' => 'This address is already added'
            ];
            return $response;
        }

        // address store
        $address = new UserAddress();
        $address->user_id = $data['user_id'];
        $address->full_name = $data['full_name'] ?? '';
        $address->contact_no1 = $data['contact_no1'] ?? '';
        $address->contact_no2 = $data['contact_no2'] ?? '';

        $address->zipcode = $data['zipcode'] ?? '';
        $address->country = $data['country'] ?? '';
        $address->state = $data['state'] ?? '';
        $address->city = $data['city'] ?? '';
        $address->street_address = $data['street_address'] ?? '';
        $address->locality = $data['locality'] ?? '';
        $address->landmark = $data['landmark'] ?? '';
        $address->type = $data['type'] ?? 'not specified';
        $address->type2 = $data['type2'] ?? 'delivery';
        $address->ip_address = ipfetch();

        // checking for selected/ default zipcode
        // $addressExists = UserAddress::where('ip_address', ipfetch())->first();
        $addressExists = UserAddress::where('user_id', $data['user_id'])
        ->where('type2', $data['type2'])
        ->update([
            'default' => 0
        ]);
        // if (count($addressExists) > 0) {
        //     $addressExists->default = 0;
        //     $addressExists->save();
        // }
        $address->default = 1;
        $address->save();

        $response = [
            'status' => 'success',
            'message' => 'Address added'
        ];
        return $response;


        /*
        // adding into user pincode
        $userpinCheck = UserPincode::where('ip_address', ipfetch())->where('locality', $request->locality)->first();

        if (empty($userpinCheck)) {
            $userpin = new UserPincode();
            $userpin->ip_address = ipfetch();
            $userpin->pincode = $request->pincode;
            $userpin->locality = $request->locality;
            $userpin->city = $request->city;
            $userpin->state = $request->state;
            $userpin->country = $request->country;

            // checking for selected/ default pincode
            $userpinExists = UserPincode::where('ip_address', ipfetch())->first();
            if (!empty($userpinExists)) {
                $userpinExists->selected = 0;
                $userpinExists->save();
            }
            $userpin->selected = 1;

            $userpin->save();
        }
        */
    }

    public function fetchDeliveryAddressesByUser(int $userId) : array
    {
        $response = [];

        $data = UserAddress::where('user_id', $userId)
        ->where('type2', 'delivery')
        ->orderBy('default', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Address found for this user',
                'data' => $data
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No address found for this user'
            ];
            return $response;
        }
    }

    public function fetchBillingAddressesByUser(int $userId) : array
    {
        $response = [];

        $data = UserAddress::where('user_id', $userId)
        ->where('type2', 'billing')
        ->orderBy('default', 'desc')
        ->orderBy('id', 'desc')
        ->get();

        if (count($data) > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Address found for this user',
                'data' => $data
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No address found for this user'
            ];
            return $response;
        }
    }

    public function removeBillingAddressAll(int $userId) : array
    {
        $response = [];

        $data = UserAddress::where('user_id', $userId)
        ->where('type2', 'billing')
        ->delete();

        if ($data) {
            $response = [
                'status' => 'success',
                'message' => 'Billing Address removed for this user',
                'data' => $data
            ];
            return $response;
        } else {
            $response = [
                'status' => 'failure',
                'message' => 'No address removed for this user'
            ];
            return $response;
        }
    }

    public function setDefault(int $addressId, int $userId) : array
    {
        // $userAddressCheck = UserAddress::where('user_id', $userId)->get();
        $userAddressCheck = UserAddress::where('user_id', $userId)->update(['default' => 0]);

        if ($userAddressCheck == 0) {
            $response = [
                'status' => 'failure',
                'message' => 'No address found for this user'
            ];
            return $response;
        }

        // $userAddressCheck->default = 0;
        // $userAddressCheck->save();

        $addressExists = UserAddress::where('id', $addressId)->update(['default' => 1]);
        $response = [
            'status' => 'success',
            'message' => 'Default address set'
        ];
        return $response;
    }

    public function orderAddress(int $userId, string $type2) : array
    {
        $address = UserAddress::where('user_id', $userId)->where('type2', $type2)->where('default', 1)->first();

        if (empty($address)) {
            $response = [
                'status' => 'failure',
                'message' => 'No address found'
            ];
            return $response;
        }

        $response = [
            'status' => 'success',
            'message' => 'Address found',
            'data' => $address
        ];
        return $response;
    }

    public function remove(int $addressId, int $userId) : array
    {
        $data = UserAddress::where('id', $addressId)->where('user_id', $userId)->delete();

        if ($data == 0) {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Address removed'
            ];
            return $response;
        }
    }

    public function detail(int $addressId, int $userId) : array
    {
        $data = UserAddress::where('id', $addressId)->where('user_id', $userId)->first();

        if (empty($data)) {
            $response = [
                'status' => 'failure',
                'message' => 'No address found'
            ];
            return $response;
        } else {
            $response = [
                'status' => 'success',
                'message' => 'Address found',
                'data' => $data
            ];
            return $response;
        }
    }

    public function update(array $data, int $userId) : array
    {
        // check
        $addressCheck = UserAddress::where('user_id', $userId)
        ->where('id', $data['id'])
        ->first();

        if (empty($addressCheck)) {
            $response = [
                'status' => 'failure',
                'message' => 'Something happened'
            ];
            return $response;
        }

        // address store
        $address = UserAddress::findOrFail($data['id']);
        $address->full_name = $data['full_name'] ?? '';
        $address->contact_no1 = $data['contact_no1'] ?? '';
        $address->contact_no2 = $data['contact_no2'] ?? '';

        $address->zipcode = $data['zipcode'] ?? '';
        $address->country = $data['country'] ?? '';
        $address->state = $data['state'] ?? '';
        $address->city = $data['city'] ?? '';
        $address->street_address = $data['street_address'] ?? '';
        $address->locality = $data['locality'] ?? '';
        $address->landmark = $data['landmark'] ?? '';
        $address->type = $data['type'] ?? 'not specified';
        $address->save();

        $response = [
            'status' => 'success',
            'message' => 'Address updated'
        ];
        return $response;
    }
}
