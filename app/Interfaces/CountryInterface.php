<?php

namespace App\Interfaces;

interface CountryInterface {
    // fetch all
    public function listAll(string $keyword);

    // fetch shipping available
    public function listShippingOnly();

    // detail
    public function detail(int $id);
}
