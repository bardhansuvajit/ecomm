<?php

namespace App\Interfaces;

interface VariationInterface {
    public function listPaginated(array $request, ?array $orderBy);
    public function listActive(?array $orderBy);
    public function store(array $req);
    public function detail(int $id);
    public function update(array $req);
    public function delete(int $id);
    public function status(int $id);
    public function position(array $ids);
}
