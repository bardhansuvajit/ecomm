<?php

namespace App\Interfaces;

interface ProductVariationInterface {
    public function detail(int $id);
    public function toggle(array $req);
    public function update(array $req);
    public function status(int $id);
    public function delete(int $id);
    public function position(array $ids);
    public function price(array $req);
    
    public function thumbRemove(int $id);
    public function thumbStatus(int $id);

    public function images(array $req);
}
