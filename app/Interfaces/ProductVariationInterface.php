<?php

namespace App\Interfaces;

interface ProductVariationInterface {
    public function detail(int $id);
    public function toggle(array $req);
    public function update(array $req);
}
