<?php

namespace App\Interfaces;

interface ProductReviewInterface {
    public function paginatedActiveReviewsByProduct(int $productId);
    public function create(array $data);
}
