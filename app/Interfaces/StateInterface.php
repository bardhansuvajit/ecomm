<?php

namespace App\Interfaces;

interface StateInterface {
    // fetch all
    public function listAll(string $keyword);

    // fetch active
    public function listActive();

    // states by country
    public function stateListByCountry(int $countryId);

    // states by country
    public function detail(int $stateId);
}
