<?php

namespace App\Interfaces;

interface ProductInterface {
    public function allProductsToShow();
    public function activeProductsList();
    public function detailFrontend($slug);

    // public function listAll();
    // public function listActive();
    // public function listInactive();
    // public function findById($id);
}
