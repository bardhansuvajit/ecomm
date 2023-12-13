<?php

namespace App\Interfaces;

interface CartInterface {
    // fetch cart data for logged-in/ guest user
    public function fetch();

    // auth does not work ajax, hence another function
    public function fetchAjax($userId);

    // remove cart data
    public function remove(int $cartId);

    // remove cart data
    public function saveToggle(int $cartId);

    // update cart product quantity
    public function qtyUpdate(int $id, int $qty);

    // update cart after login/ register
    public function update(string $token);

    // cart count - logged in user
    public function countLoggedInUser(int $userId);

    // cart count - guest user
    public function countGuestUser();
}
