<?php

namespace App\Interfaces;

interface PaymentMethodInterface {
    // fetch all
    public function listAll(string $keyword);

    // fetch active
    public function listActive();

    // fetch active
    public function listActiveCODCheck(int $codFlag);
}
