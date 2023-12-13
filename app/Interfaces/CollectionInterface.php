<?php

namespace App\Interfaces;

interface CollectionInterface {
    // find all active
    public function listAllActive();

    // find detail by slug
    public function detailBySlug(string $slug);
}
