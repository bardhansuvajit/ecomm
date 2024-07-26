<?php

namespace App\Interfaces;

interface ActivityLogInterface {
    public function add(array $data);
    public function distinctProducts(int $userId, string $category, string $productId);
}
