<?php

namespace App\Interfaces;

interface CurrencyInterface {
    // get all currencies
    public function listAll();

    // get all currencies
    public function listPaginate(string $keyword);
}
