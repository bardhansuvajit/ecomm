<?php

namespace App\Interfaces;

interface UserAddressInterface {
    // store data
    public function store(array $data);

    // fetch only delivery addresses by user id
    public function fetchDeliveryAddressesByUser(int $userId);

    // fetch only billing addresses by user id
    public function fetchBillingAddressesByUser(int $userId);

    // remove all billing addresses by user id
    public function removeBillingAddressAll(int $userId);

    // default set
    public function setDefault(int $addressId, int $userId);

    // order address (delivery/ billing)
    public function orderAddress(int $userId, string $type2);

    // remove
    public function remove(int $addressId, int $userId);

    // detail
    public function detail(int $addressId, int $userId);

    // update
    public function update(array $data, int $userId);
}
