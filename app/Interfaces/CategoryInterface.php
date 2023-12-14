<?php

namespace App\Interfaces;

interface CategoryInterface {
    // find all active
    public function listAllActiveCat1();

    // find detail by slug
    public function detailBySlug(string $slug, int $type);
}
