<?php

namespace App\Interfaces;

interface CouponInterface {
    // check if coupon is applicable to cart/ order products
    public function check(string $code);

    // remove coupon from cart/ order products
    public function remove(object $cartData);

    // get all coupons
    public function listAll(string $keyword);

    // get public coupons
    public function listPublic();

    // create coupons
    public function create(array $data);

    // coupon detail
    public function detail(int $id);

    // update coupons
    public function update(array $data);

    // delete coupon
    public function delete(int $id);

    // status update for coupon
    public function status(int $id);

    // status update for coupon
    public function position(array $position);
}
