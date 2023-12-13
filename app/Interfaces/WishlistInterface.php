<?php

namespace App\Interfaces;

interface WishlistInterface {
    // toggle
    public function toggle(int $productId, int $userId);

    // find by user id
    public function findByUser(int $userId);
}
